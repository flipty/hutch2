<template>
	<tr>
		<td class="sui-table-item-title">
			<div class="wpmudev-videos-table--title">
				<!-- Bulk selection checkbox -->
				<bulk-select-check
					type="video"
					:id="`wpmudev-playlists-${playlist.id}-videos-item-${video.id}`"
					v-model="isSelected"
				/>

				<list-thumb
					:thumb="video.thumbnail || {}"
					:is-custom="isCustomVideo"
					:icon="video.video_slug"
					class="playlist-video-thumb"
				/>
				<span>{{ video.video_title }}</span>
			</div>
		</td>
		<td class="wpmudev-videos-table--date">{{ getDate }}</td>
		<td class="wpmudev-videos-table--actions">
			<button
				type="button"
				role="button"
				class="sui-button-icon sui-tooltip sui-tooltip-top-right"
				:class="deletingClass"
				:data-tooltip="$i18n.playlists.labels.remove_from_playlist"
				@click="removeVideo(video.id)"
			>
				<span class="sui-loading-text" aria-hidden="true">
					<sui-icon icon="trash" />
				</span>
				<sui-icon icon="loader" class="sui-loading" />
				<span class="sui-screen-reader-text">
					{{ $i18n.buttons.delete }}
				</span>
			</button>
		</td>
	</tr>
</template>

<script>
import moment from 'moment'
import { restDelete } from '@/helpers/api'
import SuiIcon from '@/components/sui/sui-icon'
import ListThumb from '@/components/elements/list-thumb'
import BulkSelectCheck from '@/components/elements/bulk-select-check'

export default {
	name: 'PlaylistVideos',

	components: {
		ListThumb,
		SuiIcon,
		BulkSelectCheck,
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
			required: true,
		},
	},

	data() {
		return {
			deleting: false,
		}
	},

	computed: {
		/**
		 * Get the loading class if delete is being processed.
		 *
		 * @since 1.8.0
		 *
		 * @return {*}
		 */
		deletingClass() {
			return {
				'sui-button-onload': this.deleting,
			}
		},

		/**
		 * Check if current video is custom video.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		isCustomVideo() {
			return this.video.video_type && 'custom' === this.video.video_type
		},

		/**
		 * Computed model object to handle selection.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		isSelected: {
			get() {
				let playlist = this.selected[this.playlist.id] || {}
				let videos = playlist.videos || []

				return videos.includes(this.video.id)
			},

			set(selected) {
				let playlist = this.selectedPlaylist
				let videos = playlist.videos || []

				// Only if not already selected.
				if (selected && !videos.includes(this.video.id)) {
					videos.push(this.video.id)
				} else if (!selected) {
					// Remove the selection.
					videos = videos.filter((video) => video !== this.video.id)
				}

				playlist.videos = videos

				this.selectedPlaylist = playlist
			},
		},

		/**
		 * Get the video creation data as per the design.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		getDate() {
			// Only if date set.
			if (this.video.date && '' !== this.video.date) {
				let date = moment(this.video.date)

				// Format to human time.
				return date.format('MMMM D/YYYY @ hh:mm A')
			} else {
				return ''
			}
		},

		/**
		 * Model for the selected videos.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		selectedPlaylist: {
			get() {
				return (
					this.selected[this.playlist.id] || {
						selected: false,
						videos: [],
					}
				)
			},

			set(playlist) {
				let selected = this.selected

				// Make sure it's reactive.
				this.$set(selected, this.playlist.id, playlist)

				// Emit selected update event.
				this.$emit('update:selected', selected)
			},
		},
	},

	methods: {
		/**
		 * Remove the current video from playlist.
		 *
		 * @since 1.8.0
		 */
		async removeVideo() {
			this.deleting = true

			await restDelete({
				path: 'playlists/' + this.playlist.id + '/videos',
				data: {
					videos: [this.video.id],
				},
			}).then((response) => {
				if (response.success) {
					this.removeFromPlaylist()
				}

				this.deleting = false
			})
		},

		/**
		 * Remove the deleted video from playlist.
		 *
		 * We need to update the Vuex copy.
		 *
		 * @since 1.8.0
		 */
		removeFromPlaylist() {
			let playlist = this.playlist

			// Remove the deleted video.
			playlist.videos = playlist.videos.filter(
				(video) => video !== this.video.id
			)

			this.$store.dispatch('playlists/setPlaylist', playlist)
		},
	},
}
</script>
