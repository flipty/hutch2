<template>
	<div class="sui-box-settings-row sui-flushed">
		<div class="sui-box-settings-col-1">
			<h3 class="sui-settings-label">
				{{ $i18n.settings.labels.export }}
			</h3>
			<p class="sui-description">
				{{ $i18n.settings.descriptions.export }}
			</p>
		</div>

		<div id="export-configs" class="sui-box-settings-col-2">
			<h4 class="sui-settings-label">
				{{ $i18n.settings.labels.export_config }}
			</h4>

			<form method="post" ref="exportForm" class="sui-border-frame">
				<input type="hidden" name="ivt-action" value="export" />
				<input type="hidden" name="ivt-export" value="1" />
				<input
					type="hidden"
					name="export-nonce"
					:value="$moduleVars.export_nonce"
				/>

				<div class="sui-form-field wpmudev-videos-export-options">
					<label id="export-options-label" class="sui-label">
						{{ $i18n.settings.labels.export_options }}
					</label>

					<p class="sui-description">
						{{ $i18n.settings.descriptions.export_options }}
					</p>

					<div role="group" aria-labelledby="export-options-label">
						<label
							class="sui-checkbox sui-checkbox-stacked"
							for="export-config-items-all"
						>
							<input
								type="checkbox"
								value="all"
								id="export-config-items-all"
								aria-labelledby="export-config-items-all-label"
								v-model="selected"
								@change="toggleAll"
							/>
							<span aria-hidden="true"></span>
							<span id="export-config-items-all-label">
								{{ $i18n.settings.labels.all }}
							</span>
						</label>

						<label
							class="sui-checkbox"
							:for="`export-config-items-${key}`"
							v-for="(label, key) in items"
							:key="key"
						>
							<input
								type="checkbox"
								name="export[]"
								:value="key"
								:id="`export-config-items-${key}`"
								:aria-labelledby="`export-config-items-${key}-label`"
								v-model="selected"
								@change="toggleItem"
							/>
							<span aria-hidden="true"></span>
							<span :id="`export-config-items-${key}-label`">
								{{ label }}
							</span>
						</label>
					</div>
				</div>

				<div
					role="group"
					class="sui-form-field wpmudev-videos-export-options"
				>
					<p class="sui-label" style="margin: 0 0 10px;">
						{{ $i18n.settings.labels.export_thumb }}
					</p>

					<label for="export-config-items-thumb" class="sui-toggle">
						<input
							type="checkbox"
							name="export[]"
							value="thumb"
							id="export-config-items-thumb"
							aria-labelledby="export-config-items-thumb-label"
							aria-describedby="export-config-items-thumb-desc"
							v-model="thumb"
						/>
						<span
							class="sui-toggle-slider"
							aria-hidden="true"
						></span>
						<span
							id="export-config-items-thumb-desc"
							class="sui-toggle-label"
						>
							{{ $i18n.settings.labels.include_thumb }}
						</span>
					</label>
				</div>
			</form>

			<button
				type="button"
				class="sui-button sui-button-blue"
				aria-live="polite"
				:class="exportButtonClass"
				:disabled="!canExport"
				@click="processExport"
			>
				<span class="sui-button-text-default">
					<span
						class="sui-icon-upload-cloud"
						aria-hidden="true"
					></span>
					{{ $i18n.settings.buttons.export }}
				</span>
				<span class="sui-button-text-onload">
					<span
						class="sui-icon-loader sui-loading"
						aria-hidden="true"
					></span>
					{{ $i18n.settings.buttons.exporting }}
				</span>
			</button>
		</div>
	</div>
</template>

<script>
export default {
	name: 'ExportConfigs',

	data() {
		return {
			selected: [],
			thumb: false,
			processing: false,
			items: {
				videos: this.$i18n.settings.labels.videos,
				playlists: this.$i18n.settings.labels.playlists,
				display: this.$i18n.settings.titles.display_settings,
				permissions: this.$i18n.settings.titles.permissions,
			},
		}
	},

	mounted() {
		// Disable processing when file downloaded.
		window.onblur = () => {
			this.processing = false
		}
	},

	computed: {
		/**
		 * Get the loading class for export button.
		 *
		 * @since 1.8.1
		 *
		 * @returns {*}
		 */
		exportButtonClass() {
			return {
				'sui-button-onload-text': this.processing,
			}
		},

		/**
		 * Check if we can export data.
		 *
		 * @since 1.8.1
		 *
		 * @returns {*}
		 */
		canExport() {
			// Exclude the thumb option.
			let selected = this.selected.filter((item) => {
				return 'thumb' !== item
			})

			// Make sure there are selected items.
			return selected.length > 0
		},

		/**
		 * Check if all items are selected.
		 *
		 * @since 1.8.3
		 *
		 * @returns {boolean}
		 */
		allSelected() {
			let items = Object.keys(this.items)

			return items.every((key) => this.selected.includes(key))
		},
	},

	methods: {
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
		 * Process the export button click.
		 *
		 * @since 1.8.1
		 *
		 * @returns {void}
		 */
		processExport() {
			// Show processing.
			this.processing = true

			// Submit the form.
			this.$refs.exportForm.submit()

			// Remove processing.
			setTimeout(() => {
				this.processing = false
			}, 2000)
		},
	},
}
</script>
