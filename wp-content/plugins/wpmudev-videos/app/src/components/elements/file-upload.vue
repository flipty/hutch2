<template>
	<div class="sui-upload" :class="selectedClass">
		<input
			type="file"
			readonly="readonly"
			ref="file"
			:accept="accept"
			@change="onSelect"
		/>
		<button class="sui-upload-button" @click="openSelector">
			<sui-icon icon="upload-cloud" />
			{{ $i18n.settings.buttons.upload_file }}
		</button>
		<div class="sui-upload-file">
			<span>{{ getName }}</span>
			<button
				:aria-label="$i18n.settings.buttons.remove_file"
				@click="removeFile"
			>
				<sui-icon icon="close" />
			</button>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'FileUpload',

	components: { SuiIcon },

	props: {
		accept: {
			type: String,
			default: '',
		},
	},

	data() {
		return {
			file: '',
		}
	},

	computed: {
		/**
		 * Get uploaded media data from cache.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		selectedClass() {
			return {
				'sui-has_file': this.isSelected,
			}
		},

		/**
		 * Get the selected file name.
		 *
		 * @since 1.8.3
		 *
		 * @returns {string}
		 */
		getName() {
			return this.file ? this.file.name : ''
		},

		/**
		 * Check if any file is selected.
		 *
		 * @since 1.8.3
		 *
		 * @returns {boolean}
		 */
		isSelected() {
			return !!this.file.name
		},
	},

	methods: {
		/**
		 * On upload button click, click on the file input.
		 *
		 * @since 1.8.3
		 */
		openSelector() {
			this.$refs.file.click()
		},

		/**
		 * Open the media upload modal.
		 *
		 * @since 1.8.3
		 */
		onSelect(e) {
			if (e.target.files.length) {
				// Set the first file.
				this.file = this.$refs.file.files[0]

				this.$emit('select', this.$refs.file.files)
			}
		},

		/**
		 * Remove currently selected file.
		 *
		 * @since 1.8.3
		 */
		removeFile() {
			this.file = ''
			this.$refs.file.val = null
			this.$emit('select', '')
		},
	},
}
</script>
