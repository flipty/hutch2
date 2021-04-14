<template>
	<whitelabel-summary>
		<div class="sui-summary-segment">
			<div class="sui-summary-details">
				<p class="sui-summary-large">{{ total }}</p>

				<p class="sui-summary-sub">{{ $i18n.videos.titles.videos }}</p>

				<div class="sui-form-field">
					<label
						for="wpmudev-videos-search"
						id="wpmudev-videos-search--label"
						class="sui-screen-reader-text"
					>
						{{ $i18n.videos.labels.search_videos }}
					</label>

					<div class="sui-with-button">
						<div
							class="sui-with-button sui-with-button-inside"
							v-if="showClear"
						>
							<div class="sui-control-with-icon">
								<input
									v-model="search"
									:placeholder="
										$i18n.videos.labels.search_videos
									"
									id="wpmudev-videos-search"
									class="sui-form-control"
									aria-labelledby="wpmudev-videos-search--label"
									@keyup.enter="doSearch"
								/>

								<sui-icon
									icon="magnifying-glass-search"
									size="md"
								/>
							</div>

							<button
								role="button"
								class="sui-button-icon"
								@click="clearSearch"
							>
								<sui-icon icon="close" size="sm" />
								<i class="sui-screen-reader-text">
									{{ $i18n.buttons.clear_search }}
								</i>
							</button>
						</div>

						<div class="sui-control-with-icon" v-else>
							<input
								v-model="search"
								:placeholder="$i18n.videos.labels.search_videos"
								id="wpmudev-videos-search"
								class="sui-form-control"
								aria-labelledby="wpmudev-videos-search--label"
								@keyup.enter="doSearch"
							/>

							<sui-icon
								icon="magnifying-glass-search"
								size="md"
							/>
						</div>

						<button
							type="button"
							class="sui-button sui-button-blue sui-button-lg"
							@click="doSearch"
							:disabled="search.length < 1"
							:class="{ 'sui-button-onload': searching }"
						>
							<span class="sui-loading-text">
								{{ $i18n.buttons.search }}
							</span>
							<sui-icon icon="loader" :animate="true" />
						</button>
					</div>

					<div
						role="alert"
						aria-live="polite"
						class="sui-screen-reader-text"
						:hidden="hideMessage"
					>
						<p v-if="hideMessage"></p>
						<p v-else-if="'clear' === messageType">
							{{ $i18n.videos.notices.search_cleared }}
						</p>
						<p v-else>
							{{
								sprintf(
									$i18n.videos.notices.search_results,
									resultsCount
								)
							}}
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="sui-summary-segment">
			<ul class="sui-list">
				<li>
					<span
						class="sui-list-label"
						:title="$i18n.videos.labels.recently_updated"
					>
						{{ $i18n.videos.labels.recently_updated }}
					</span>
					<span class="sui-list-detail" v-if="recent === ''">
						{{ $i18n.videos.labels.never }}
					</span>
					<span class="sui-list-detail" v-else>
						<a :href="`${$vars.urls.videos}#/view/${recent.id}`">
							{{ recent.video_title }}
						</a>
					</span>
				</li>

				<li>
					<span
						class="sui-list-label"
						:title="$i18n.videos.labels.recent_host"
					>
						{{ $i18n.videos.labels.recent_host }}
					</span>
					<span class="sui-list-detail">{{ getHostName(host) }}</span>
				</li>

				<li>
					<span
						class="sui-list-label"
						:title="$i18n.videos.labels.recent_custom_video"
					>
						{{ $i18n.videos.labels.recent_custom_video }}
					</span>
					<span class="sui-list-detail" v-if="recentCustom === ''">
						{{ $i18n.videos.labels.never }}
					</span>
					<span class="sui-list-detail" v-else>
						<a
							:href="`${$vars.urls.videos}#/view/${recentCustom.id}`"
						>
							{{ recentCustom.video_title }}
						</a>
					</span>
				</li>
			</ul>
		</div>
	</whitelabel-summary>
</template>

<script>
import { restGet } from '@/helpers/api'
import SuiIcon from '@/components/sui/sui-icon'
import WhitelabelSummary from '@/components/elements/whitelabel-summary'

export default {
	name: 'SummaryBox',

	components: {
		SuiIcon,
		WhitelabelSummary,
	},

	data() {
		return {
			search: '',
			searching: false,
			showClear: false,
			total: 0,
			recent: '',
			recentCustom: '',
			host: '',
			hideMessage: true,
			resultsCount: 0,
			messageType: 'clear',
		}
	},

	mounted() {
		// Update the summary status.
		this.updateStats()
	},

	created() {
		// When video is deleted.
		this.$root.$on('customVideoDeleted', this.updateStats)

		// When new video is added.
		this.$root.$on('customVideoCreated', this.updateStats)
	},

	methods: {
		/**
		 * Update the video page summary details.
		 *
		 * @since 1.8.0
		 */
		updateStats() {
			restGet({
				path: 'summary',
			}).then((response) => {
				if (response.success && response.data) {
					this.setStats(response.data)
				}
			})
		},

		/**
		 * Format and setup the summary data.
		 *
		 * @param {object} data Summary data.
		 *
		 * @since 1.8.0
		 */
		setStats(data) {
			let recent = data.recent
			let counts = data.count

			// Last updated video.
			if (recent.updated_video.video_title) {
				this.recent = recent.updated_video
			}

			// Recently created custom video.
			if (recent.created_custom_video.video_title) {
				this.recentCustom = recent.created_custom_video
			}

			// Recent video host.
			if (recent.created_custom_video.video_host) {
				this.host = recent.created_custom_video.video_host
			}

			// Total video count.
			if (counts.videos) {
				this.total = counts.videos
			}
		},

		/**
		 * Get the host name from key.
		 *
		 * @param {string} host Host key.
		 *
		 * @since 1.8.0
		 *
		 * @return {string}
		 */
		getHostName(host) {
			// If found in global vars.
			if ('' === host) {
				// If empty.
				host = this.$i18n.videos.labels.never
			} else if (this.$moduleVars.hosts && this.$moduleVars.hosts[host]) {
				host = this.$moduleVars.hosts[host].name
			}

			return host
		},

		/**
		 * Search the videos and filter.
		 *
		 * @since 1.8.0
		 */
		async doSearch() {
			this.searching = true

			// Get the search results.
			let results = await this.getResults()

			if (!!results) {
				// Update the filer results.
				this.$store.dispatch('videos/setFiltered', results)

				// Emit the event.
				this.$emit('search', {
					search: this.search,
					empty: results.length <= 0,
				})

				this.showClear = true

				// Set the results count.
				this.resultsCount = results.length

				// Show the message.
				this.showAlert('search')
			}

			this.searching = false
		},

		/**
		 * Clear the search results.
		 *
		 * @since 1.8.0
		 */
		async clearSearch() {
			this.search = ''
			this.showClear = false

			let results = await this.getResults()

			if (!!results) {
				// Update the filer results.
				this.$store.dispatch('videos/setFiltered', results)

				// Show message.
				this.showAlert('clear')

				// Emit the event.
				this.$emit('clearSearch')
			}
		},

		/**
		 * Perform the video search get the results.
		 *
		 * @since 1.8.0
		 *
		 * @returns {array|boolean}
		 */
		async getResults() {
			let results = false

			// Get the results.
			await restGet({
				path: 'videos',
				params: {
					search: this.search,
					field: 'ids',
				},
			}).then((response) => {
				if (response.success && response.data) {
					results = response.data
				}
			})

			return results
		},

		/**
		 * Show search and clear message for screenreaders.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		showAlert(type) {
			// Show the message.
			this.hideMessage = false
			// Message type.
			this.messageType = type
			// Hide again after 3 seconds.
			setTimeout(() => {
				this.hideMessage = true
			}, 3000)
		},
	},
}
</script>
