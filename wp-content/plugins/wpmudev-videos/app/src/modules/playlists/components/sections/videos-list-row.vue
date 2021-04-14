<template>
	<tr aria-live="polite">
		<td class="wpmudev-videos-table-videos--cell-left sui-table-item-title">
			<list-thumb
				:thumb="video.thumbnail || {}"
				:is-custom="isCustomVideo"
				:icon="video.video_slug"
				class="playlist-video-thumb-wide"
			/>
			{{ video.video_title }}
		</td>
		<td
			class="wpmudev-videos-table-videos--cell-right wpmudev-videos-table-videos--show-mobiles"
			v-if="isAdded"
		>
			<span class="sui-button sui-disabled" aria-hidden="true">
				<sui-icon icon="check" />
				{{ $i18n.buttons.added }}
			</span>
			<button
				role="button"
				class="sui-button sui-button-red sui-button-ghost"
				@click="removeVideo"
			>
				<sui-icon icon="trash" />
				{{ $i18n.buttons.remove }}
			</button>
		</td>
		<td
			class="wpmudev-videos-table-videos--cell-right wpmudev-videos-table-videos--show-desktop"
			v-if="isAdded"
		>
			<button
				v-if="hover"
				role="button"
				class="sui-button sui-button-red"
				@mouseleave="hover = false"
				@click="removeVideo"
			>
				<sui-icon icon="trash" />
				{{ $i18n.buttons.remove }}
			</button>
			<button
				v-else
				role="button"
				class="sui-button"
				@mouseover="hover = true"
			>
				<sui-icon icon="check" />
				{{ $i18n.buttons.added }}
			</button>
		</td>
		<td class="wpmudev-videos-table-videos--cell-right" v-else>
			<button
				role="button"
				class="sui-button sui-button-ghost"
				@click="addVideo"
			>
				<sui-icon icon="plus" />
				{{ $i18n.buttons.add }}
			</button>
		</td>
	</tr>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import ListThumb from '@/components/elements/list-thumb'

export default {
	name: 'VideosListRow',

	components: { SuiIcon, ListThumb },

	props: {
		playlist: {
			type: Object,
			required: true,
		},
		video: {
			type: Object,
			required: true,
		},
	},

	data() {
		return {
			hover: false,
		}
	},

	computed: {
		/**
		 * Playlist videos option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		videos: {
			get() {
				return this.playlist.videos
			},

			set(videos) {
				let playlist = this.playlist

				playlist.videos = videos

				// Emit playlist update event.
				this.$emit('update:playlist', playlist)
			},
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
		 * Check if the current video is already added.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		isAdded() {
			return this.videos.includes(this.video.id)
		},
	},

	methods: {
		/**
		 * Add a video to the playlist.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		addVideo() {
			// Add into the list.
			if (!this.videos.includes(this.video.id)) {
				this.videos.push(this.video.id)
			}
		},

		/**
		 * Remove a video from the playlist.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		removeVideo() {
			let video = this.video.id

			if (this.videos.includes(video)) {
				this.videos = this.videos.filter((id) => id !== video)
			}
		},
	},
}
</script>
