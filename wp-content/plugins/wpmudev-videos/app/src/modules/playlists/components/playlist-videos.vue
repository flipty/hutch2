<template>
	<table class="sui-table sui-table-flushed">
		<thead>
			<tr>
				<th class="sui-table-item-title">{{ $i18n.playlists.labels.video_title }}</th>
				<th class="wpmudev-videos-table--date">{{ $i18n.playlists.labels.date_added }}</th>
				<th class="wpmudev-videos-table--actions">
					<span class="sui-screen-reader-text">
						{{ $i18n.playlists.labels.row_actions }}
					</span>
				</th>
			</tr>
		</thead>

		<tbody v-if="hasVideos">
			<!-- Single playlist item -->
			<playlist-video
				v-for="video in getVideos"
				:video="video"
				:playlist="playlist"
				:selected.sync="selected"
				:key="video.id"
			/>
		</tbody>
		<tbody v-else>
			<tr>
				<td colspan="3">
					{{ $i18n.playlists.descriptions.no_videos }}
				</td>
			</tr>
		</tbody>

		<tfoot>
			<tr>
				<td colspan="3">
					<button
						role="button"
						class="sui-button sui-button-blue"
						@click="openVideosForm"
					>
						<sui-icon icon="plus" />
						{{ $i18n.playlists.buttons.add_video }}
					</button>
				</td>
			</tr>
		</tfoot>
	</table>
</template>

<script>
import PlaylistVideo from './playlist-video'
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'PlaylistVideos',

	components: { PlaylistVideo, SuiIcon },

	props: {
		videos: {
			type: Array,
			required: true,
		},
		playlist: {
			type: Object,
			required: true,
		},
		selected: {
			type: Object,
			required: true,
		},
	},

	computed: {
		/**
		 * Get the video object from Vuex.
		 *
		 * We use the computed function to get the
		 * updated video object from Vuex.
		 *
		 * @since 1.8.0
		 *
		 * @return {object}
		 */
		getVideos() {
			// Get the store.
			const $store = this.$store

			// Init with an empty list.
			let videos = []

			this.videos.forEach(function (id) {
				// Get the video object.
				let video = $store.getters['videos/video'](id)

				if (video.id) {
					videos.push(video)
				}
			})

			return videos
		},

		/**
		 * Check if the playlist has videos.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		hasVideos() {
			return this.getVideos.length > 0
		},
	},

	methods: {
		/**
		 * Emit the videos modal open event.
		 *
		 * @since 1.8.0
		 */
		openVideosForm() {
			this.$root.$emit('openPlaylistVideosFormModal', {
				playlist: this.playlist,
				focus: 'wpmudev-videos-playlist-item-' + this.playlist.id,
			})
		},
	},
}
</script>
