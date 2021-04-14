<template>
	<div class="sui-box-body">
		<p class="sui-settings-label">{{ $i18n.videos.labels.settings }}</p>

		<p class="sui-description">
			{{ $i18n.videos.descriptions.customize_duration }}
		</p>

		<div class="sui-form-field">
			<video-start-time :form="form" :video.sync="video" />
		</div>

		<div class="sui-form-field" v-if="showEndTime">
			<video-end-time :form="form" :video.sync="video" />
		</div>

		<p class="sui-settings-label">
			{{ $i18n.videos.labels.thumbnail_image }}
		</p>
		<p class="sui-description">
			{{ $i18n.videos.descriptions.customize_thumbnail }}
		</p>

		<div class="sui-form-field">
			<video-thumbnail :form="form" :video.sync="video" />
		</div>
	</div>
</template>

<script>
import VideoEndTime from './../fields/video-end-time'
import VideoThumbnail from './../fields/video-thumbnail'
import VideoStartTime from './../fields/video-start-time'

export default {
	name: 'VideoSettings',

	components: {
		VideoEndTime,
		VideoThumbnail,
		VideoStartTime,
	},

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
		 * Check if current video can show end time.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		showEndTime() {
			let host = this.video.host || 'youtube'

			return this.$moduleVars.hosts?.[host]?.end_time
		},
	},
}
</script>
