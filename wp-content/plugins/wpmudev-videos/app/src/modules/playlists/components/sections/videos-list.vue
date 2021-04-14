<template>
	<table
		class="sui-table sui-table-flushed wpmudev-videos-table-videos"
		v-if="videosAvailable"
	>
		<thead>
			<tr>
				<th class="wpmudev-videos-table-videos--cell-left">
					{{ $i18n.playlists.labels.videos }}
				</th>
				<th
					class="wpmudev-videos-table-videos--cell-right"
					aria-live="assertive"
				>
					{{
						sprintf(
							$i18n.playlists.labels.videos_selected,
							playlist.videos.length
						)
					}}
				</th>
			</tr>
		</thead>

		<tbody>
			<!-- Custom video item -->
			<videos-list-row
				v-for="video in getVideos.custom"
				:key="video.id"
				:video="video"
				:playlist="playlist"
			/>

			<!-- Default video item -->
			<fragment v-if="showDefaultVideos">
				<videos-list-row
					v-for="video in getVideos.default"
					:key="video.id"
					:video="video"
					:playlist="playlist"
				/>
			</fragment>
		</tbody>
	</table>
</template>

<script>
import { mapState } from 'vuex'
import VideosListRow from './videos-list-row'

export default {
	name: 'VideosList',

	components: { VideosListRow },

	props: {
		form: {
			type: String,
			required: true,
		},
		count: {
			type: Number,
			default: 0,
		},
		playlist: {
			type: Object,
			required: true,
		},
	},

	computed: mapState({
		/**
		 * Get the videos list from Vuex.
		 *
		 * We will use the filtered list to include
		 * search results.
		 *
		 * @since 1.8.0
		 *
		 * @return {object}
		 */
		getVideos(state) {
			let count = 0
			let videos = {
				default: [],
				custom: [],
			}
			// Get filtered items.
			let filtered = state.videos.filtered

			// Only if it's array.
			if (Array.isArray(filtered)) {
				filtered.forEach((id) => {
					if (state.videos.videos[id]) {
						let video = state.videos.videos[id]
						// Get the video object.
						if ('default' === video.video_type) {
							// Default videos.
							videos.default.push(video)
						} else {
							// Custom videos.
							videos.custom.push(video)
						}
					}
				})
			}

			// Update the count.
			if (this.showDefaultVideos) {
				count = videos.default.length + videos.custom.length
			} else {
				count = videos.custom.length
			}

			// Update the prop.
			this.$emit('update:count', count)

			return videos
		},

		/**
		 * Check if current membership is valid.
		 *
		 * Default videos are available only if current
		 * membership is valid.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		showDefaultVideos() {
			return this.validMember() && this.dashConnected()
		},

		/**
		 * Check if videos are not empty.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		videosAvailable() {
			return (
				(this.getVideos.default.length && this.showDefaultVideos) ||
				this.getVideos.custom.length
			)
		},
	}),
}
</script>
