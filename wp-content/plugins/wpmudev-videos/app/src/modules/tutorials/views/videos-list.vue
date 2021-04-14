<template>
	<div class="sui-box">
		<div class="sui-box-header">
			<h1 id="wpmudev-videos-navigation--label" class="sui-box-title">
				{{ $i18n.tutorials.titles.videos }}
			</h1>
		</div>

		<div class="sui-box-body">
			<p>{{ $i18n.tutorials.descriptions.videos }}</p>

			<div class="sui-form-field">
				<label
					for="wpmudev-videos-search"
					id="wpmudev-videos-search--label"
					class="sui-screen-reader-text"
				>
					{{ $i18n.tutorials.labels.search }}
				</label>

				<div class="sui-with-button">
					<div
						class="sui-with-button sui-with-button-inside"
						v-if="showClear"
					>
						<div class="sui-control-with-icon">
							<input
								v-model="search"
								:placeholder="$i18n.tutorials.labels.search"
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
							<span class="sui-screen-reader-text">
								{{ $i18n.buttons.clear_search }}
							</span>
						</button>
					</div>

					<div class="sui-control-with-icon" v-else>
						<input
							v-model="search"
							:placeholder="$i18n.tutorials.labels.search"
							id="wpmudev-videos-search"
							class="sui-form-control"
							aria-labelledby="wpmudev-videos-search--label"
							@keyup.enter="doSearch"
						/>

						<sui-icon icon="magnifying-glass-search" size="md" />
					</div>

					<button
						type="button"
						class="sui-button sui-button-blue sui-button-lg"
						aria-live="polite"
						@click="doSearch"
						:disabled="search.length < 1"
						:class="{ 'sui-button-onload-text': searching }"
					>
						<span class="sui-button-text-default">
							{{ $i18n.buttons.search }}
						</span>
						<span class="sui-button-text-onload">
							<sui-icon
								icon="loader"
								size="sm"
								class="sui-loading"
							/>
							{{ $i18n.buttons.searching }}
						</span>
					</button>
				</div>
			</div>
		</div>

		<div class="wpmudev-videos-section" :class="loadingClass">
			<menu-loader v-if="loading" />
			<sticky-menu :playlists="getPlaylists" v-else />

			<div
				role="alert"
				aria-live="polite"
				class="sui-screen-reader-text"
				:hidden="hideMessage"
			>
				<p v-if="hideMessage"></p>
				<p v-else-if="'clear' === messageType">
					{{ $i18n.tutorials.notices.search_cleared }}
				</p>
				<p v-else>
					{{
						sprintf(
							$i18n.tutorials.notices.search_results,
							resultsCount
						)
					}}
				</p>
			</div>

			<fragment v-if="loading">
				<video-loader />
				<video-loader />
			</fragment>
			<fragment v-else>
				<video-section
					v-for="playlist in getPlaylists"
					:selected="getSelection"
					:key="playlist.id"
					:playlist="playlist"
				/>
			</fragment>
		</div>
	</div>
</template>

<script>
import { mapState } from 'vuex'
import { restGet } from '@/helpers/api'
import SuiIcon from '@/components/sui/sui-icon'
import StickyMenu from './../components/sticky-menu'
import MenuLoader from './../components/menu-loader'
import VideoLoader from './../components/video-loader'
import VideoSection from './../components/video-section'

export default {
	name: 'VideosList',

	components: {
		SuiIcon,
		StickyMenu,
		MenuLoader,
		VideoLoader,
		VideoSection,
	},

	props: {
		action: {
			type: String,
			default: '',
		},
		playlist: {
			type: Number | String,
			default: 0,
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

	data() {
		return {
			search: '',
			searching: false,
			hideMessage: true,
			resultsCount: 0,
			showClear: false,
			messageType: 'clear',
		}
	},

	computed: {
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
		 * Get the list of playlists.
		 *
		 * We need to remove the ones with no videos assigned
		 * to them (though it should not happen, taking extra care).
		 *
		 * @since 1.8.0
		 *
		 * @returns {array}
		 */
		getPlaylists() {
			let filtered = {}

			// Get playlists.
			const playlists = this.playlists

			// Get filtered list.
			const videos = this.$store.state.videos.filtered

			if (Array.isArray(videos)) {
				Object.keys(playlists).forEach((id) => {
					if (
						playlists[id].videos &&
						playlists[id].videos.length > 0
					) {
						// Loop through each videos of playlist.
						playlists[id].videos.forEach((video) => {
							// Check if video is available in filtered list.
							if (videos.includes(video)) {
								filtered[id] = playlists[id]
							}
						})
					}
				})
			} else {
				// Remove empty playlists.
				Object.keys(playlists).forEach((id) => {
					if (
						playlists[id].videos &&
						playlists[id].videos.length > 0
					) {
						filtered[id] = playlists[id]
					}
				})
			}

			return filtered
		},

		/**
		 * Get the selection data object.
		 *
		 * @since 1.8.0
		 *
		 * @return {object}
		 */
		getSelection() {
			if (this.action !== '' && this.playlist > 0 && this.video > 0) {
				return {
					playlist: this.playlist,
					video: this.video,
				}
			} else {
				return {
					playlist: '',
					video: '',
				}
			}
		},

		/**
		 * Get the playlist list from Vuex.
		 *
		 * We us this computed method to sort the
		 * playlists in order.
		 *
		 * @since 1.8.3
		 *
		 * @return {object}
		 */
		playlists() {
			let playlists = []
			// Get vuex data.
			let storePlaylists = this.$store.state.playlists.playlists
			let storeFiltered = this.$store.state.playlists.filtered

			// Only if it's array.
			if (Array.isArray(storeFiltered)) {
				storeFiltered.forEach(function (id) {
					if (storePlaylists[id]) {
						playlists.push(storePlaylists[id])
					}
				})
			}

			return playlists
		},
	},

	methods: {
		/**
		 * Perform the video search and filtering.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		async doSearch() {
			this.searching = true

			// Get the results.
			let results = await this.getResults()

			if (!!results) {
				// Set the vuex.
				this.$store.dispatch('videos/setFiltered', results)

				// Show clear button.
				this.showClear = true

				// Set the results count.
				this.resultsCount = results.length
				// Show the message.
				this.showAlert('search')
			}

			this.searching = false
		},

		/**
		 * Perform the video search and filtering.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		async clearSearch() {
			// Clear the search term.
			this.search = ''

			// Get the results.
			let results = await this.getResults()

			if (results) {
				// Set the vuex.
				this.$store.dispatch('videos/setFiltered', results)

				// Show the message.
				this.showAlert('clear')
			}

			// Hide clear button.
			this.showClear = false
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
