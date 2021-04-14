export default {
	data() {
		return {
			modal: 'wpmudev-videos-modal',
			closeFocus: null,
			openFocus: null,
			hasOverlayMask: true,
		}
	},

	mounted() {
		// Initialize modal.
		SUI.modalDialog()
	},

	methods: {
		/**
		 * Open the current modal.
		 *
		 * Open the SUI initialized modal using the modal ID.
		 *
		 * @since 1.8.0
		 */
		openModal() {
			SUI.openModal(
				this.modal,
				this.closeFocus,
				this.openFocus,
				this.hasOverlayMask
			)

			this.$emit('modal:open', this.modal)
		},

		/**
		 * Close the current modal.
		 *
		 * SUI will close the active modal.
		 *
		 * @since 1.8.0
		 */
		closeModal() {
			SUI.closeModal()

			this.$emit('modal:close', this.modal)
		},
	},
}
