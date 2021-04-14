<template>
	<div class="sui-modal sui-modal-sm">
		<div
			role="dialog"
			:id="modal"
			class="sui-modal-content sui-content-fade-in"
			aria-modal="true"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-desc`"
		>
			<div class="sui-box">
				<div
					class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60"
				>
					<button
						class="sui-button-icon sui-button-float--right"
						@click="closeModal"
					>
						<sui-icon icon="close" size="md" />
						<span class="sui-screen-reader-text">
							{{ $i18n.dialogs.close }}
						</span>
					</button>

					<h3 :id="`${modal}-title`" class="sui-box-title sui-lg">
						{{ $i18n.playlists.labels.delete_playlist }}
					</h3>

					<p :id="`${modal}-desc`" class="sui-description">
						{{
							sprintf(
								$i18n.playlists.descriptions.delete_playlist,
								videosCount
							)
						}}
					</p>
				</div>

				<div class="sui-box-footer sui-flatten sui-content-center">
					<button
						class="sui-button sui-button-ghost"
						@click="closeModal"
					>
						{{ $i18n.dialogs.cancel }}
					</button>

					<button
						type="button"
						class="sui-button sui-button-red sui-button-ghost"
						aria-live="polite"
						:id="`${modal}-submit`"
						:class="loadingClass"
						@click="deletePlaylist"
					>
						<span class="sui-button-text-default">
							{{ $i18n.buttons.delete }}
						</span>
						<span class="sui-button-text-onload">
							<sui-icon icon="loader" class="loading" />
							{{ $i18n.buttons.deleting }}
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
import { deletePlaylist } from '@/helpers/playlists'

export default {
	name: 'PlaylistBulkDeleteForm',

	mixins: [Modal],

	components: { SuiIcon },

	data() {
		return {
			modal: 'wpmudev-videos-playlist-bulk-delete-modal',
			deleting: false,
			playlist: {},
		}
	},

	created() {
		this.$root.$on('openPlaylistBulkDeleteFormModal', (data) => {
			this.playlist = data.playlist
			this.closeFocus = data.focus

			this.openModal()
		})
	},

	computed: {
		/**
		 * Get the loading class for the button.
		 *
		 * @since 1.8.0
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.deleting,
			}
		},

		videosCount() {
			if (this.playlist.videos && this.playlist.videos.length > 0) {
				return this.playlist.videos.length
			} else {
				return 0
			}
		},
	},

	methods: {
		/**
		 * Delete the current playlist and update state.
		 *
		 * Vuex will take care of updating the state.
		 *
		 * @since 1.8.0
		 *
		 * @return {Promise<void>}
		 */
		async deletePlaylist() {
			this.deleting = true

			// Delete the video.
			let result = await deletePlaylist(this.playlist.id)

			if (result.success) {
				// Close the modal.
				this.closeModal()

				// Fire deleted event.
				this.$root.$emit('customPlaylistDeleted', this.playlist)

				// Show success notice.
				this.$root.$emit('showTopNotice', {
					message: this.$i18n.playlists.notices.playlist_deleted,
				})

				this.playlist = {}
			} else {
				// Show error notice.
				this.$root.$emit('showTopNotice', {
					type: 'error',
					message: result.message,
				})
			}

			this.deleting = false
		},
	},
}
</script>
