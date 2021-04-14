<template>
	<div :class="containerClass" :id="`${form}-video-thumbnail`">
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

			<button :aria-label="$i18n.labels.remove_file" @click="removeThumb">
				<i class="sui-icon-close" aria-hidden="true"></i>
			</button>
		</div>
	</div>
</template>

<script>
import MediaUpload from '@/components/elements/media-upload'

export default {
	name: 'VideoThumbnail',

	components: { MediaUpload },

	props: {
		form: {
			type: String,
			required: true,
		},
		video: {
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
		 * @returns {*}
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
				return this.video.thumbnail
			},

			set(thumb) {
				let video = this.video

				video.thumbnail = thumb

				// Emit video update event.
				this.$emit('update:video', video)
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

			// Emit url sync event.
			this.$root.$emit('syncUrlEmbed', {
				form: this.form,
			})
		},

		/**
		 * Remove thumbnail data of video.
		 *
		 * @since 1.8.0
		 */
		removeThumb() {
			this.thumb = {
				id: 0,
				file: '',
				url: '',
			}

			// Emit url sync event.
			this.$root.$emit('syncUrlEmbed', {
				form: this.form,
			})
		},
	},
}
</script>
