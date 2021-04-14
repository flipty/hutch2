<template>
	<span :class="getClass" aria-hidden="true"></span>
</template>

<script>
export default {
	name: 'SuiIcon',

	props: {
		icon: {
			type: String,
			required: true,
		},
		size: {
			type: String,
			default: '',
		},
		animate: {
			type: Boolean,
			default: false,
		},
	},

	computed: {
		/**
		 * Calculate and get the icon class.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		getClass() {
			return {
				['sui-icon-' + this.icon]: true,
				['sui-' + this.size]: this.size && this.size !== '',
				['sui-loading']: this.animate,
			}
		},
	},
}
</script>
