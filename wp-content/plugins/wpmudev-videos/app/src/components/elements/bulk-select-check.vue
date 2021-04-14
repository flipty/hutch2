<template>
	<label class="sui-checkbox" :for="id">
		<input
			type="checkbox"
			:id="id"
			@change="handleChange"
			v-model="selected"
		/>
		<span aria-hidden="true"></span>
	</label>
</template>

<script>
export default {
	name: 'BulkSelectCheck',

	props: {
		id: {
			type: String,
			required: true,
		},
		value: {
			type: Boolean,
			default: false,
		},
	},

	data() {
		return {
			selected: this.value,
		}
	},

	watch: {
		/**
		 * Update the selected state.
		 *
		 * @since 1.8.0
		 */
		value(selected) {
			this.selected = selected
		},
	},

	methods: {
		/**
		 * Handle checkbox check event.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		handleChange() {
			this.$emit('input', this.selected)
		},
	},
}
</script>
