<template>
	<div class="sui-wrap">
		<sui-header
			:actions-left="true"
			:title="$i18n.playlists.titles.playlists"
		>
			<template #actions-left>
				<button
					role="button"
					class="sui-button sui-button-blue"
					id="wpmudev-videos-playlist-create-opener"
					@click="$root.$emit('openPlaylistCreateModal')"
				>
					<sui-icon icon="plus" />
					{{ $i18n.playlists.buttons.create_playlist }}
				</button>
			</template>
		</sui-header>
		<!-- Summary box -->
		<summary-box />

		<!-- Upgrade account notice -->
		<upgrade-notice v-if="shouldUpgrade" />
		<!-- Expired account notice -->
		<expired-notice v-else-if="expiredMember()" />
		<!-- Dash plugin unavailability notice -->
		<dash-notice v-else-if="!validMember()" />

		<!-- Bulk actions -->
		<bulk-actions :selected.sync="selected" />

		<!-- Playlists list -->
		<router-view :loading="loading" :selected.sync="selected" />

		<!-- Playlist delete modal -->
		<playlist-delete-form />
		<!-- modal end -->

		<!-- Playlist bulk delete modal -->
		<playlist-bulk-delete-form />
		<!-- modal end -->

		<!-- Playlist settings modal -->
		<playlist-settings-form />
		<!-- modal end -->

		<!-- Playlist videos modal -->
		<playlist-videos-form />
		<!-- modal end -->

		<!-- Playlist edit modal -->
		<playlist-edit-form />
		<!-- modal end -->

		<!-- Playlist create modal -->
		<playlist-create-form />
		<!-- modal end -->

		<sui-footer />
	</div>
</template>

<script>
import Playlists from './views/playlists'
import SummaryBox from './views/summary-box'
import BulkActions from './views/bulk-actions'
import SuiIcon from '@/components/sui/sui-icon'
import SuiHeader from '@/components/sui/sui-header'
import SuiFooter from '@/components/sui/sui-footer'
import DashNotice from '@/components/notices/dash-notice'
import ExpiredNotice from '@/components/notices/expired-notice'
import UpgradeNotice from '@/components/notices/upgrade-notice'
import PlaylistEditForm from './views/modals/playlist-edit-form'
import PlaylistCreateForm from './views/modals/playlist-create-form'
import PlaylistDeleteForm from './views/modals/playlist-delete-form'
import PlaylistVideosForm from './views/modals/playlist-videos-form'
import PlaylistSettingsForm from './views/modals/playlist-settings-form'
import PlaylistBulkDeleteForm from './views/modals/playlist-bulk-delete-form'

export default {
	name: 'App',

	components: {
		SuiIcon,
		Playlists,
		SuiHeader,
		SuiFooter,
		DashNotice,
		SummaryBox,
		BulkActions,
		ExpiredNotice,
		UpgradeNotice,
		PlaylistEditForm,
		PlaylistCreateForm,
		PlaylistDeleteForm,
		PlaylistVideosForm,
		PlaylistSettingsForm,
		PlaylistBulkDeleteForm,
	},

	data() {
		return {
			selected: {},
			loading: false,
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
	async created() {
		this.loading = true

		await this.$store.dispatch('videos/init')
		await this.$store.dispatch('playlists/init', {
			show_all: 1,
		})

		this.loading = false
	},

	computed: {
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
	},
}
</script>

<style lang="scss">
@import 'styles/main';
</style>
