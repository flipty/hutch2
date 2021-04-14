<template>
	<div
		tabindex="0"
		:id="`section-playlist-${playlist.id}`"
		:class="sectionClass"
		v-if="getVideos.length"
	>
		<div class="wpmudev-videos-section--videos-list-header">
			<div class="wpmudev-videos-section--videos-list-content">
				<h2 class="wpmudev-videos-section--block-title">
					{{ playlist.title }}
				</h2>

				<p
					class="wpmudev-videos-section--block-description"
					v-if="'' !== playlist.description"
				>
					{{ playlist.description }}
				</p>
			</div>
			<div
				class="wpmudev-videos-section--videos-list-navigator"
				aria-hidden="true"
			>
				<button
					class="sui-button-icon sui-button-blue prev"
					:disabled="disableRight"
					@click="slideMenu(-40)"
				>
					<sui-icon icon="chevron-left" size="sm" />
				</button>

				<button
					class="sui-button-icon sui-button-blue next"
					:disabled="disableLeft"
					@click="slideMenu(40)"
				>
					<sui-icon icon="chevron-right" size="sm" />
				</button>
			</div>
		</div>

		<div :class="videoSectionClass">
			<button
				class="sui-button-icon wpmudev-videos-section--videos-list-handler"
				aria-hidden="true"
				tabindex="-1"
				@click="toggleFullView"
			>
				<sui-icon icon="chevron-right" size="sm" />
			</button>

			<div
				role="tablist"
				class="wpmudev-videos-section--videos-list"
				ref="videosList"
			>
				<video-item
					v-for="video in getVideos"
					:video="video"
					:key="video.id"
					:playlist="playlist"
					:selected="selected"
				/>
			</div>

			<video-player
				:video="selected.video"
				:playlist="playlist"
				:selected="isSelected"
			/>
		</div>
	</div>
</template>

<script>
import VideoItem from './video-item'
import VideoPlayer from './video-player'
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'VideoSection',

	components: {
		SuiIcon,
		VideoItem,
		VideoPlayer,
	},

	props: {
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

	data() {
		return {
			fullView: false,
			disableLeft: false,
			disableRight: true,
		}
	},

	mounted() {
		// Initialize accordion.
		SUI.tabs()

		// Update arrows.
		this.updateArrows()

		// Handle resize event.
		window.addEventListener('resize', this.updateArrows)
	},

	beforeDestroy() {
		// Remove resize event.
		window.removeEventListener('resize', this.updateArrows)
	},

	computed: {
		/**
		 * Check if the current section is selected.
		 *
		 * If the selected video is within the current section (playlist).
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		isSelected() {
			return (
				this.playlist.id === parseInt(this.selected.playlist) &&
				this.playlist.videos.includes(parseInt(this.selected.video))
			)
		},

		/**
		 * Get the current section classes.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		sectionClass() {
			return {
				'wpmudev-videos-section--block': true,
				'wpmudev-videos-active': this.isSelected,
			}
		},

		/**
		 * Get the current video section classes.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		videoSectionClass() {
			return {
				'wpmudev-videos-section--videos': true,
				'wpmudev-videos-sm': this.fullView,
			}
		},

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
		getVideos() {
			// Get the store.
			const $store = this.$store

			// Check if the member is valid.
			const showDefault = this.validMember()

			// Init with an empty list.
			let videos = []

			// Get filtered list.
			let filtered = $store.state.videos.filtered

			// Only if results are not empty.
			if (Array.isArray(filtered) && filtered.length > 0) {
				// Loop through each videos.
				this.playlist.videos.forEach(function (id) {
					if (filtered.includes(id)) {
						// Get the video object.
						let video = $store.getters['videos/video'](id)

						// Do not show default videos if Dash is not active.
						if (
							video.video_type &&
							(('default' === video.video_type && showDefault) ||
								'custom' === video.video_type)
						) {
							if (video.id) {
								videos.push(video)
							}
						}
					}
				})
			}

			return videos
		},
	},

	methods: {
		/**
		 * Toggle the full view flag.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		toggleFullView() {
			this.fullView = !this.fullView
		},

		/**
		 * Slide menu elements to new position.
		 *
		 * We slide 30px on each click.
		 *
		 * @param {int} offset Slide position value.
		 *
		 * @since 1.8.4
		 */
		slideMenu(offset) {
			// Videos list.
			let el = this.$refs.videosList

			// Scroll.
			el.scroll({
				left: el.scrollLeft + offset,
				behavior: 'auto',
			})

			// Update the arrows.
			this.updateArrows()
		},

		/**
		 * Update the arrows if required.
		 *
		 * If there is a scope for scrolling, show arrows.
		 *
		 * @since 1.8.4
		 */
		updateArrows() {
			let el = this.$refs.videosList
			let maxScroll = el.scrollWidth - el.clientWidth

			this.disableRight = el.scrollLeft <= 0
			this.disableLeft = el.scrollLeft >= maxScroll
		},
	},
}
</script>
