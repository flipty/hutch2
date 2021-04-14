<template>
	<button
		@click="resetData"
		:class="loadingClass"
		type="button"
		class="sui-button sui-button-ghost sui-button-red"
		aria-live="polite"
	>
		<span class="sui-button-text-default">
			<i class="sui-icon-undo" aria-hidden="true"></i>
			{{ $i18n.settings.labels.reset }}
		</span>
		<span class="sui-button-text-onload">
			<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
			{{ $i18n.settings.buttons.resetting }}
		</span>
	</button>
</template>

<script>
import { restGet } from '@/helpers/api'

export default {
	name: 'ResetButton',

	props: {
		reload: {
			type: Boolean,
			default: true,
		},
	},

	data() {
		return {
			processing: false,
		}
	},

	computed: {
		/**
		 * Get loader class if refresh is in progress.
		 *
		 * @since 1.8.1
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.processing,
			}
		},
	},

	methods: {
		/**
		 * Refresh the membership data using API.
		 *
		 * Reload the current page after refreshing the
		 * status.
		 *
		 * @since 1.8.1
		 */
		resetData() {
			this.processing = true

			restGet({
				path: 'actions',
				params: {
					action: 'reset_settings',
				},
			}).then((response) => {
				// Emit after reset event.
				this.$emit('afterReset', response)

				this.processing = false
			})
		},
	},
}
</script>
