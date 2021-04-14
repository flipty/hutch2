<template>
	<div class="sui-modal sui-modal-lg">
		<div
			role="dialog"
			class="sui-modal-content sui-content-fade-out"
			aria-modal="true"
			:id="modal"
			:aria-labelledby="`${modal}-title`"
		>
			<div class="sui-box">
				<div class="sui-box-header sui-flatten">
					<h3 :id="`${modal}-title`" class="sui-box-title">
						{{ $i18n.videos.labels.edit_video }}
					</h3>

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
				</div>

				<div
					class="sui-box-selectors sui-box-selectors-col-2"
					v-if="showForm"
				>
					<!-- Error notice -->
					<sui-notice type="error" v-if="showError">
						<p>{{ $i18n.videos.notices.invalid_url_attached }}</p>
					</sui-notice>

					<div class="sui-form-field" :class="errorClass">
						<label
							:for="`${modal}-video-url`"
							:id="`${modal}-video-url-label`"
							class="sui-label"
						>
							{{ $i18n.videos.labels.video_url }}
						</label>
						<!-- Video URL form -->
						<video-url
							:form="modal"
							:video.sync="video"
							@clearUrl="handleClearUrl"
							@embedUpdate="handleEmbedUpdate"
						/>
					</div>

					<div class="sui-row" v-if="showSettingsFields">
						<div class="sui-col">
							<video-preview :form="modal" :video.sync="video" />
						</div>

						<div class="sui-col">
							<div class="sui-form-field">
								<video-title
									:form="modal"
									:video.sync="video"
								/>
								<span
									v-if="showDuration"
									class="sui-description"
								>
									{{
										sprintf(
											$i18n.videos.labels.video_duration,
											video.duration
										)
									}}
								</span>
							</div>
						</div>
					</div>
				</div>

				<video-settings
					v-if="showSettingsFields"
					:form="modal"
					:video.sync="video"
				/>

				<div
					class="sui-box-footer sui-flatten sui-content-center"
					v-if="showForm"
				>
					<button
						type="button"
						class="sui-button sui-button-blue"
						aria-live="polite"
						@click="saveChanges"
						:class="loadingClass"
						:disabled="!showSettingsFields"
					>
						<span class="sui-button-text-default">
							{{ $i18n.buttons.save_changes }}
						</span>
						<span class="sui-button-text-onload">
							<i
								class="sui-icon-loader sui-loading"
								aria-hidden="true"
							></i>
							{{ $i18n.videos.buttons.saving_changes }}
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Modal from '@/components/mixins/modal'
import { updateVideo } from '@/helpers/videos'
import SuiNotice from '@/components/sui/sui-notice'
import VideoUrl from './../../components/fields/video-url'
import VideoTitle from './../../components/fields/video-title'
import VideoPreview from './../../components/fields/video-preview'
import VideoEndTime from './../../components/fields/video-end-time'
import VideoSettings from './../../components/sections/video-settings'
import VideoThumbnail from './../../components/fields/video-thumbnail'
import VideoStartTime from './../../components/fields/video-start-time'

export default {
	name: 'VideoEditForm',

	components: {
		VideoUrl,
		SuiNotice,
		VideoTitle,
		VideoPreview,
		VideoEndTime,
		VideoSettings,
		VideoThumbnail,
		VideoStartTime,
	},

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-video-edit-modal',
			saving: false,
			showForm: false,
			showError: false,
			showSettings: true,
			video: {
				id: 0,
				host: '',
				url: '',
				title: '',
				start_enabled: 0,
				end_enabled: 0,
				start_time: '',
				end_time: '',
				playlists: [],
				thumbnail: {
					id: 0,
					file: '',
					url: '',
				},
				duration: '',
				embed: '',
			},
		}
	},

	created() {
		// Open modal on event.
		this.$root.$on('openVideoEditFormModal', (data) => {
			this.setVideo(data.video)
			this.closeFocus = data.focus
			this.openFocus = this.modal + '-close'
			this.showSettings = true
			this.showForm = true
			this.showError = false

			this.openModal()
		})
	},

	computed: {
		/**
		 * Loading class during save.
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
		 * Error class if error happen.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		errorClass() {
			return {
				'sui-form-field-error': this.showError,
			}
		},

		/**
		 * Should we show video duration.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		showDuration() {
			return !['', '00.00', 0, '0'].includes(this.video.duration)
		},

		/**
		 * Check if we can show the settings.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		showSettingsFields() {
			return this.showForm && this.showSettings
		},
	},

	methods: {
		/**
		 * Set video fields from current video.
		 *
		 * @param {object} video Video data.
		 *
		 * @since 1.8.0
		 */
		setVideo(video) {
			this.video = {
				id: video.id,
				host: video.video_host,
				url: video.video_url,
				title: video.video_title,
				start_enabled: video.video_start,
				end_enabled: video.video_end,
				start_time: video.video_start_time,
				end_time: video.video_end_time,
				playlists: video.playlists,
				thumbnail: video.thumbnail,
				duration: video.video_duration,
				embed: '',
			}
		},

		/**
		 * Save the video settings using API.
		 *
		 * Use the helper function so we don't have
		 * to worry about the Vuex.
		 *
		 * @since 1.8.0
		 */
		async saveChanges() {
			if (this.video.id > 0 && !this.saving) {
				// Get the video.
				let video = this.video

				// Set saving flag.
				this.saving = true

				// Update the video.
				let result = await updateVideo(this.video.id, {
					url: video.url,
					title: video.title,
					start_enabled: video.start_enabled,
					end_enabled: video.end_enabled,
					start_time: video.start_time,
					end_time: video.end_time,
					thumbnail: video.thumbnail.id,
					duration: video.duration,
				})

				if (result.success) {
					// Show success notice.
					this.$root.$emit('showTopNotice', {
						message: sprintf(
							this.$i18n.videos.notices.video_updated,
							video.title
						),
					})

					// Close the modal.
					this.closeModal()

					// Remove the embed from vuex.
					this.$store.dispatch('videos/unsetEmbed', video.id)
				} else {
					// Show error notice.
					this.$root.$emit('showTopNotice', {
						type: 'error',
						message: this.$i18n.videos.notices.video_update_failed,
					})
				}

				// Remove saving flag.
				this.saving = false
			}
		},

		/**
		 * Handle the video embed update.
		 *
		 * @param {object} data Custom data.
		 *
		 * @since 1.8.0
		 */
		handleEmbedUpdate(data) {
			this.showError = !data.success
			this.showSettings = data.success
		},

		/**
		 * Handle the url clear event.
		 *
		 * When URL is cleared, we need to hide the
		 * video settings fields.
		 *
		 * @since 1.8.0
		 */
		handleClearUrl() {
			// Clear settings.
			this.video.url = ''
			this.video.title = ''
			this.video.start_enabled = 0
			this.video.end_enabled = 0
			this.video.start_time = ''
			this.video.end_time = ''
			this.video.duration = ''
			this.video.thumbnail = {
				id: 0,
				file: '',
				url: '',
			}

			// Hide settings.
			this.showSettings = false
			// Hide error.
			this.showError = false
		},
	},
}
</script>
