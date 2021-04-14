<template>
	<div class="sui-modal sui-modal-lg">
		<div
			role="dialog"
			:id="modal"
			class="sui-modal-content sui-content-fade-out"
			aria-modal="true"
			:aria-labelledby="`${modal}-title`"
		>
			<div class="sui-box">
				<div
					class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60 sui-spacing-sides--100"
				>
					<whitelabel-modal-banner
						src="modal/modal-header-playlists.png"
						:alt="$i18n.playlists.titles.add_videos"
					/>

					<button
						@click="closeModal"
						class="sui-button-icon sui-button-float--right"
					>
						<sui-icon icon="close" size="md" />
						<span class="sui-screen-reader-text">
							{{ $i18n.dialogs.close }}
						</span>
					</button>

					<h3 :id="`${modal}-title`" class="sui-box-title sui-lg">
						{{ $i18n.playlists.titles.add_videos }}
					</h3>

					<p :id="`${modal}-desc`" class="sui-description">
						{{ $i18n.playlists.descriptions.select_videos }}
					</p>
				</div>

				<div class="sui-box-body">
					<sui-notice type="error" v-if="error">
						<p>
							{{ $i18n.playlists.notices.playlist_create_failed }}
						</p>
					</sui-notice>

					<!-- Video search -->
					<videos-search :form="modal" />

					<!-- When membership is not valid -->
					<upgrade-notice v-if="showUpgradeNotice" />
					<!-- When membership is expired -->
					<expired-notice v-else-if="showExpiredNotice" />
				</div>

				<!-- Video list -->
				<videos-list
					:form="modal"
					:playlist.sync="playlist"
					:count.sync="videoCount"
				/>

				<div class="sui-box-footer">
					<button
						class="sui-button sui-button-ghost"
						@click="closeModal"
					>
						{{ $i18n.buttons.cancel }}
					</button>
					<div class="sui-actions-right">
						<button
							type="button"
							class="sui-button"
							aria-live="polite"
							:class="loadingClass"
							:disabled="playlist.videos.length <= 0"
							@click="saveChanges"
						>
							<span class="sui-button-text-default">
								{{ $i18n.playlists.buttons.add_videos }}
							</span>
							<span class="sui-button-text-onload">
								<sui-icon icon="loader" class="sui-loading" />
								{{ $i18n.playlists.buttons.adding_videos }}
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Modal from '@/components/mixins/modal'
import SuiIcon from '@/components/sui/sui-icon'
import SuiNotice from '@/components/sui/sui-notice'
import { updatePlaylist } from '@/helpers/playlists'
import VideosList from './../../components/sections/videos-list'
import VideosSearch from './../../components/sections/videos-search'
import ExpiredNotice from './../../components/notices/expired-notice'
import UpgradeNotice from './../../components/notices/upgrade-notice'
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'

export default {
	name: 'PlaylistVideosForm',

	components: {
		SuiIcon,
		SuiNotice,
		VideosList,
		VideosSearch,
		ExpiredNotice,
		UpgradeNotice,
		WhitelabelModalBanner,
	},

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-playlist-videos-modal',
			saving: false,
			error: false,
			playlist: {
				id: 0,
				title: '',
				description: '',
				videos: [],
			},
			videoCount: 0,
		}
	},

	created() {
		// Open the modal and set the playlist data.
		this.$root.$on('openPlaylistVideosFormModal', (data) => {
			this.setPlaylist(data.playlist)
			this.closeFocus = data.focus

			this.openModal()
		})
	},

	computed: {
		/**
		 * Loading class during save.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.saving,
			}
		},

		/**
		 * Check if we need to show the membership upgrade notice.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		showUpgradeNotice() {
			return (
				!this.expiredMember() &&
				!this.validMember() &&
				this.dashConnected() &&
				this.videoCount <= 0
			)
		},

		/**
		 * Check if we need to show the membership expired notice.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		showExpiredNotice() {
			return (
				this.expiredMember() &&
				this.dashConnected() &&
				this.videoCount <= 0
			)
		},
	},

	methods: {
		/**
		 * Set playlist fields from current playlist.
		 *
		 * @param {object} playlist Playlist data.
		 *
		 * @since 1.8.0
		 */
		setPlaylist(playlist) {
			this.playlist = {
				id: playlist.id,
				title: playlist.title,
				description: playlist.description,
				videos: playlist.videos,
			}
		},

		/**
		 * Save the playlist videos using API.
		 *
		 * Use the helper function so we don't have
		 * to worry about the Vuex.
		 *
		 * @since 1.8.0
		 */
		async saveChanges() {
			if (this.playlist.id > 0 && !this.saving) {
				// Get the playlist.
				let playlist = this.playlist

				// Set saving flag.
				this.saving = true

				// Update the playlist.
				let result = await updatePlaylist(this.playlist.id, {
					videos: playlist.videos,
				})

				if (result.success) {
					// Close modal.
					this.closeModal()

					// Show success notice.
					this.$root.$emit('showTopNotice', {
						message: this.$i18n.playlists.notices
							.playlist_videos_updated,
					})
				} else {
					// Show error notice.
					this.$root.$emit('showTopNotice', {
						type: 'error',
						message: this.$i18n.playlists.notices
							.playlist_videos_update_failed,
					})
				}

				// Remove saving flag.
				this.saving = false
			}
		},
	},
}
</script>
