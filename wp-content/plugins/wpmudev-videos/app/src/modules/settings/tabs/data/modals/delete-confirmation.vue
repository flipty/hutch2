<template>
	<div class="sui-modal sui-modal-sm">
		<div
			:id="modal"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-desc`"
			class="sui-modal-content sui-content-fade-in"
			aria-modal="true"
			role="dialog"
		>
			<div class="sui-box">
				<div
					class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60"
				>
					<button
						class="sui-button-icon sui-button-float--right"
						@click="closeModal"
						:id="`${modal}-close`"
					>
						<i class="sui-icon-close sui-md" aria-hidden="true"></i>
						<span class="sui-screen-reader-text">
							{{ $i18n.dialogs.close }}
						</span>
					</button>

					<h3 :id="`${modal}-title`" class="sui-box-title sui-lg">
						{{ $i18n.settings.titles.reset_plugin }}
					</h3>

					<p :id="`${modal}-desc`" class="sui-description">
						{{ $i18n.settings.descriptions.reset_plugin }}
					</p>
				</div>

				<div class="sui-box-footer sui-flatten sui-content-center">
					<button
						class="sui-button sui-button-ghost"
						id="wpmudev-videos-data-reset-confirmation-cancel"
						@click="closeModal"
					>
						{{ $i18n.dialogs.cancel }}
					</button>

					<!-- Reset button -->
					<reset-button @afterReset="afterReset" />
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Modal from '@/components/mixins/modal'
import ResetButton from '@/components/elements/reset-button'

export default {
	name: 'DeleteConfirmation',

	components: { ResetButton },

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-data-reset-confirmation',
			openFocus: 'wpmudev-videos-data-reset-confirmation-close',
			closeFocus: 'wpmudev-videos-data-reset-confirmation-opener',
		}
	},

	created() {
		// Open modal on event.
		this.$root.$on('openSettingsResetModal', this.openModal)
	},

	computed: {
		/**
		 * Get the loading class for the button.
		 *
		 * @since 1.8.3
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.deleting,
			}
		},
	},

	methods: {
		/**
		 * Reload page after settings are reset.
		 *
		 * @param {object} response Response data.
		 *
		 * @since 1.8.3
		 */
		afterReset(response) {
			if (response.success) {
				this.closeModal()

				// Show notice.
				this.$root.$emit('showTopNotice', {
					message: response.data.message,
				})

				// Reload the current page.
				window.location.reload()
			}
		},
	},
}
</script>
