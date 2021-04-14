<template>
	<div class="wpmudev-videos-accordion--group" :class="itemClass">
		<video-row-header
			:video="getVideo"
			:is-open="isOpen"
			:action="action"
			:disabled="shouldDisable"
		/>

		<video-row-body
			v-if="isOpen"
			:video="getVideo"
			:disabled="shouldDisable"
		/>
	</div>
</template>

<script>
import VideoRowBody from './video-row-body'
import VideoRowHeader from './video-row-header'

export default {
	name: 'VideoRow',

	components: {
		VideoRowHeader,
		VideoRowBody,
	},

	props: {
		id: {
			type: Number,
			required: true,
		},
		action: {
			type: Object,
			default: {
				id: 0,
				action: '',
			},
		},
	},

	computed: {
		/**
		 * Get the video object from Vuex.
		 *
		 * We use the computed function to get the
		 * updated video object from Vuex.
		 *
		 * @since 1.8.0
		 *
		 * @return {object}
		 */
		getVideo() {
			let video = this.$store.getters['videos/video'](this.id)

			return video ? video : {}
		},

		/**
		 * Check if current video is custom video.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		isDefaultVideo() {
			return (
				this.getVideo.video_type &&
				'default' === this.getVideo.video_type
			)
		},

		/**
		 * Check if current video is open.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		isOpen() {
			return (
				this.action.id == this.getVideo.id &&
				this.action.action === 'view'
			)
		},

		/**
		 * Check if current video needs to be disabled.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		shouldDisable() {
			return (
				(!this.validMember() || this.expiredMember()) &&
				this.isDefaultVideo
			)
		},

		/**
		 * Get the class for open item.
		 *
		 * When video is open, we need to add active class.
		 * When WPMUDEV membership is invalid, we need to disable.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		itemClass() {
			return {
				'wpmudev-videos-active': this.isOpen,
				'wpmudev-videos-disabled': this.shouldDisable,
			}
		},
	},
}
</script>
