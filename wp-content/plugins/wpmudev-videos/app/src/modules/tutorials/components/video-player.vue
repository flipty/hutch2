<template>
	<div
		role="tabpanel"
		class="wpmudev-videos-section--videos-panel"
		aria-live="polite"
		tabindex="0"
		:hidden="!selected"
		:id="`tab-content--playlist-${playlist.id}-video-${video}`"
		:aria-labelledby="
			selected
				? `tab--playlist-${this.playlist.id}-video-${this.video}`
				: ''
		"
	>
		<fragment v-if="selected">
			<h3 class="video-title">{{ getVideo.video_title }}</h3>

			<video-iframe :embed="embed" :type="getVideo.video_type" />

			<button class="video-close" @click="hidePreview">
				<sui-icon icon="close" size="sm" />
				<span class="sui-screen-reader-text">
					{{ $i18n.buttons.close_video }}
				</span>
			</button>
		</fragment>
	</div>
</template>

<script>
import { getEmbed } from '@/helpers/videos'
import SuiIcon from '@/components/sui/sui-icon'
import VideoIframe from '@/components/elements/video-iframe'

export default {
	name: 'VideoPlayer',

	components: { SuiIcon, VideoIframe },

	props: {
		video: {
			type: Number | String,
			required: true,
		},
		playlist: {
			type: Object,
			required: true,
		},
		selected: {
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

	watch: {
		/**
		 * Update the video embed when video id changed.
		 *
		 * @since 1.8.0
		 */
		video(video) {
			// Get embed.
			this.getEmbed()
		},
	},

	computed: {
		/**
		 * Get the current video object.
		 *
		 * @since 1.8.0
		 *
		 * @returns {object}
		 */
		getVideo() {
			return this.$store.getters['videos/video'](this.video) || {}
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

			let embed = await getEmbed(this.video)

			if (embed.html) {
				this.embed = embed.html
			}

			this.updating = false
		},

		/**
		 * Handle the video preview hide event.
		 *
		 * @since 1.8.0
		 */
		hidePreview() {
			this.$router.push({
				name: 'VideosList',
				params: {},
			})
		},
	},
}
</script>
