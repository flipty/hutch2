<template>
	<div class="sui-with-button sui-with-button-inside">
		<input
			type="text"
			v-model="url"
			class="sui-form-control"
			:id="`${form}-video-url`"
			:aria-labelledby="`${form}-video-url-label`"
		/>

		<button
			v-if="urlReady"
			type="button"
			class="sui-button"
			aria-live="polite"
			@click="clearUrl"
		>
			{{ $i18n.buttons.clear }}
		</button>

		<button
			v-else
			type="button"
			class="sui-button"
			aria-live="polite"
			:class="loadingClass"
			@click="getUrlEmbed"
		>
			<span class="sui-button-text-default">
				{{ $i18n.videos.buttons.add_video }}
			</span>
			<span class="sui-button-text-onload">
				<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
				{{ $i18n.videos.buttons.adding_video }}
			</span>
		</button>
	</div>
</template>

<script>
import { restGet } from '@/helpers/api'

export default {
	name: 'VideoUrl',

	props: {
		form: {
			type: String,
			required: true,
		},
		video: {
			type: Object,
			required: true,
		},
		width: {
			type: Number,
			default: 300,
		},
	},

	data() {
		return {
			updating: false,
			urlReady: !!this.video.url,
		}
	},

	created() {
		// Update the embed.
		this.$root.$on('syncUrlEmbed', this.syncUrlEmbed)
	},

	computed: {
		/**
		 * Get the loading class for button.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.updating,
			}
		},

		/**
		 * Video URL option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		url: {
			get() {
				return this.video.url
			},

			set(url) {
				let video = this.video

				video.url = url

				// Emit the video update event.
				this.$emit('update:video', video)
			},
		},
	},

	methods: {
		/**
		 * Update the video embed when requested.
		 *
		 * Embed update is required when thumbnail,
		 * start/end times of video is changed.
		 *
		 * @param {object} data Video data.
		 *
		 * @since 1.8.0
		 */
		syncUrlEmbed(data) {
			if (this.form === data.form) {
				this.getUrlEmbed()
			}
		},

		/**
		 * Clear the video URL value.
		 *
		 * Reset the form and emit the event.
		 *
		 * @since 1.8.0
		 */
		clearUrl() {
			this.urlReady = false

			// Reset settings fields.
			this.resetSettings()

			// Emit url clear event.
			this.$emit('clearUrl')
		},

		/**
		 * Reset the video data to defaults.
		 *
		 * @since 1.8.0
		 */
		resetSettings() {
			let video = this.video

			// Reset fields.
			video.thumbnail = {
				id: 0,
				file: '',
				url: '',
			}
			video.url = ''
			video.title = ''
			video.start_time = ''
			video.end_time = ''

			// Emit video update.
			this.$emit('update:video', video)
		},

		/**
		 * Update the embed using the URL.
		 *
		 * We need to pass the custom thumbnail and
		 * start/end time strings.
		 *
		 * @since 1.8.0
		 */
		getUrlEmbed() {
			// Bail if already updating.
			if (this.updating || this.url === '') {
				return
			}

			this.updating = true

			restGet({
				path: 'videos/embed',
				params: {
					url: this.video.url,
					host: this.video.host,
					width: this.width,
					thumbnail: this.video.thumbnail.id || 0,
					start_enabled: this.video.start_enabled,
					end_enabled: this.video.end_enabled,
					start_time: this.video.start_time,
					end_time: this.video.end_time,
				},
			}).then((response) => {
				if (response.success && response.data) {
					// Update the embed.
					this.updateVideo(response.data)
				}

				// Emit embed updating event.
				this.$emit('embedUpdate', {
					success: response.success,
					data: response.data,
				})

				// Is url ok?
				this.urlReady = response.success

				this.updating = false
			})
		},

		/**
		 * Update the video data using embed.
		 *
		 * Once the embed is updated, set that
		 * to video object.
		 *
		 * @since 1.8.0
		 */
		updateVideo(data) {
			let video = this.video

			// Set the embed.
			video.embed = data.html

			// Update the title.
			if (data.title && video.title === '') {
				video.title = data.title
			}

			// Set the duration.
			if (data.duration) {
				video.duration = data.duration
			}

			// Update video object with embed.
			this.$emit('update:video', video)
		},
	},
}
</script>
