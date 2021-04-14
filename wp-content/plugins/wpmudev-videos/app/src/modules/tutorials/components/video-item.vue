<template>
	<button
		role="tab"
		class="wpmudev-videos-section--video"
		:class="{ 'wpmudev-videos-active': isSelected }"
		:tabindex="isSelected ? false : '-1'"
		:aria-selected="isSelected ? 'true' : 'false'"
		:id="`tab--playlist-${playlist.id}-video-${video.id}`"
		:aria-controls="`tab-content--playlist-${playlist.id}-video-${video.id}`"
		@click="showPreview"
	>
		<span class="sui-screen-reader-text">
			{{ $i18n.buttons.click_to_open }} {{ video.video_title }}
		</span>

		<span class="wpmudev-videos-section--video-head" aria-hidden="true">
			<span class="video-thumbnail">
				<span class="video-thumbnail-content">
					<list-thumb
						:thumb="video.thumbnail || {}"
						:is-custom="'custom' === video.video_type"
						:icon="video.video_slug"
						class="video-thumb"
						tag="span"
					/>

					<span class="video-thumbnail-name">
						{{ video.video_title }}
					</span>
				</span>
			</span>

			<sui-icon icon="play" size="sm" />
		</span>

		<span class="wpmudev-videos-section--video-body" aria-hidden="true">
			<span class="video-title">{{ video.video_title }}</span>

			<span class="video-duration">{{ video.video_duration || '' }}</span>
		</span>
	</button>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import ListThumb from '@/components/elements/list-thumb'

export default {
	name: 'VideoItem',

	components: {
		SuiIcon,
		ListThumb,
	},

	props: {
		video: {
			type: Object,
			required: true,
		},
		playlist: {
			type: Object,
			required: true,
		},
		selected: {
			type: Object,
			default: {
				playlist: '',
				video: '',
			},
		},
	},

	computed: {
		/**
		 * Check if current video is the selected one.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		isSelected() {
			return (
				this.playlist.id === parseInt(this.selected.playlist) &&
				this.video.id === parseInt(this.selected.video)
			)
		},
	},

	methods: {
		/**
		 * Handle the video preview change event.
		 *
		 * @since 1.8.0
		 */
		showPreview() {
			this.$router
				.push({
					name: 'VideosList',
					params: {
						action: 'view',
						playlist: this.playlist.id,
						video: this.video.id,
					},
				})
				.catch(() => {})
		},
	},
}
</script>
