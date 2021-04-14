<template>
	<div class="sui-form-field wpmudev-videos-field--thumbnail">
		<label class="sui-label">
			{{ $i18n.playlists.labels.playlist_thumbnail }}
		</label>

		<p class="sui-description">
			{{ $i18n.playlists.descriptions.playlist_thumbnail }}
		</p>

		<div :class="containerClass" :id="`${form}-playlist-thumbnail`">
			<div class="sui-upload-image" aria-hidden="true">
				<div class="sui-image-mask"></div>
				<div
					v-if="hasThumb"
					role="button"
					class="sui-image-preview"
					:style="previewBtnStyle"
				></div>
				<div v-else role="button" class="sui-image-preview"></div>
			</div>

			<media-upload @mediaUploaded="setThumb" />

			<div class="sui-upload-file" v-if="hasThumb">
				<span>{{ thumb.file }}</span>

				<button
					:aria-label="$i18n.labels.remove_file"
					@click="removeThumb"
				>
					<sui-icon icon="close" />
				</button>
			</div>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import MediaUpload from '@/components/elements/media-upload'

export default {
	name: 'PlaylistThumbnail',

	components: { MediaUpload, SuiIcon },

	props: {
		form: {
			type: String,
			required: true,
		},
		playlist: {
			type: Object,
			required: true,
		},
	},

	computed: {
		/**
		 * Get the container class based on the conditions.
		 *
		 * @since 1.8.0
		 *
		 * @returns {object}
		 */
		containerClass() {
			return {
				'sui-upload': true,
				'sui-has_file': this.hasThumb,
			}
		},

		/**
		 * Get preview button styles.
		 *
		 * @since 1.8.0
		 *
		 * @returns {object}
		 */
		previewBtnStyle() {
			return {
				'background-image': 'url(' + this.thumb.url + ')',
			}
		},

		/**
		 * Check if thumbnail is available.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		hasThumb() {
			return this.thumb.id > 0 && this.thumb.file && this.thumb.url
		},

		/**
		 * Video thumbnail option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		thumb: {
			get() {
				return this.playlist.thumbnail
			},

			set(thumb) {
				let playlist = this.playlist

				playlist.thumbnail = thumb

				// Emit playlist update event.
				this.$emit('update:playlist', playlist)
			},
		},
	},

	methods: {
		/**
		 * Set thumbnail data after upload.
		 *
		 * @since 1.8.0
		 */
		setThumb(data) {
			this.thumb = {
				id: data.id,
				file: data.filename,
				url: data.url,
			}
		},

		/**
		 * Remove thumbnail data of playlist.
		 *
		 * @since 1.8.0
		 */
		removeThumb() {
			this.thumb = {
				id: 0,
				file: '',
				url: '',
			}
		},
	},
}
</script>
