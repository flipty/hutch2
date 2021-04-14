<template>
	<button
		:class="buttonClass"
		:data-tooltip="tooltip"
		:disabled="disabled"
		class="sui-button-icon"
		@click="$emit('click', $event)"
	>
		<span :class="iconClass" aria-hidden="true"></span>
		<span class="sui-screen-reader-text">{{ label }}</span>
	</button>
</template>

<script>
export default {
	name: 'SuiButtonIcon',

	props: {
		label: {
			type: String,
			required: true,
		},
		icon: {
			type: String,
			required: true,
		},
		color: {
			type: String,
			default: '',
		},
		outlined: {
			type: Boolean,
			default: false,
		},
		tooltip: {
			type: String,
			default: '',
		},
		disabled: {
			type: Boolean,
			default: false,
		},
	},

	computed: {
		/**
		 * Get button class if given in props.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		buttonClass() {
			return {
				'sui-tooltip': this.tooltip && '' !== this.tooltip,
				'sui-button-outlined': this.outlined,
				['sui-button-' + this.color]: this.color && '' !== this.color,
			}
		},

		/**
		 * Get icon class if given in props.
		 *
		 * @since 1.8.0
		 *
		 * @returns {object}
		 */
		iconClass() {
			// Prepare icon class.
			let iconClass = 'sui-icon-' + this.icon

			return {
				[iconClass]: this.icon && '' !== this.icon,
			}
		},
	},
}
</script>
