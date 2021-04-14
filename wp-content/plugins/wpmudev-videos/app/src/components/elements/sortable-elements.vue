<template>
	<div ref="element">
		<slot></slot>
	</div>
</template>

<script>
import Sortable from 'sortablejs'

export default {
	name: 'SortableElements',

	props: {
		handle: {
			type: String,
			default: '.sortable',
		},
		filter: {
			type: String,
			default: '',
		},
	},

	mounted() {
		// Init sortable.
		this.initSortable()
	},

	methods: {
		/**
		 * Initialize sortable element.
		 *
		 * @since 1.8.4
		 */
		initSortable() {
			Sortable.create(this.$refs.element, {
				handle: this.handle,
				filter: this.filter,
				animation: 150,
				onUpdate: this.onUpdate,
			})
		},

		/**
		 * Initialize sortable element.
		 *
		 * For more details of the event data
		 * see https://github.com/SortableJS/sortablejs
		 *
		 * @since 1.8.4
		 */
		onUpdate(event) {
			this.$emit('update', event)
		},
	},
}
</script>
