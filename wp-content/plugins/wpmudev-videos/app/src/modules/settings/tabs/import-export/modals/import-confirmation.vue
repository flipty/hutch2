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
						<span
							class="sui-icon-close sui-md"
							aria-hidden="true"
						></span>
						<span class="sui-screen-reader-text">
							{{ $i18n.dialogs.close }}
						</span>
					</button>

					<h3 :id="`${modal}-title`" class="sui-box-title sui-lg">
						{{ $i18n.settings.titles.import }}
					</h3>

					<p :id="`${modal}-desc`" class="sui-description">
						{{ $i18n.settings.descriptions.import_modal }}
					</p>
				</div>

				<div class="sui-box-body">
					<div class="sui-border-frame">
						<p class="sui-description">
							{{ $i18n.settings.descriptions.import_confirm }}
						</p>

						<div
							role="group"
							class="sui-form-field"
							aria-labelledby="export-config-items-label"
						>
							<label
								class="sui-checkbox sui-checkbox-sm sui-checkbox-stacked"
								:for="`${modal}-items-all`"
							>
								<input
									type="checkbox"
									value="all"
									:id="`${modal}-items-all`"
									:aria-labelledby="`${modal}-items-all-label`"
									v-model="selected"
									@change="toggleAll"
								/>
								<span aria-hidden="true"></span>
								<span :id="`${modal}-items-all-label`">
									{{ $i18n.settings.labels.all }}
								</span>
							</label>

							<label
								class="sui-checkbox sui-checkbox-sm"
								:for="`${modal}-items-${key}`"
								v-for="(label, key) in items"
								:key="key"
							>
								<input
									type="checkbox"
									:value="key"
									:id="`${modal}-items-${key}`"
									:aria-labelledby="`${modal}-items-${key}-label`"
									v-model="selected"
									@change="toggleItem"
								/>
								<span aria-hidden="true"></span>
								<span :id="`${modal}-items-${key}-label`">
									{{ label }}
									<span
										class="sui-tag sui-tag-sm"
										v-if="showCount(key)"
									>
										{{ showCount(key) }}
									</span>
								</span>
							</label>
						</div>
					</div>

					<div class="sui-form-field">
						<label :for="`${modal}-items-thumb`" class="sui-toggle">
							<input
								type="checkbox"
								:id="`${modal}-items-thumb`"
								:aria-labelledby="`${modal}-items-thumb-label`"
								:disabled="disableThumb"
								v-model="thumb"
							/>
							<span
								class="sui-toggle-slider"
								aria-hidden="true"
							></span>
							<span
								:id="`${modal}-items-thumb-label`"
								class="sui-toggle-label"
							>
								{{ $i18n.settings.labels.import_thumb }}
								<span
									class="sui-tooltip"
									:data-tooltip="
										$i18n.settings.labels.import_help
									"
								>
									<span
										class="sui-icon-info"
										aria-hidden="true"
									></span>
								</span>
							</span>
						</label>
					</div>
					<sui-notice type="info">
						<p>{{ $i18n.settings.notices.import_warning }}</p>
					</sui-notice>
				</div>

				<div class="sui-box-footer sui-content-separated">
					<button
						class="sui-button"
						:id="`${modal}-import-cancel`"
						:disabled="processing"
						@click="closeModal"
					>
						<span
							class="sui-icon-upload-cloud"
							aria-hidden="true"
						></span>
						{{ $i18n.buttons.cancel }}
					</button>

					<button
						type="button"
						class="sui-button sui-button-ghost"
						aria-live="polite"
						:id="`${modal}-import-submit`"
						:class="loadingClass"
						:disabled="!canImport"
						@click="importData"
					>
						<span class="sui-button-text-default">
							{{ $i18n.settings.buttons.import }}
						</span>
						<span class="sui-button-text-onload">
							<span
								class="sui-icon-loader sui-loading"
								aria-hidden="true"
							></span>
							{{ $i18n.settings.buttons.importing }}
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { restPost } from '@/helpers/api'
import Modal from '@/components/mixins/modal'
import SuiNotice from '@/components/sui/sui-notice'

export default {
	name: 'ImportConfirmation',

	mixins: [Modal],

	components: { SuiNotice },

	data() {
		return {
			modal: 'wpmudev-videos-import-confirmation',
			openFocus: 'wpmudev-videos-import-confirmation-import',
			closeFocus: 'wpmudev-videos-import-confirmation-opener',
			processing: false,
			selected: [],
			counts: {
				videos: 0,
				playlists: 0,
			},
			thumb: false,
			disableThumb: false,
			file: '',
			items: {
				videos: this.$i18n.settings.labels.videos,
				playlists: this.$i18n.settings.labels.playlists,
				display: this.$i18n.settings.titles.display_settings,
				permissions: this.$i18n.settings.titles.permissions,
			},
		}
	},

	created() {
		// Open the modal on event.
		this.$root.$on('openImportConfirmationModal', (data) => {
			// Set modal data.
			this.setModalData(data)

			// Open modal.
			this.openModal()
		})

		// Reset modal on close.
		this.$on('modal:close', () => {
			this.resetModal()
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
		loadingClass() {
			return {
				'sui-button-onload-text': this.processing,
			}
		},

		/**
		 * Check if we can import data.
		 *
		 * @since 1.8.3
		 *
		 * @returns {boolean}
		 */
		canImport() {
			// Exclude the thumb option.
			let selected = this.selected.filter((item) => {
				return 'thumb' !== item
			})

			// Make sure there are selected items.
			return selected.length > 0
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
		async importData() {
			this.processing = true

			let formData = new FormData()
			// Append file.
			formData.append('file', this.file)
			// Append selected items.
			formData.append('selected', this.selected)
			// Should import thumbs.
			formData.append('thumb', this.thumb)

			await restPost({
				path: 'data/import',
				body: formData,
			}).then((response) => {
				if (response.success && response.data) {
					this.$root.$emit('openImportProgressModal')
					// Disable processing.
					this.processing = false
				}
			})
		},

		/**
		 * Check if we need to show count.
		 *
		 * @param {string} type Type.
		 *
		 * @since 1.8.3
		 *
		 * @returns {string|boolean}
		 */
		showCount(type) {
			switch (type) {
				case 'playlists':
					return this.counts.playlists
				case 'videos':
					return this.counts.videos
				default:
					return false
			}
		},

		/**
		 * Toggle all select checkbox item.
		 *
		 * When select checkbox is selected, check all
		 * sub items in the list.
		 *
		 * @since 1.8.3
		 */
		toggleAll() {
			if (this.selected.includes('all')) {
				// Get all items as selected.
				let selected = Object.keys(this.items)
				// Push all option.
				selected.push('all')

				// Update option.
				this.selected = selected
			} else {
				// Uncheck all items.
				this.selected = []
			}
		},

		/**
		 * On sub items check change.
		 *
		 * If all sub items are selected, select
		 * all option also.
		 *
		 * @since 1.8.3
		 */
		toggleItem() {
			// If all items are selected.
			if (this.allSelected) {
				this.selected.push('all')
			} else {
				// Update the selected items.
				this.selected = this.selected.filter((item) => {
					return 'all' !== item
				})
			}
		},

		/**
		 * Set data for the confirmation modal.
		 *
		 * @param {object} data Data to import.
		 *
		 * @since 1.8.3
		 *
		 * @returns {void}
		 */
		setModalData(data) {
			if (data.videos > 0) {
				// Set videos.
				this.selected.push('videos')
				// Set count.
				this.counts.videos = data.videos
			}

			if (data.playlists > 0) {
				// Set playlists.
				this.selected.push('playlists')
				// Set the count.
				this.counts.playlists = data.playlists
			}

			if (data.display) {
				this.selected.push('display')
			}

			if (data.permissions) {
				this.selected.push('permissions')
			}

			// Thumbnail needs to import.
			this.thumb = data.thumb
			// Disable thumb option if not enabled.
			this.disableThumb = !data.thumb

			// Set file.
			if (data.file) {
				this.file = data.file
			}
		},

		/**
		 * Reset the import confirmation modal.
		 *
		 * @since 1.8.3
		 *
		 * @returns {void}
		 */
		resetModal() {
			this.file = ''
			this.thumb = false
			this.selected = []
			this.counts = {
				videos: 0,
				playlists: 0,
			}
		},
	},
}
</script>
