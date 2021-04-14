<template>
	<whitelabel-summary>
		<div class="sui-summary-segment">
			<div class="sui-summary-details">
				<span class="sui-summary-large">{{ total }}</span>
				<span class="sui-summary-sub">
					{{ $i18n.dashboard.labels.total_videos }}
				</span>
				<span class="sui-summary-detail" v-if="lastTime === ''">
					{{ $i18n.dashboard.labels.never }}
				</span>
				<span class="sui-summary-detail" v-else>{{ lastTime }}</span>
				<span class="sui-summary-sub">
					{{ $i18n.dashboard.labels.last_uploaded }}
				</span>
			</div>
		</div>
		<div class="sui-summary-segment">
			<ul class="sui-list">
				<li>
					<span
						class="sui-list-label"
						:title="$i18n.dashboard.labels.recently_updated"
					>
						{{ $i18n.dashboard.labels.recently_updated }}
					</span>
					<span class="sui-list-detail" v-if="recent === ''">
						{{ $i18n.dashboard.labels.never }}
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
						:title="$i18n.dashboard.labels.recently_created_custom"
					>
						{{ $i18n.dashboard.labels.recently_created_custom }}
					</span>
					<span class="sui-list-detail" v-if="recentCustom === ''">
						{{ $i18n.dashboard.labels.never }}
					</span>
					<span class="sui-list-detail" v-else>
						<a
							:href="`${$vars.urls.videos}#/view/${recentCustom.id}`"
						>
							{{ recentCustom.video_title }}
						</a>
					</span>
				</li>
				<li>
					<span
						class="sui-list-label"
						:title="
							$i18n.dashboard.labels.recently_created_playlist
						"
					>
						{{ $i18n.dashboard.labels.recently_created_playlist }}
					</span>
					<span class="sui-list-detail" v-if="playlist === ''">
						{{ $i18n.dashboard.labels.never }}
					</span>
					<span class="sui-list-detail" v-else>
						{{ playlist.title }}
					</span>
				</li>
			</ul>
		</div>
	</whitelabel-summary>
</template>

<script>
import moment from 'moment'
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
			total: 0,
			lastTime: '',
			recent: '',
			recentCustom: '',
			playlist: '',
		}
	},

	mounted() {
		// Update the stats.
		this.updateStats()
	},

	methods: {
		/**
		 * Get summary stats from API.
		 *
		 * @since 1.8.0
		 */
		updateStats() {
			restGet({
				path: 'summary',
			}).then((response) => {
				if (response.success && response.data) {
					// Setup summary from response.
					this.setStats(response.data)
				}
			})
		},

		/**
		 * Setup stats in required format.
		 *
		 * @since 1.8.0
		 *
		 * @param data
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

			// Recently created playlist.
			if (recent.created_playlist.title) {
				this.playlist = recent.created_playlist
			}

			// Last video updated time.
			if (recent.updated_video.date) {
				let date = moment(recent.updated_video.date)
				// Format to human time.
				this.lastTime = date.format('MMMM D, YYYY [at] hh:mm a')
			}

			// Total video count.
			if (counts.videos) {
				this.total = counts.videos
			}
		},
	},
}
</script>
