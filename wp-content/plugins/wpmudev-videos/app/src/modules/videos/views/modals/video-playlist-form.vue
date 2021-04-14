<template>
	<div class="sui-modal sui-modal-sm">
		<div
			role="dialog"
			:id="modal"
			class="sui-modal-content sui-content-fade-out"
			aria-modal="true"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-title`"
		>
			<div class="sui-box">
				<div
					class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60"
				>
					<button
						class="sui-button-icon sui-button-float--right"
						@click="closeModal"
						:id="`${modal}-close`"
					>
						<i class="sui-icon-close sui-md" aria-hidden="true"></i>
						<span class="sui-screen-reader-text">
							{{ $i18n.dialogs.close }}
						</span>
					</button>

					<h3 :id="`${modal}-title`" class="sui-box-title sui-lg">
						{{ $i18n.videos.labels.add_to_playlist }}
					</h3>

					<p :id="`${modal}-desc`" class="sui-description">
						{{
							sprintf(
								$i18n.videos.descriptions.add_to_playlist,
								video.video_title
							)
						}}
					</p>
				</div>

				<div class="sui-box-body">
					<div class="sui-form-field">
						<label
							v-for="playlist in playlists"
							:for="`${modal}-playlist-${playlist.id}`"
							class="sui-checkbox sui-checkbox-sm sui-checkbox-stacked"
							:key="playlist.id"
						>
							<input
								type="checkbox"
								v-model="selected"
								:value="playlist.id"
								:id="`${modal}-playlist-${playlist.id}`"
								:aria-labelledby="`${modal}-playlist-${playlist.id}-label`"
							/>
							<span aria-hidden="true"></span>
							<span
								:id="`${modal}-playlist-${playlist.id}-label`"
							>
								{{ playlist.title }}
							</span>
						</label>
					</div>
				</div>

				<div class="sui-box-footer sui-flatten sui-content-center">
					<button
						type="button"
						class="sui-button sui-button-blue"
						aria-live="polite"
						@click="saveChanges"
						:class="loadingClass"
						:disabled="selected.length < 1"
					>
						<span class="sui-button-text-default">
							{{ $i18n.videos.buttons.add_to_playlist }}
						</span>
						<span class="sui-button-text-onload">
							<i
								class="sui-icon-loader sui-loading"
								aria-hidden="true"
							></i>
							{{ $i18n.videos.buttons.adding_to_playlist }}
						</span>
					</button>
				</div>

				<whitelabel-modal-banner
					src="summary/dashboard.png"
					img-class="sui-image sui-image-center"
					:alt="$i18n.videos.labels.video_title"
				/>
			</div>
		</div>
	</div>
</template>

<script>
import { mapState } from 'vuex'
import { restPost } from '@/helpers/api'
import Modal from '@/components/mixins/modal'
import SuiNotice from '@/components/sui/sui-notice'
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'

export default {
	name: 'VideoPlaylistForm',

	components: {
		SuiNotice,
		WhitelabelModalBanner,
	},

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-video-playlist-modal',
			video: {},
			selected: [],
			processing: false,
		}
	},

	created() {
		// Open the modal on event.
		this.$root.$on('openVideoPlaylistFormModal', (data) => {
			this.video = data.video
			this.selected = data.video.playlists
			this.closeFocus = data.focus
			this.openFocus = this.modal + '-close'

			this.openModal()
		})
	},

	computed: {
		/**
		 * Get the button loading class.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.processing,
			}
		},

		/**
		 * Map the playlists vuext data.11
		 *
		 * @since 1.8.0
		 *
		 * @returns {objects}
		 */
		...mapState('playlists', ['playlists']),
	},

	methods: {
		/**
		 * Save the video playlists using API.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		saveChanges() {
			// Do not continue if no playlist is selected.
			if (this.selected.length < 1) {
				return
			}

			this.processing = true

			restPost({
				path: 'videos/' + this.video.id,
				data: {
					playlist: this.selected,
				},
			}).then((response) => {
				if (response.success && response.data) {
					this.$root.$emit('showTopNotice', {
						message: sprintf(
							this.$i18n.videos.notices.video_playlist_updated,
							this.video.video_title
						),
					})

					this.$root.$emit('videoUpdated', response.data)

					this.closeModal()
				}

				this.processing = false
			})
		},
	},
}
</script>
