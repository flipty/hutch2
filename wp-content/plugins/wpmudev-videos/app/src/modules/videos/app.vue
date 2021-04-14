<template>
	<div class="sui-wrap">
		<sui-header :actions-left="true" :title="$i18n.videos.titles.videos">
			<template #actions-left>
				<button
					role="button"
					class="sui-button sui-button-blue"
					id="wpmudev-videos-create-form-opener"
					@click="$root.$emit('openVideoCreateModal')"
				>
					<i class="sui-icon-plus" aria-hidden="true"></i>
					{{ $i18n.videos.buttons.add_custom_video }}
				</button>
			</template>
		</sui-header>

		<!-- Summary box -->
		<summary-box @search="afterSearch" @clearSearch="clearSearch" />
		<!-- Summary end -->

		<!-- Videos empty results -->
		<empty-box v-if="searchEmpty" :search="searchTerm" />
		<!-- videos end -->

		<!-- Videos section -->
		<router-view :loading="loading" v-else />
		<!-- results end -->

		<!-- Video title edit modal -->
		<video-title-form />
		<!-- modal end -->

		<!-- Video create modal -->
		<video-create-form />
		<!-- modal end -->

		<!-- Video edit modal -->
		<video-edit-form />
		<!-- modal end -->

		<!-- Video delete modal -->
		<video-delete-form />
		<!-- modal end -->

		<!-- Video playlist edit modal -->
		<video-playlist-form />
		<!-- modal end -->

		<sui-footer />
	</div>
</template>

<script>
import EmptyBox from './views/empty-box'
import SummaryBox from './views/summary-box'
import SuiHeader from '@/components/sui/sui-header'
import SuiFooter from '@/components/sui/sui-footer'
import VideoEditForm from './views/modals/video-edit-form'
import VideoTitleForm from './views/modals/video-title-form'
import VideoDeleteForm from './views/modals/video-delete-form'
import VideoCreateForm from './views/modals/video-create-form'
import VideoPlaylistForm from './views/modals/video-playlist-form'

export default {
	name: 'App',

	components: {
		EmptyBox,
		SuiHeader,
		SuiFooter,
		SummaryBox,
		VideoEditForm,
		VideoTitleForm,
		VideoDeleteForm,
		VideoCreateForm,
		VideoPlaylistForm,
	},

	data() {
		return {
			loading: false,
			searchEmpty: false,
			searchTerm: '',
		}
	},

	/**
	 * On page render, get the list of videos
	 * and playlist and store them in Vuex.
	 *
	 * @since 1.8.0
	 *
	 * @return {Promise<void>}
	 */
	async mounted() {
		this.loading = true

		// Get the data.
		await this.$store.dispatch('videos/init')
		await this.$store.dispatch('playlists/init')

		this.loading = false
	},

	methods: {
		/**
		 * Process the event after search.
		 *
		 * If empty results, we need to show message box.
		 *
		 * @since 1.8.0
		 */
		afterSearch(data) {
			this.searchTerm = data.search
			this.searchEmpty = data.empty
		},

		/**
		 * Process the search clear event.
		 *
		 * Clear the empty message and show all videos.
		 *
		 * @since 1.8.0
		 */
		clearSearch() {
			this.searchTerm = ''
			this.searchEmpty = false
		},
	},
}
</script>

<style lang="scss">
@import 'styles/main';
</style>
