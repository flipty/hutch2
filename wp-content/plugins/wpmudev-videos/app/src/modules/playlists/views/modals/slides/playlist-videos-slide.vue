<template>
	<div :id="`${form}-playlist-videos`" class="sui-modal-slide">
		<div class="sui-box">
			<div
				class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60 sui-spacing-sides--100"
			>
				<whitelabel-modal-banner
					src="modal/modal-header-playlists.png"
					:alt="$i18n.playlists.labels.create_playlist"
				/>

				<button
					@click="$emit('dismiss')"
					class="sui-button-icon sui-button-float--right"
				>
					<sui-icon icon="close" size="md" />
					<span class="sui-screen-reader-text">
						{{ $i18n.dialogs.close }}
					</span>
				</button>

				<button
					class="sui-button-icon sui-button-float--left"
					:data-modal-slide="`${form}-playlist-settings`"
					data-modal-slide-intro="back"
				>
					<sui-icon icon="chevron-left" size="md" />
					<span class="sui-screen-reader-text">
						{{ $i18n.dialogs.go_back }}
					</span>
				</button>

				<h3 :id="`${form}-title`" class="sui-box-title sui-lg">
					{{ $i18n.playlists.labels.create_playlist }}
				</h3>

				<p :id="`${form}-desc`" class="sui-description">
					{{ $i18n.playlists.descriptions.select_videos }}
				</p>
			</div>

			<div class="sui-box-body">
				<sui-notice type="error" v-if="error">
					<p>{{ getErrorMessage }}</p>
				</sui-notice>

				<!-- Video search -->
				<videos-search :form="form" />

				<!-- When membership is not valid -->
				<upgrade-notice v-if="showUpgradeNotice" />
				<!-- When membership is expired -->
				<expired-notice v-else-if="showExpiredNotice" />
				<!-- When dash is inactive -->
				<dash-notice v-else-if="showDashNotice" />
			</div>

			<!-- Video list -->
			<videos-list
				:form="form"
				:playlist.sync="playlist"
				:count.sync="videoCount"
			/>

			<div class="sui-box-footer">
				<button
					class="sui-button sui-button-ghost"
					data-modal-slide-intro="back"
					:data-modal-slide="`${form}-playlist-settings`"
				>
					{{ $i18n.buttons.back }}
				</button>
				<div class="sui-actions-right">
					<button
						type="button"
						class="sui-button sui-button-blue"
						aria-live="polite"
						:class="loadingClass"
						:disabled="!canSubmit"
						@click="createPlaylist"
					>
						<span class="sui-button-text-default">
							{{ $i18n.playlists.buttons.create_playlist }}
						</span>
						<span class="sui-button-text-onload">
							<sui-icon icon="loader" class="sui-loading" />
							{{ $i18n.playlists.buttons.creating_playlist }}
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import SuiNotice from '@/components/sui/sui-notice'
import { createPlaylist } from '@/helpers/playlists'
import ImageTag from '@/components/elements/image-tag'
import DashNotice from './../../../components/notices/dash-notice'
import VideosList from './../../../components/sections/videos-list'
import VideosSearch from './../../../components/sections/videos-search'
import ExpiredNotice from './../../../components/notices/expired-notice'
import UpgradeNotice from './../../../components/notices/upgrade-notice'
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'

export default {
	name: 'PlaylistVideosSlide',

	components: {
		SuiIcon,
		ImageTag,
		SuiNotice,
		VideosList,
		DashNotice,
		VideosSearch,
		ExpiredNotice,
		UpgradeNotice,
		WhitelabelModalBanner,
	},

	props: {
		form: {
			type: String,
			required: true,
		},
		playlist: {
			type: Object,
			required: true,
		},
	},

	data() {
		return {
			saving: false,
			error: false,
			errorMessage: '',
			videos: this.$store.state.videos.filtered,
			videoCount: 0,
		}
	},

	computed: {
		/**
		 * Add loading class if playlist is being created.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.saving,
			}
		},

		/**
		 * Check if we can submit the form.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		canSubmit() {
			return this.playlist.title.length > 0
		},

		/**
		 * Check if we need to show the Dash install/login notice.
		 *
		 * @since 1.8.4
		 *
		 * @return {boolean}
		 */
		showDashNotice() {
			return !this.validMember() && this.videoCount <= 0
		},

		/**
		 * Check if we need to show the membership upgrade notice.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		showUpgradeNotice() {
			return (
				!this.expiredMember() &&
				!this.validMember() &&
				this.dashConnected() &&
				this.videoCount <= 0
			)
		},

		/**
		 * Check if we need to show the membership expired notice.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		showExpiredNotice() {
			return (
				this.expiredMember() &&
				this.dashConnected() &&
				this.videoCount <= 0
			)
		},

		/**
		 * Get error message.
		 *
		 * @since 1.8.4
		 *
		 * @return {string}
		 */
		getErrorMessage() {
			return !!this.errorMessage
				? this.errorMessage
				: this.$i18n.playlists.notices.playlist_create_failed
		},
	},

	methods: {
		/**
		 * Publish the current playlist using the API.
		 *
		 * This is an async function which will wait for the
		 * API response.
		 *
		 * @since 1.8.0
		 *
		 * @return {Promise<void>}
		 */
		async createPlaylist() {
			this.saving = true
			this.error = false

			// Save the playlist.
			let result = await createPlaylist({
				title: this.playlist.title,
				description: this.playlist.description,
				videos: this.playlist.videos || [],
				locations: this.playlist.locations || [],
				thumbnail: this.playlist.thumbnail.id || 0,
			})

			// If success.
			if (result.success && result.playlist) {
				// Close the modal.
				this.$emit('dismiss')

				// Fire created event.
				this.$root.$emit('customPlaylistCreated', result.playlist)

				// Show success notice.
				this.$root.$emit('showTopNotice', {
					message: this.$i18n.playlists.notices.playlist_created,
					dismiss: true,
				})
			} else if (result.data) {
				// Handle error response.
				this.handleError(result.data)
			}

			// Remove loading flag.
			this.saving = false
		},

		/**
		 * Handle playlist create error response.
		 *
		 * @param {object} data Response data.
		 *
		 * @since 1.8.4
		 */
		handleError(data) {
			// Set error flag.
			this.error = true
			// Revert to default error message.
			this.errorMessage = ''

			// If error message available from reponse.
			if (data.params) {
				this.errorMessage = Object.values(data.params)[0]
			}

			// Scroll to top to see the error.
			this.scrollTop()
		},

		/**
		 * Scroll to top of the modal.
		 *
		 * Use this to show error messages after scrolling
		 * down for the form submit.
		 *
		 * @since 1.8.4
		 */
		scrollTop() {
			document
				.getElementById('wpmudev-videos-playlist-create-modal')
				.scrollIntoView({
					behavior: 'smooth',
					block: 'start',
					inline: 'nearest',
				})
		},
	},
}
</script>
