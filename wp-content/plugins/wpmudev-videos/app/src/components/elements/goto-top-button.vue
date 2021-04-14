<template>
	<div :class="getClass">
		<div
			class="sui-tooltip sui-tooltip-top-right sui-constrained"
			style="--tooltip-width: 100px;"
			:data-tooltip="$i18n.labels.go_to_top"
		>
			<button class="wpmudev-videos-button--to-top" @click="scrollTop">
				<sui-icon icon="chevron-up" size="sm" />
				<span class="sui-screen-reader-text">{{
					$i18n.labels.go_to_top
				}}</span>
			</button>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'GotoTopButton',

	components: { SuiIcon },

	data() {
		return {
			show: false,
		}
	},

	created() {
		// Handle scroll event.
		window.addEventListener('scroll', this.handleScroll)
	},

	destroyed() {
		// Remove event listener.
		window.removeEventListener('scroll', this.handleScroll)
	},

	computed: {
		/**
		 * Get the element class based on the flag.
		 *
		 * @since 1.8.0
		 *
		 * @returns {object}
		 */
		getClass() {
			return {
				'wpmudev-videos-to-top': true,
				'wpmudev-videos-show': this.show,
			}
		},
	},

	methods: {
		/**
		 * When clicked, scroll to top smoothly.
		 *
		 * @since 1.8.0
		 */
		scrollTop() {
			// Scroll to top.
			jQuery('html, body').animate({ scrollTop: 0 }, 'slow')

			return false
		},

		/**
		 * Handle the window scroll and set the flag.
		 *
		 * When scrolled down, set the flag so we can
		 * show the button element.
		 *
		 * @since 1.8.0
		 */
		handleScroll() {
			this.show =
				document.body.scrollTop > 20 ||
				document.documentElement.scrollTop > 20
		},
	},
}
</script>
