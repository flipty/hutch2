<template>
	<button
		@click="refreshData"
		:class="refreshClass"
		type="button"
		class="sui-button sui-button-ghost"
		aria-live="polite"
	>
		<span class="sui-button-text-default">
			<sui-icon icon="refresh" />
			{{ $i18n.dashboard.buttons.refresh_status }}
		</span>
		<span class="sui-button-text-onload">
			<sui-icon icon="loader" class="sui-loading" />
			{{ $i18n.dashboard.buttons.refreshing_status }}
		</span>
	</button>
</template>

<script>
import { restGet } from '@/helpers/api'
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'MembershipRefreshButton',

	components: { SuiIcon },

	props: {
		reload: {
			type: Boolean,
			default: true,
		},
	},

	data() {
		return {
			refreshing: false,
		}
	},

	computed: {
		/**
		 * Get loader class if refresh is in progress.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		refreshClass() {
			return {
				'sui-button-onload-text': this.refreshing,
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
		 * @since 1.8.0
		 */
		refreshData() {
			this.refreshing = true

			restGet({
				path: 'actions',
				params: {
					action: 'refresh_membership',
				},
			}).then((response) => {
				if (this.reload) {
					// Reload the current page.
					window.location.reload()
				} else {
					this.refreshing = false
				}
			})
		},
	},
}
</script>
