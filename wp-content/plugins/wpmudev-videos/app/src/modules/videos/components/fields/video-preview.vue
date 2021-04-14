<template>
	<video-iframe
		:embed="video.embed"
		class="custom-video-iframe"
		type="custom"
	/>
</template>

<script>
import { getEmbed } from '@/helpers/videos'
import VideoIframe from '@/components/elements/video-iframe'

export default {
	name: 'VideoPreview',

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

	components: { VideoIframe },

	data() {
		return {
			updating: false,
		}
	},

	async mounted() {
		// Get initial embed.
		if (this.video.id && this.video.id > 0) {
			await this.getVideoEmbed(true)
		}
	},

	watch: {
		// When video changes, get embed.
		video(video, old) {
			// If video id changed.
			if (video.id > 0 && video.id !== old.id) {
				this.getVideoEmbed(true)
			}

			// Get embed if cleared.
			if (video.embed !== old.embed && video.embed === '') {
				this.getVideoEmbed(true)
			}
		},
	},

	computed: {
		/**
		 * Video embed option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		embed: {
			get() {
				return this.video.embed
			},

			set(embed) {
				let video = this.video

				video.embed = embed

				// Emit video update event.
				this.$emit('update:video', video)
			},
		},
	},

	methods: {
		/**
		 * If the video ID is available, get embed.
		 *
		 * We need to pass the custom thumbnail and
		 * start/end time strings.
		 *
		 * @param {bool} force Force api.
		 *
		 * @since 1.8.0
		 */
		async getVideoEmbed(force = true) {
			// Bail if already updating.
			if (this.updating) {
				return
			}

			this.updating = true

			// Get embed.
			let embed = await getEmbed(this.video.id, {
				start_time: this.video.start_time,
				end_time: this.video.end_time,
				start_enabled: this.video.start_enabled,
				end_enabled: this.video.end_enabled,
			})

			if (embed.html) {
				this.embed = embed.html
			}

			this.updating = false
		},
	},
}
</script>
