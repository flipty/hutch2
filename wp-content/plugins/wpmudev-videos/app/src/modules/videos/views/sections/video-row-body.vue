<template>
	<div
		role="region"
		class="wpmudev-videos-accordion--region"
		:id="`wpmudev-videos-accordion-item-${video.id}`"
		:aria-labelledby="`wpmudev-videos-accordion-item-${video.id}--label`"
	>
		<button
			class="sui-button-icon wpmudev-videos-show_desktop"
			:disabled="disabled"
			@click="hideVideo"
		>
			<span class="sui-icon-close sui-sm" aria-hidden="true"></span>
			<span class="sui-screen-reader-text">
				{{ $i18n.buttons.close_region }}
			</span>
		</button>

		<button
			class="sui-button-icon sui-button-outlined wpmudev-videos-show_mobile"
			:disabled="disabled"
			@click="hideVideo"
		>
			<span class="sui-icon-close sui-sm" aria-hidden="true"></span>
			<span class="sui-screen-reader-text">
				{{ $i18n.buttons.close_region }}
			</span>
		</button>

		<!-- Video iframe -->
		<video-iframe :embed="embed" :type="video.video_type" />
	</div>
</template>

<script>
import { getEmbed } from '@/helpers/videos'
import VideoIframe from '@/components/elements/video-iframe'

export default {
	name: 'VideoRowBody',

	components: { VideoIframe },

	props: {
		video: {
			type: Object,
			required: true,
		},
		disabled: {
			type: Boolean,
			default: false,
		},
	},

	data() {
		return {
			embed: '',
			updating: false,
		}
	},

	async mounted() {
		// Get embed.
		await this.getEmbed()
	},

	computed: {
		/**
		 * Check if current video is custom video.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		isCustomVideo() {
			return this.video.video_type && 'custom' === this.video.video_type
		},

		/**
		 * Get shortcode of the current video.
		 *
		 * @since 1.8.0
		 *
		 * @return {string}
		 */
		getShortCode() {
			return '[wpmudev-video video="' + this.video.id + '"]'
		},
	},

	methods: {
		/**
		 * If the video ID is available, get embed.
		 *
		 * We need to pass the custom thumbnail and
		 * start/end time strings.
		 *
		 * @since 1.8.0
		 */
		async getEmbed() {
			// Bail if already updating.
			if (this.updating) {
				return
			}

			this.updating = true

			let embed = await getEmbed(this.video.id)

			if (embed.html) {
				this.embed = embed.html
			}

			this.updating = false
		},

		/**
		 * Emit the video title edit modal event.
		 *
		 * @since 1.8.0
		 */
		openTitleForm() {
			this.$root.$emit('openVideoTitleFormModal', {
				video: this.video,
				focus: 'wpmudev-videos-box-' + this.video.id,
			})
		},

		/**
		 * Emit the video edit modal event.
		 *
		 * This event should be only available for
		 * the custom video type.
		 *
		 * @since 1.8.0
		 */
		openEditForm() {
			this.$root.$emit('openVideoEditFormModal', {
				video: this.video,
				focus: 'wpmudev-videos-box-' + this.video.id,
			})
		},

		/**
		 * Emit the video playlist form modal event.
		 *
		 * @since 1.8.0
		 */
		openPlaylistForm() {
			this.$root.$emit('openVideoPlaylistFormModal', {
				video: this.video,
				focus: 'wpmudev-videos-box-' + this.video.id,
			})
		},

		/**
		 * Show the shortcode copied message.
		 *
		 * @since 1.8.0
		 */
		copiedNotice() {
			this.$root.$emit('showTopNotice', {
				message: this.$i18n.notices.shortcode_copied,
			})
		},

		/**
		 * Hide the video by changing navigation.
		 *
		 * @since 1.8.0
		 */
		hideVideo() {
			this.$router.push({
				name: 'VideosBox',
				params: {},
			})
		},
	},
}
</script>
