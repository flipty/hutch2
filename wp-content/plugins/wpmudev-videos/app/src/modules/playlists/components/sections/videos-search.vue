<template>
	<div class="sui-form-field">
		<div class="sui-control-with-icon">
			<sui-icon icon="magnifying-glass-search" />
			<input
				class="sui-form-control"
				v-model="search"
				:id="`${form}-playlist-videos-search`"
				:placeholder="$i18n.playlists.labels.search_videos"
				@keyup="searchVideos"
			/>
		</div>
	</div>
</template>

<script>
import { restGet } from '@/helpers/api'
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'VideosSearch',

	components: { SuiIcon },

	props: {
		form: {
			type: String,
			required: true,
		},
	},

	data() {
		return {
			search: '',
		}
	},

	methods: {
		/**
		 * Search the videos and filter.
		 *
		 * Get the video ids using the search term
		 * and sync back to parent.
		 *
		 * @since 1.8.0
		 */
		searchVideos() {
			restGet({
				path: 'videos',
				params: {
					search: this.search,
					field: 'ids',
				},
			}).then((response) => {
				if (response.success && response.data) {
					// Update the filtered ids.
					this.$store.dispatch('videos/setFiltered', response.data)
				}
			})
		},
	},
}
</script>
