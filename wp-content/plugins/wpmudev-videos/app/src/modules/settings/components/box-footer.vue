<template>
	<div class="sui-box-footer">
		<div class="sui-actions-right">
			<button
				type="button"
				class="sui-button sui-button-blue"
				aria-live="polite"
				:class="savingClass"
				@click="saveSettings"
			>
				<span class="sui-button-text-default">
					<i class="sui-icon-save" aria-hidden="true"></i>
					{{ $i18n.settings.buttons.save }}
				</span>

				<span class="sui-button-text-onload">
					<i
						class="sui-icon-loader sui-loading"
						aria-hidden="true"
					></i>
					{{ $i18n.settings.buttons.saving }}
				</span>
			</button>
		</div>
	</div>
</template>

<script>
export default {
	name: 'BoxFooter',

	props: {
		reload: {
			type: Boolean,
			default: false,
		},
	},

	data() {
		return {
			saving: false,
		}
	},

	computed: {
		/**
		 * Get the button class if save in progress.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		savingClass() {
			return {
				'sui-button-onload-text': this.saving,
			}
		},
	},

	methods: {
		/**
		 * Process the submit button click.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		async saveSettings() {
			this.saving = true

			// Save the options.
			let success = await this.$store.dispatch('settings/saveOptions')

			// Show notice.
			if (success) {
				this.$root.$emit('showTopNotice', {
					message: this.$i18n.settings.notices.changes_saved,
				})

				// Reload if required.
				if (this.reload) {
					location.reload()
				}
			} else {
				this.$root.$emit('showTopNotice', {
					message: this.$i18n.settings.notices.changes_save_failed,
					type: 'error',
				})
			}

			this.saving = false
		},
	},
}
</script>
