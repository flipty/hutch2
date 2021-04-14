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
				<div class="sui-box-header">
					<h3 :id="`${modal}-title`" class="sui-box-title">
						{{ $i18n.playlists.labels.edit_playlist }}
					</h3>

					<button
						class="sui-button-icon sui-button-float--right"
						@click="closeModal"
					>
						<sui-icon icon="close" size="md" />
						<span class="sui-screen-reader-text">
							{{ $i18n.dialogs.close }}
						</span>
					</button>
				</div>

				<div class="sui-box-body">
					<div class="sui-box-settings-row">
						<div class="sui-box-settings-col-2">
							<!-- Playlist title -->
							<playlist-title
								:form="modal"
								:playlist.sync="playlist"
							/>

							<!-- Playlist description -->
							<playlist-description
								:form="modal"
								:playlist.sync="playlist"
							/>
						</div>
					</div>

					<div class="sui-box-settings-row">
						<div class="sui-box-settings-col-2">
							<!-- Playlist thumbnail -->
							<playlist-thumbnail
								:form="modal"
								:playlist.sync="playlist"
							/>
						</div>
					</div>
				</div>

				<div class="sui-box-footer sui-flatten sui-content-center">
					<button
						type="button"
						class="sui-button sui-button-blue"
						aria-live="polite"
						@click="saveChanges"
						:class="loadingClass"
						:disabled="saving"
					>
						<span class="sui-button-text-default">{{
							$i18n.buttons.save_changes
						}}</span>
						<span class="sui-button-text-onload">
							<sui-icon icon="loader" class="sui-loading" />
							{{ $i18n.buttons.saving_changes }}
						</span>
					</button>
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
import PlaylistTitle from './../../components/fields/playlist-title'
import PlaylistThumbnail from './../../components/fields/playlist-thumbnail'
import PlaylistDescription from './../../components/fields/playlist-description'

export default {
	name: 'PlaylistEditForm',

	components: {
		SuiNotice,
		PlaylistTitle,
		PlaylistThumbnail,
		PlaylistDescription,
		SuiIcon,
	},

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-playlist-edit-modal',
			saving: false,
			showError: false,
			playlist: {
				id: 0,
				title: '',
				description: '',
				thumbnail: {
					id: 0,
					file: '',
					url: '',
				},
			},
		}
	},

	created() {
		this.$root.$on('openPlaylistEditFormModal', (data) => {
			this.setPlaylist(data.playlist)
			this.closeFocus = data.focus
			this.showSettings = true
			this.showForm = true

			this.openModal()
		})
	},

	computed: {
		/**
		 * Loading class during save.
		 *
		 * @since 1.8.0
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.saving,
			}
		},

		/**
		 * Error class if error happen.
		 *
		 * @since 1.8.0
		 */
		errorClass() {
			return {
				'sui-form-field-error': this.showError,
			}
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
				thumbnail: playlist.thumbnail,
			}
		},

		/**
		 * Save the playlist settings using API.
		 *
		 * Use the helper function so we don't have
		 * to worry about the Vuex.
		 *
		 * @since 1.8.0
		 */
		async saveChanges() {
			if (this.playlist.id > 0 && !this.saving) {
				// Get the video.
				let playlist = this.playlist

				// Set saving flag.
				this.saving = true

				// Update the playlist.
				let result = await updatePlaylist(this.playlist.id, {
					title: playlist.title,
					description: playlist.description,
					thumbnail: playlist.thumbnail.id,
				})

				if (result.success) {
					// Close modal.
					this.closeModal()

					// Fire updated event.
					this.$root.$emit('playlistUpdated', playlist)

					// Show success notice.
					this.$root.$emit('showTopNotice', {
						message: sprintf(
							this.$i18n.playlists.notices.playlist_updated,
							playlist.title
						),
					})
				} else {
					// Show error notice.
					this.$root.$emit('showTopNotice', {
						type: 'error',
						message: sprintf(
							this.$i18n.playlists.notices.playlist_update_failed,
							playlist.title
						),
					})
				}

				// Remove saving flag.
				this.saving = false
			}
		},
	},
}
</script>
