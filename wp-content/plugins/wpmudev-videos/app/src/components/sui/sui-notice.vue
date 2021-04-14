<template>
	<div :id="getId" :class="noticeClass">
		<div class="sui-notice-content">
			<div class="sui-notice-message">
				<sui-icon icon="info" size="md" class="sui-notice-icon" />
				<slot></slot>
			</div>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'SuiNotice',

	components: { SuiIcon },

	props: {
		id: {
			type: String,
			default: 'success',
		},
		type: {
			type: String,
			default: 'success',
		},
	},

	mounted() {
		// Initialize notice.
		SUI.notice()
	},

	computed: {
		/**
		 * Get the unique ID for the notice.
		 *
		 * @since 1.8.3
		 *
		 * @returns {string}
		 */
		getId() {
			return this.id ? this.id : this._uid
		},

		/**
		 * Calculate notice class based on the conditions.
		 *
		 * @since 1.8.0
		 *
		 * @returns {object}
		 */
		noticeClass() {
			return {
				'sui-notice': true,
				'sui-notice-info': this.type === 'info',
				'sui-notice-error': this.type === 'error',
				'sui-notice-success': this.type === 'success',
				'sui-notice-warning': this.type === 'warning',
				'sui-notice-purple': this.type === 'purple',
			}
		},
	},
}
</script>
