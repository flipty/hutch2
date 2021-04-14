<template>
	<div class="sui-box sui-summary" :class="summaryClass">
		<div
			class="sui-summary-image-space"
			aria-hidden="true"
			:style="reBrandedStyle"
		></div>

		<!-- Summary box content -->
		<slot></slot>
	</div>
</template>

<script>
export default {
	name: 'WhitelabelSummary',

	props: {
		small: {
			type: Boolean,
			default: false,
		},
	},

	computed: {
		/**
		 * Get the summary box class.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		summaryClass() {
			return {
				'sui-summary-sm': this.small,
				'sui-unbranded': this.$vars.whitelabel.is_unbranded,
				'sui-rebranded': this.$vars.whitelabel.is_rebranded,
			}
		},

		/**
		 * Get the background image if white-labelled.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		reBrandedStyle() {
			if (this.$vars.whitelabel.is_rebranded) {
				return {
					'background-image':
						'url(' + this.$vars.whitelabel.custom_image + ')',
				}
			}
		},
	},
}
</script>
