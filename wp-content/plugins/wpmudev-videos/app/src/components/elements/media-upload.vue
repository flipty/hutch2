<template>
	<button class="sui-upload-button" @click="openMedia">
		<sui-icon icon="upload-cloud" />
		{{ $i18n.buttons.upload_image }}
	</button>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'MediaUpload',

	components: { SuiIcon },

	data() {
		return {
			uploader: null,
		}
	},

	computed: {
		/**
		 * Get uploaded media data from cache.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		getData() {
			return this.uploader.state().get('selection').first().toJSON()
		},
	},

	methods: {
		/**
		 * Get a new wp media object.
		 *
		 * @since 1.8.0
		 *
		 * @returns {object}
		 */
		getMedia() {
			return wp
				.media({
					title: this.$i18n.buttons.upload_thumb,
					library: {
						type: 'image',
					},
					button: {
						text: this.$i18n.buttons.set_as_thumbnail,
					},
					multiple: false,
				})
				.on('select', this.selectMedia)
		},

		/**
		 * Emit the media select event.
		 *
		 * @since 1.8.0
		 */
		selectMedia() {
			this.$emit('mediaUploaded', this.getData)
		},

		/**
		 * Open the media upload modal.
		 *
		 * @since 1.8.0
		 */
		openMedia() {
			// Create new instance if not available.
			if (null === this.uploader) {
				this.uploader = this.getMedia()
			}

			this.uploader.open()
		},
	},
}
</script>
