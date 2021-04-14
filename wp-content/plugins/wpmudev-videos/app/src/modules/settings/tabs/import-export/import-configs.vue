<template>
	<div class="sui-box-settings-row sui-flushed">
		<div class="sui-box-settings-col-1">
			<h3 class="sui-settings-label">
				{{ $i18n.settings.labels.import }}
			</h3>
			<p class="sui-description">
				{{ $i18n.settings.descriptions.import }}
			</p>
		</div>

		<div id="import-configs" class="sui-box-settings-col-2">
			<h4 class="sui-settings-label">
				{{ $i18n.settings.labels.import_config }}
			</h4>
			<p class="sui-description">
				{{ $i18n.settings.descriptions.import_config }}
			</p>

			<div class="sui-form-field">
				<div class="wpmudev-videos-upload-import">
					<file-upload
						accept="application/JSON"
						@select="changeUpload"
					/>

					<button
						role="button"
						class="sui-button sui-button-blue"
						id="wpmudev-videos-import-confirmation-opener"
						:disabled="!canImport"
						@click="showConfirmation"
					>
						<sui-icon icon="download-cloud" />
						{{ $i18n.settings.labels.import }}
					</button>
				</div>

				<p class="sui-description">
					{{ $i18n.settings.descriptions.import_config_json }}
				</p>
			</div>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import FileUpload from '@/components/elements/file-upload'

export default {
	name: 'ImportConfigs',

	components: { SuiIcon, FileUpload },

	data() {
		return {
			files: [],
			reader: new FileReader(),
			videos: 0,
			playlists: 0,
			display: false,
			permissions: false,
			thumb: false,
		}
	},

	mounted() {
		// On file read.
		this.reader.onload = this.setData
	},

	computed: {
		/**
		 * Check if we can start importing.
		 *
		 * Import is possible only when files are filled.
		 *
		 * @since 1.8.3
		 *
		 * @returns boolean
		 */
		canImport() {
			return this.files.length > 0
		},
	},

	methods: {
		/**
		 * Click on the file field when button is clicked.
		 *
		 * @since 1.8.3
		 *
		 * @returns {void}
		 */
		openUpload() {
			this.$refs.uploadBtn.click()
		},

		/**
		 * On file field change event.
		 *
		 * On file change, read the content of the file.
		 *
		 * @since 1.8.3
		 *
		 * @returns {void}
		 */
		changeUpload(files) {
			this.files = files

			// Read file.
			if (files.length > 0) {
				this.reader.readAsText(files[0])
			}
		},

		/**
		 * Set the count and data details.
		 *
		 * Read the json file and check the content
		 * to get the overview of the file.
		 *
		 * @param {object} event Event.
		 *
		 * @since 1.8.3
		 *
		 * @returns {void}
		 */
		setData(event) {
			try {
				// Parse the json data.
				let data = JSON.parse(event.target.result)

				// Set the values from json.
				this.thumb = data.thumb
				this.videos = Object.keys(data.videos).length
				this.playlists = Object.keys(data.playlists).length
				this.display = this.isSelected(data.settings, 'display')
				this.permissions = this.isSelected(data.settings, 'permissions')
			} catch (e) {}
		},

		/**
		 * Check if a settings group is selected
		 *
		 * @param {object} data Settings data.
		 * @param {string} type Settings type
		 *
		 * @since 1.8.3
		 *
		 * @returns {boolean}
		 */
		isSelected(data, type) {
			let fields = {
				permissions: ['roles'],
				display: [
					'show_menu',
					'menu_title',
					'menu_location',
					'contextual_help',
				],
			}

			if (fields[type]) {
				return fields[type].some((key) =>
					Object.keys(data).includes(key)
				)
			}

			return false
		},

		/**
		 * Open the confirmation modal.
		 *
		 * @since 1.8.3
		 *
		 * @returns {void}
		 */
		showConfirmation() {
			// Emit confirmation modal.
			this.$root.$emit('openImportConfirmationModal', {
				file: this.files[0],
				videos: this.videos,
				playlists: this.playlists,
				display: this.display,
				permissions: this.permissions,
				thumb: this.thumb,
			})
		},
	},
}
</script>
