<template>
	<whitelabel-summary :small="true">
		<div class="sui-summary-segment">
			<div class="sui-summary-details">
				<span class="sui-summary-large">{{ getCount }}</span>
				<span class="sui-summary-sub">
					{{ $i18n.playlists.titles.playlists }}
				</span>
			</div>
		</div>
		<div class="sui-summary-segment">
			<ul class="sui-list">
				<li>
					<span
						class="sui-list-label"
						:title="$i18n.playlists.labels.recently_created"
					>
						{{ $i18n.playlists.labels.recently_created }}
					</span>
					<span
						class="sui-list-detail"
						v-html="recentlyCreated"
					></span>
				</li>
				<li>
					<span
						class="sui-list-label"
						:title="$i18n.playlists.labels.recently_updated"
					>
						{{ $i18n.playlists.labels.recently_updated }}
					</span>
					<span
						class="sui-list-detail"
						v-html="recentlyUpdated"
					></span>
				</li>
			</ul>
		</div>
	</whitelabel-summary>
</template>

<script>
import { mapState } from 'vuex'
import { restGet } from '@/helpers/api'
import WhitelabelSummary from '@/components/elements/whitelabel-summary'

export default {
	name: 'SummaryBox',

	components: { WhitelabelSummary },

	data() {
		return {
			total: 0,
			recentlyUpdated: this.$i18n.playlists.labels.never,
			recentlyCreated: this.$i18n.playlists.labels.never,
		}
	},

	mounted() {
		// Update the summary stats.
		this.updateStats()

		// Update summary on playlist creation and update.
		this.$root.$on('playlistUpdated', this.updateStats)
		this.$root.$on('customPlaylistCreated', this.updateStats)
	},

	computed: {
		/**
		 * Get the playlists count from Vuex.
		 *
		 * @since 1.8.0
		 *
		 * @returns {int}
		 */
		getCount() {
			return Object.keys(this.playlists).length || 0
		},

		/**
		 * Get the playlist list from Vuex.
		 *
		 * @since 1.8.0
		 *
		 * @return {object}
		 */
		...mapState('playlists', ['playlists']),
	},

	methods: {
		/**
		 * Update the summary stats using the API.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
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
		 * Set the summart stats from the API response.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		setStats(data) {
			let recent = data.recent
			let counts = data.count

			// Last updated playlist.
			if (recent.updated_playlist.title) {
				this.recentlyUpdated = recent.updated_playlist.title
			}

			// Last created playlist.
			if (recent.created_playlist.title) {
				this.recentlyCreated = recent.created_playlist.title
			}

			// Total playlist count.
			if (counts.playlists) {
				this.total = counts.playlists
			}
		},
	},
}
</script>
