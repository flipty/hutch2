<template>
	<div id="wpmudev-videos-videos-list" class="sui-box" :class="loadingClass">
		<p role="alert" class="loading-text" aria-live="polite">
			<span
				class="sui-icon-loader sui-md sui-loading"
				aria-hidden="true"
			></span>
			{{ $i18n.videos.labels.loading }}
		</p>
		<div class="sui-box-header">
			<h2 class="sui-box-title">
				{{ $i18n.videos.titles.available_videos }}
			</h2>
		</div>

		<div class="sui-box-body">
			<p>{{ $i18n.videos.descriptions.videos }}</p>
		</div>

		<div class="wpmudev-videos-accordion">
			<div class="wpmudev-videos-accordion--header" aria-hidden="true">
				<div class="wpmudev-videos-accordion--row">
					<p class="wpmudev-videos-accordion--col-large">
						{{ $i18n.videos.labels.video_title }}
					</p>
					<p class="wpmudev-videos-accordion--col-small">
						{{ $i18n.videos.labels.duration }}
					</p>
				</div>
			</div>

			<!-- Custom videos -->
			<video-row
				v-for="videoObject in getVideos.custom"
				:id="videoObject.id"
				:key="videoObject.id"
				:action="getAction"
			/>

			<!-- Show notices -->
			<div class="wpmudev-videos-accordion--notice" v-if="!validMember()">
				<upgrade-notice v-if="shouldUpgrade" />
				<expired-notice v-else-if="expiredMember()" />
				<dash-notice v-else />
			</div>

			<!-- Default videos -->
			<video-row
				v-for="videoObject in getVideos.default"
				:id="videoObject.id"
				:key="videoObject.id"
				:action="getAction"
			/>
		</div>

		<!-- Go to top button -->
		<goto-top-button />
	</div>
</template>

<script>
import { mapState } from 'vuex'
import VideoRow from './sections/video-row'
import DashNotice from '@/components/notices/dash-notice'
import ExpiredNotice from '@/components/notices/expired-notice'
import UpgradeNotice from '@/components/notices/upgrade-notice'
import GotoTopButton from '@/components/elements/goto-top-button'

export default {
	name: 'VideosBox',

	components: {
		VideoRow,
		DashNotice,
		ExpiredNotice,
		UpgradeNotice,
		GotoTopButton,
	},

	props: {
		action: {
			type: String,
			default: '',
		},
		video: {
			type: Number | String,
			default: 0,
		},
		loading: {
			type: Boolean,
			default: false,
		},
	},

	mounted() {
		// Init clipboard JS.
		new ClipboardJS('.beehive-copy-shortcode')
	},

	computed: mapState({
		/**
		 * Get the loading class if required.
		 *
		 * @since 1.8.3
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				loading: this.loading,
			}
		},

		/**
		 * Check if current membership needs an upgrade.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		shouldUpgrade() {
			return (
				!this.expiredMember() &&
				!this.validMember() &&
				this.dashConnected()
			)
		},

		/**
		 * Check if there are videos.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		hasVideos() {
			return this.hasDefaultVideos || this.hasCustomVideos
		},

		/**
		 * Check if there are default videos.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		hasDefaultVideos() {
			return this.getVideos.default && this.getVideos.default.length > 0
		},

		/**
		 * Check if there are custom videos.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		hasCustomVideos() {
			return this.getVideos.custom && this.getVideos.custom.length > 0
		},

		/**
		 * Get the action object data.
		 *
		 * @since 1.8.0
		 *
		 * @return {object}
		 */
		getAction() {
			return {
				id: this.video,
				action: this.action,
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
		getVideos(state) {
			let videos = {
				default: [],
				custom: [],
			}

			// Only if it's array.
			if (Array.isArray(state.videos.filtered)) {
				// Get filtered ids in reverse order.
				const sorted = state.videos.filtered.sort().reverse()

				sorted.forEach(function (id) {
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

			return videos
		},
	}),
}
</script>
