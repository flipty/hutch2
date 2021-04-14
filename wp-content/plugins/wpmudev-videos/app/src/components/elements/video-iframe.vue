<template>
	<div
		v-html="embed"
		class="wpmudev-video-container video-iframe"
		:class="defaultClass"
	></div>
</template>

<script>
import lazyframe from 'lazyframe'

export default {
	name: 'VideoIframe',

	props: {
		embed: {
			type: String,
			required: true,
		},
		type: {
			type: String,
			default: 'default',
		},
	},

	mounted() {
		// Init lazyframe.
		this.initLazyFrame()
	},

	updated() {
		// Re-init lazyframe on update.
		this.initLazyFrame()
	},

	computed: {
		/**
		 * Add custom class for default videos.
		 *
		 * @since 1.8.0
		 */
		defaultClass() {
			return {
				'wpmudev-video-default': this.type === 'default',
			}
		},
	},

	methods: {
		/**
		 * Enable lazy load for custom videos
		 *
		 * Only for videos with custom thumbnail.
		 *
		 * @since 1.8.0
		 */
		initLazyFrame() {
			lazyframe('.lazyframe', {
				lazyload: false,
			})
		},
	},
}
</script>
