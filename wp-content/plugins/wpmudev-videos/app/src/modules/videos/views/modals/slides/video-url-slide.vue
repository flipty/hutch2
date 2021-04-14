<template>
	<div :id="`${form}-url-form`" class="sui-modal-slide" data-modal-size="lg">
		<div class="sui-box">
			<div
				class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60"
			>
				<whitelabel-modal-banner
					src="modal/modal-header-videos.png"
					:alt="$i18n.videos.labels.add_custom_video"
				/>

				<button
					@click="handleDismiss"
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
					{{ $i18n.videos.descriptions.copy_paste_url }}
				</p>

				<sui-notice type="error" v-if="showError">
					<p>{{ $i18n.videos.notices.invalid_url_attached }}</p>
				</sui-notice>
			</div>

			<div class="sui-box-selectors sui-box-selectors-col-2">
				<div class="sui-form-field" :class="errorClass">
					<label
						:for="`${form}-video-url`"
						:id="`${form}-video-url-label`"
						class="sui-label"
					>
						{{ $i18n.videos.labels.video_url }}
					</label>
					<!-- Video URL form -->
					<video-url
						:form="form"
						:video.sync="video"
						@clearUrl="handleClearUrl"
						@embedUpdate="handleEmbedUpdate"
					/>
				</div>

				<div class="sui-row" v-if="showSettingsFields">
					<div class="sui-col-md-6 sui-col-sm-12">
						<!-- Video preview section -->
						<video-preview :form="form" :video.sync="video" />
					</div>

					<div class="sui-col-md-6 sui-col-sm-12">
						<div class="sui-form-field">
							<!-- Video title field -->
							<video-title :form="form" :video.sync="video" />

							<!-- Show video duration if possible -->
							<span v-if="showDuration" class="sui-description">
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

			<!-- Video settings form -->
			<video-settings
				v-if="showSettingsFields"
				:form="form"
				:video.sync="video"
			/>

			<div class="sui-box-footer sui-flatten sui-content-center">
				<button
					role="button"
					class="sui-button"
					data-modal-slide-intro="next"
					:data-modal-slide="next"
					:disabled="!showSettingsFields"
				>
					{{ $i18n.dialogs.continue }}
				</button>
			</div>
		</div>
	</div>
</template>

<script>
import SuiNotice from '@/components/sui/sui-notice'
import VideoUrl from './../../../components/fields/video-url'
import VideoTitle from './../../../components/fields/video-title'
import VideoPreview from './../../../components/fields/video-preview'
import VideoSettings from './../../../components/sections/video-settings'
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'

export default {
	name: 'VideoUrlSlide',

	components: {
		VideoUrl,
		SuiNotice,
		VideoTitle,
		VideoPreview,
		VideoSettings,
		WhitelabelModalBanner,
	},

	props: {
		next: {
			type: String,
			required: true,
		},
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
			showError: false,
			showSettings: false,
		}
	},

	mounted() {
		// Clear url when video is published.
		this.$root.$on('customVideoCreated', this.handleClearUrl)
	},

	computed: {
		/**
		 * Should we show video settings.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		showSettingsFields() {
			return this.showSettings
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
	},

	methods: {
		/**
		 * Handle the video embed update.
		 *
		 * @since 1.8.0
		 *
		 * @param {object} data Custom data.
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
			this.showError = false
			this.showSettings = false
		},

		/**
		 * Handle the dismiss event.
		 *
		 * When dismissed, we need to clear the flags.
		 *
		 * @since 1.8.0
		 */
		handleDismiss() {
			this.$emit('dismiss')

			this.showError = false
			this.showSettings = false
		},
	},
}
</script>
