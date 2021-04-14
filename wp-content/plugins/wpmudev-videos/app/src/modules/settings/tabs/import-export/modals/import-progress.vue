<template>
	<div class="sui-modal sui-modal-md">
		<div
			role="dialog"
			class="sui-modal-content sui-content-fade-out"
			aria-modal="true"
			:id="modal"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-title`"
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
						{{ $i18n.settings.titles.import }}
					</h3>

					<p :id="`${modal}-desc`" class="sui-description">
						{{ $i18n.settings.descriptions.import_modal_progress }}
					</p>
				</div>

				<div class="sui-box-body sui-content-center">
					<div class="sui-progress-block">
						<div class="sui-progress">
							<span
								class="sui-progress-icon"
								aria-hidden="true"
								v-if="showLoader"
							>
								<i class="sui-icon-loader sui-loading"></i>
							</span>
							<span class="sui-progress-text">
								{{ progress }}%
							</span>
							<div class="sui-progress-bar" aria-hidden="true">
								<span :style="progressStyle"></span>
							</div>
						</div>
					</div>
					<p class="sui-description">
						{{ $i18n.settings.labels.import_progress }}
					</p>
				</div>

				<div class="sui-box-footer sui-flatten sui-content-center">
					<button
						class="sui-button"
						:id="`${modal}-import-continue`"
						@click="closeModal"
					>
						{{ $i18n.settings.buttons.continue_background }}
					</button>
				</div>

				<whitelabel-modal-banner
					src="summary/dashboard.png"
					img-class="sui-image sui-image-center"
					:alt="$i18n.settings.titles.import"
				/>
			</div>
		</div>
	</div>
</template>

<script>
import { restGet } from '@/helpers/api'
import Modal from '@/components/mixins/modal'
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'

export default {
	name: 'ImportProgress',

	mixins: [Modal],

	components: { WhitelabelModalBanner },

	data() {
		return {
			modal: 'wpmudev-videos-import-progress',
			openFocus: 'wpmudev-videos-import-progress-continue',
			closeFocus: 'wpmudev-videos-import-confirmation-opener',
			checkStatus: false,
			checking: null,
			progress: 0,
		}
	},

	created() {
		// Open the modal on event.
		this.$root.$on('openImportProgressModal', (data) => {
			SUI.replaceModal(
				this.modal,
				'wpmudev-videos-import-confirmation-opener',
				this.modal + '-import-continue'
			)
			this.checkStatus = true
			// Update status every 5 seconds.
			this.checking = setInterval(this.updateStatus, 5000)
		})

		// Open the modal on event.
		this.$on('modal:close', () => {
			this.checkStatus = false
			// Clear status check.
			clearInterval(this.checking)
		})
	},

	computed: {
		/**
		 * Get loading class when saving.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		progressStyle() {
			return {
				width: this.progress + '%',
			}
		},

		/**
		 * Get loading class when saving.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		showLoader() {
			return this.progress < 100
		},
	},

	methods: {
		/**
		 * Save title change to the db.
		 *
		 * Vuex will take care of updating the object.
		 *
		 * @since 1.8.0
		 */
		updateStatus() {
			if (this.checkStatus) {
				restGet({
					path: 'data/import/status',
				}).then((response) => {
					if (response.success && response.data) {
						this.setProgress(response.data)
						this.setStatus(response.data)

						if (this.isCompleted(response.data)) {
							this.closeModal()
							// Reset the progress.
							this.progress = 0

							// Show success notice.
							this.$root.$emit('showTopNotice', {
								message: this.$i18n.settings.notices
									.import_success,
							})
						}
					}
				})
			}
		},

		/**
		 * Check if the progress is completed.
		 *
		 * @param {object} data Progress data
		 *
		 * @since 1.8.3
		 *
		 * @return {boolean}
		 */
		isCompleted(data) {
			return data.completed >= data.total
		},

		/**
		 * Set import status from progress data,
		 *
		 * @param {object} data Progress data
		 *
		 * @since 1.8.3
		 *
		 * @return {boolean}
		 */
		setStatus(data) {
			this.checkStatus = !this.isCompleted(data)
		},

		/**
		 * Update progress bar based on the data.
		 *
		 * @param {object} data Progress data
		 *
		 * @since 1.8.3
		 *
		 * @return {boolean}
		 */
		setProgress(data) {
			if (this.isCompleted(data)) {
				this.progress = 100
			} else {
				let progress = (data.completed / data.total) * 100

				this.progress = isNaN(progress) ? 0 : Math.round(progress)
			}
		},
	},
}
</script>
