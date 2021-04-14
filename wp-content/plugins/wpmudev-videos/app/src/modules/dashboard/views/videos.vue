<template>
	<div class="sui-box">
		<div class="sui-box-header">
			<h3 class="sui-box-title">
				<sui-icon icon="animation-video" />
				{{ $i18n.dashboard.titles.videos }}
			</h3>
		</div>

		<div class="sui-box-body">
			<p>{{ $i18n.dashboard.descriptions.videos }}</p>

			<p v-if="!hasVideos">
				<a
					role="button"
					class="sui-button sui-button-blue"
					:href="$vars.urls.videos + '#/create'"
				>
					<sui-icon icon="plus" />
					{{ $i18n.dashboard.buttons.add_custom_videos }}
				</a>
			</p>
		</div>

		<table
			class="sui-table sui-table-flushed wpmudev-videos-box-table"
			v-if="hasVideos"
		>
			<thead>
				<tr>
					<th class="wpmudev-videos-row--name">
						{{ $i18n.dashboard.labels.recently_added_videos }}
					</th>
					<th class="wpmudev-videos-row--options">
						<span class="sui-screen-reader-text">
							{{ $i18n.dashboard.labels.videos_options_menu }}
						</span>
					</th>
				</tr>
			</thead>

			<tbody>
				<tr v-for="video in getVideos" :key="video.id">
					<td class="sui-table-item-title wpmudev-videos-row--name">
						<div class="wpmudev-videos-name-wrapper">
							<list-thumb
								class="video-thumb"
								:thumb="video.thumbnail || {}"
								:is-custom="'custom' === video.video_type"
								:icon="video.video_slug"
							/>
							<a :href="`${$vars.urls.videos}#/view/${video.id}`">
								{{ video.video_title }}
							</a>
						</div>
					</td>

					<td class="wpmudev-videos-row--options">
						<div class="sui-dropdown">
							<button
								class="sui-button-icon sui-dropdown-anchor"
								:aria-label="$i18n.dashboard.labels.actions"
							>
								<sui-icon icon="widget-settings-config" />
							</button>
							<ul>
								<li>
									<a
										:href="`${$vars.urls.videos}#/edit/${video.id}`"
									>
										<sui-icon icon="pencil" />
										{{
											video.video_type === 'custom'
												? $i18n.dashboard.buttons
														.edit_video
												: $i18n.dashboard.buttons
														.edit_title
										}}
									</a>
								</li>
								<li>
									<button
										class="beehive-copy-shortcode"
										:data-clipboard-text="
											getShortCode(video)
										"
										@click="copiedNotice"
									>
										<sui-icon icon="code" />
										{{
											$i18n.dashboard.buttons
												.copy_shortcode
										}}
									</button>
								</li>
								<li>
									<a
										:href="`${$vars.urls.videos}#/playlist/${video.id}`"
									>
										<sui-icon icon="list" />
										{{
											$i18n.dashboard.buttons
												.add_to_playlist
										}}
									</a>
								</li>
								<li v-if="video.video_type === 'custom'">
									<a
										:href="`${$vars.urls.videos}#/delete/${video.id}`"
										class="wpmudev-videos-red"
									>
										<sui-icon icon="trash" />
										{{ $i18n.buttons.delete }}
									</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="sui-box-footer" v-if="hasVideos">
			<a
				role="button"
				class="sui-button sui-button-blue"
				:href="$vars.urls.videos + '#/create'"
			>
				<sui-icon icon="plus" />
				{{ $i18n.dashboard.buttons.add_custom_videos }}
			</a>

			<div class="sui-actions-right">
				<a
					role="button"
					class="sui-button sui-button-ghost"
					:href="$vars.urls.videos"
				>
					<sui-icon icon="eye" />
					{{ $i18n.dashboard.buttons.view_all }}
				</a>
			</div>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import ListThumb from '@/components/elements/list-thumb'

export default {
	name: 'Videos',

	components: { SuiIcon, ListThumb },

	mounted() {
		// Init clipboard JS.
		new ClipboardJS('.beehive-copy-shortcode')
	},

	/**
	 * On page render, get the list of videos
	 * and store them in Vuex.
	 *
	 * @since 1.8.0
	 *
	 * @return {Promise<void>}
	 */
	created() {
		this.$store.dispatch('videos/init', {
			count: 5,
			type: this.validMember() ? '' : 'custom',
		})
	},

	computed: {
		/**
		 * Get the videos list from Vuex.
		 *
		 * We will use the filtered list to include
		 * search results.
		 *
		 * @since 1.8.4
		 *
		 * @return {object}
		 */
		getVideos() {
			let videos = []
			let filtered = this.$store.state.videos.filtered
			let storeVideos = this.$store.state.videos.videos

			// Only if it's array.
			if (Array.isArray(filtered)) {
				// Get filtered ids in reverse order.
				const sorted = filtered.sort().reverse()

				sorted.forEach(function (id) {
					if (storeVideos[id]) {
						// Get the video object.
						videos.push(storeVideos[id])
					}
				})
			}

			return videos
		},

		/**
		 * Check if we have videos available.
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
		 * Get shortcode for the video.
		 *
		 * @since 1.8.0
		 *
		 * @return {string}
		 */
		getShortCode(video) {
			if ('custom' === video.video_type) {
				return '[wpmudev-video video="' + video.id + '"]'
			} else {
				return '[wpmudev-video video="' + video.video_slug + '"]'
			}
		},

		/**
		 * Show the shortcode copied message.
		 *
		 * @since 1.8.0
		 */
		copiedNotice() {
			this.$root.$emit('showTopNotice', {
				message: this.$i18n.notices.shortcode_copied,
			})
		},
	},
}
</script>
