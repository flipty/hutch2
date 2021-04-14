<template>
	<div
		class="sui-accordion-item wpmudev-videos-accordion"
		:id="`wpmudev-videos-playlist-item-${playlist.id}`"
		:data-id="playlist.id"
	>
		<!-- Item header -->
		<div class="sui-accordion-item-header">
			<div class="sui-accordion-item-title sui-trim-title">
				<span class="sui-icon-drag sui-md sortable" aria-hidden="true"></span>
				<!-- Bulk selection checkbox -->
				<bulk-select-check
					type="playlist"
					:id="`wpmudev-playlists-item-${playlist.id}`"
					v-model="isSelected"
				/>

				<list-thumb
					:thumb="playlist.thumbnail"
					:hide-icon="true"
					class="playlist-thumb"
				/>
				{{ playlist.title }}
			</div>

			<div class="sui-accordion-item-date">
				{{ playlist.description }}
			</div>

			<div class="sui-accordion-col-auto">
				<div class="sui-dropdown sui-accordion-item-action">
					<button
						class="sui-button-icon sui-dropdown-anchor"
						:aria-label="$i18n.playlists.labels.playlist_actions"
					>
						<sui-icon icon="widget-settings-config" />
					</button>
					<ul>
						<li>
							<button @click="openEditForm" ref="editButton">
								<sui-icon icon="pencil" />
								{{ $i18n.buttons.edit }}
							</button>
						</li>
						<li>
							<button @click="openVideosForm" ref="videosButton">
								<sui-icon icon="align-justify" />
								{{ $i18n.playlists.buttons.add_videos }}
							</button>
						</li>
						<li>
							<button
								@click="openSettingsForm"
								ref="settingsButton"
							>
								<sui-icon icon="widget-settings-config" />
								{{
									$i18n.playlists.buttons.visibility_settings
								}}
							</button>
						</li>
						<li>
							<button
								class="beehive-copy-shortcode"
								@click="copiedNotice"
								:data-clipboard-text="getShortCode"
							>
								<sui-icon icon="code" />
								{{ $i18n.playlists.buttons.copy_shortcode }}
							</button>
						</li>
						<li v-if="isCustom">
							<button
								@click="openDeleteForm"
								class="wpmudev-videos-red"
								ref="deleteButton"
							>
								<sui-icon icon="trash" />
								{{ $i18n.buttons.delete }}
							</button>
						</li>
					</ul>
				</div>
				<button
					class="sui-button-icon sui-accordion-open-indicator"
					aria-label="Open Item"
				>
					<sui-icon icon="chevron-down" />
				</button>
			</div>
		</div>

		<!-- Item content -->
		<div class="sui-accordion-item-body">
			<div class="sui-box">
				<!-- Playlist videos list -->
				<playlist-videos
					:videos="playlist.videos"
					:playlist="playlist"
					:selected.sync="selected"
				/>
			</div>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import ListThumb from '@/components/elements/list-thumb'
import PlaylistVideos from './../../components/playlist-videos'
import BulkSelectCheck from '@/components/elements/bulk-select-check'

export default {
	name: 'PlaylistItem',

	components: {
		SuiIcon,
		ListThumb,
		PlaylistVideos,
		BulkSelectCheck,
	},

	props: {
		playlist: {
			type: Object,
			required: true,
		},
		selected: {
			type: Object,
			required: true,
		},
		action: {
			type: Object,
			default: {
				id: 0,
				action: '',
			},
		},
	},

	mounted() {
		// Process url actions.
		this.doAction()
	},

	computed: {
		/**
		 * Check if current playlist is custom type.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		isCustom() {
			return (
				this.playlist.playlist_type &&
				'custom' === this.playlist.playlist_type
			)
		},

		/**
		 * Get shortcode of the current playlist.
		 *
		 * @since 1.8.0
		 *
		 * @return {string}
		 */
		getShortCode() {
			return '[wpmudev-video group="' + this.playlist.slug + '"]'
		},

		/**
		 * Computed model object to handle selection.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		isSelected: {
			get() {
				let playlist = this.selected[this.playlist.id] || {}

				return playlist.selected || false
			},

			set(selected) {
				if (selected) {
					this.selectedPlaylist = {
						selected: true,
						videos: this.playlist.videos,
					}
				} else {
					this.selectedPlaylist = false
				}
			},
		},

		/**
		 * Model for the selected videos.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		selectedPlaylist: {
			get() {
				return (
					this.selected[this.playlist.id] || {
						selected: false,
						videos: [],
					}
				)
			},

			set(playlist) {
				let selected = this.selected

				// Make sure it's reactive.
				if (playlist) {
					this.$set(selected, this.playlist.id, playlist)
				} else {
					this.$delete(selected, this.playlist.id)
				}

				// Emit selected update event.
				this.$emit('update:selected', selected)
			},
		},
	},

	methods: {
		/**
		 * Show the shortcode copied message.
		 *
		 * @since 1.8.0
		 */
		copiedNotice() {
			this.$root.$emit('showTopNotice', {
				message: this.$i18n.notices.shortcode_copied,
			})
		},

		/**
		 * Emit the delete modal open event.
		 *
		 * @since 1.8.0
		 */
		openDeleteForm() {
			this.$root.$emit('openPlaylistDeleteFormModal', {
				playlist: this.playlist,
				focus: 'wpmudev-videos-playlist-item-' + this.playlist.id,
			})
		},

		/**
		 * Emit the videos modal open event.
		 *
		 * @since 1.8.0
		 */
		openVideosForm() {
			this.$root.$emit('openPlaylistVideosFormModal', {
				playlist: this.playlist,
				focus: 'wpmudev-videos-playlist-item-' + this.playlist.id,
			})
		},

		/**
		 * Emit the dit modal open event.
		 *
		 * @since 1.8.0
		 */
		openEditForm() {
			this.$root.$emit('openPlaylistEditFormModal', {
				playlist: this.playlist,
				focus: 'wpmudev-videos-playlist-item-' + this.playlist.id,
			})
		},

		/**
		 * Emit the settings modal open event.
		 *
		 * @since 1.8.0
		 */
		openSettingsForm() {
			this.$root.$emit('openPlaylistSettingsFormModal', {
				playlist: this.playlist,
				focus: 'wpmudev-videos-playlist-item-' + this.playlist.id,
			})
		},

		/**
		 * Perform the action from url.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		doAction() {
			// Only if current playlist.
			if (
				'' !== this.action.action &&
				this.action.id == this.playlist.id
			) {
				switch (this.action.action) {
					case 'edit':
						this.$refs.editButton.click()
						break
					case 'videos':
						this.$refs.videosButton.click()
						break
					case 'delete':
						if (this.$refs.deleteButton) {
							this.$refs.deleteButton.click()
						}
						break
					case 'settings':
						this.$refs.settingsButton.click()
						break
				}
			}
		},
	},
}
</script>
