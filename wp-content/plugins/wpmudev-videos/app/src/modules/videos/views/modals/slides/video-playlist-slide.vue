<template>
	<div
		:id="`${form}-playlist-form`"
		class="sui-modal-slide"
		data-modal-size="lg"
	>
		<div class="sui-box">
			<div
				class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60"
			>
				<whitelabel-modal-banner
					src="modal/modal-header-playlists.png"
					:alt="$i18n.videos.labels.add_custom_video"
				/>

				<button
					@click="$emit('dismiss')"
					class="sui-button-icon sui-button-float--right"
				>
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text">
						{{ $i18n.dialogs.close }}
					</span>
				</button>

				<button
					class="sui-button-icon sui-button-float--left"
					:data-modal-slide="prev"
					data-modal-slide-intro="back"
				>
					<i
						class="sui-icon-chevron-left sui-md"
						aria-hidden="true"
					></i>
					<span class="sui-screen-reader-text">
						{{ $i18n.dialogs.go_back }}
					</span>
				</button>

				<h3 :id="`${form}-title`" class="sui-box-title sui-lg">
					{{ $i18n.videos.labels.add_custom_video }}
				</h3>

				<p :id="`${form}-desc`" class="sui-description">
					{{ $i18n.videos.descriptions.assign_playlist }}
				</p>
			</div>

			<div class="sui-box-body">
				<sui-notice type="error" v-if="error">
					<p>{{ $i18n.videos.notices.error_publishing }}</p>
				</sui-notice>
				<sui-notice type="info">
					<p>{{ $i18n.videos.notices.select_one_playlist }}</p>
				</sui-notice>

				<div class="sui-form-field">
					<label
						class="sui-label"
						:for="`${form}-playlist`"
						:id="`${form}-playlist-label`"
					>
						{{ $i18n.videos.labels.choose_playlist }}
					</label>
					<sui-select2
						parent-element="wpmudev-videos-video-create-modal"
						v-model="playlist"
						:id="`${form}-playlist`"
						:options="getFormattedOptions"
						:multiple="true"
						:label-id="`${form}-playlist-label`"
						:placeholder="$i18n.videos.labels.choose_playlist"
					/>
				</div>
			</div>

			<div class="sui-box-footer sui-flatten sui-content-center">
				<button
					type="button"
					class="sui-button"
					aria-live="polite"
					:class="loadingClass"
					@click="publishVideo"
				>
					<span class="sui-button-text-default">
						{{ $i18n.videos.buttons.publish }}
					</span>
					<span class="sui-button-text-onload">
						<i
							class="sui-icon-loader sui-loading"
							aria-hidden="true"
						></i>
						{{ $i18n.videos.buttons.publishing }}
					</span>
				</button>
			</div>
		</div>
	</div>
</template>

<script>
import { mapState } from 'vuex'
import { createVideo } from '@/helpers/videos'
import SuiNotice from '@/components/sui/sui-notice'
import SuiSelect2 from '@/components/sui/sui-select2'
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'

export default {
	name: 'VideoPlaylistSlide',

	components: {
		SuiSelect2,
		SuiNotice,
		WhitelabelModalBanner,
	},

	props: {
		prev: {
			type: String,
			required: true,
		},
		form: {
			type: String,
			required: true,
		},
		video: {
			type: Object,
			required: true,
		},
	},

	data() {
		return {
			error: false,
			publishing: false,
		}
	},

	computed: {
		/**
		 * Add loading class if video is being published.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.publishing,
			}
		},

		/**
		 * Playlist computed object.
		 *
		 * @since 1.8.0
		 *
		 * @returns {array}
		 */
		playlist: {
			get() {
				return this.video.playlists || []
			},

			set(playlist) {
				let data = this.video

				// Set playlist.
				data.playlists = playlist || []

				this.$emit('update:video', data)
			},
		},

		/**
		 * Format the playlist data to Select2 format.
		 *
		 * Select2 accept id and text as option object.
		 *
		 * @since 1.8.0
		 *
		 * @return {array}
		 */
		getFormattedOptions() {
			let list = []
			// Get the playlists from vuex.
			let playlists = this.playlists

			// Format playlists.
			Object.keys(playlists).forEach(function (id) {
				list.push({
					id: id,
					text: playlists[id].title,
				})
			})

			return list
		},

		/**
		 * Format the playlist data to Select2 format.
		 *
		 * Select2 accept id and text as option object.
		 *
		 * @return {Array}
		 */
		...mapState('playlists', ['playlists']),
	},

	methods: {
		/**
		 * Publish the current video to WordPress.
		 *
		 * This is an async function which will wait for the
		 * API response.
		 *
		 * @since 1.8.0
		 *
		 * @return {Promise<void>}
		 */
		async publishVideo() {
			this.publishing = true

			// Save the video.
			let result = await createVideo({
				url: this.video.url,
				host: this.video.host,
				title: this.video.title,
				start_enabled: this.video.start_enabled,
				end_enabled: this.video.end_enabled,
				start_time: this.video.start_time,
				end_time: this.video.end_time,
				playlists: this.video.playlists,
				thumbnail: this.video.thumbnail.id || 0,
				duration: this.video.duration,
			})

			// Set error flag.
			this.error = !result.success

			// If success.
			if (result.success && result.video) {
				// Close the modal.
				this.$emit('dismiss')

				// Fire created event.
				this.$root.$emit('customVideoCreated', result.video)

				let message =
					result.video.view_link && '' !== result.video.view_link
						? this.$i18n.videos.notices.video_published
						: this.$i18n.videos.notices.video_published_wo_playlist

				// Show success notice.
				this.$root.$emit('showTopNotice', {
					message: sprintf(message, result.video.view_link),
					dismiss: true,
				})
			}

			// Remove loading flag.
			this.publishing = false
		},
	},
}
</script>
