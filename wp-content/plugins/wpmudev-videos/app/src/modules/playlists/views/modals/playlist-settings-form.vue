<template>
	<div class="sui-modal sui-modal-lg">
		<div
			role="dialog"
			:id="modal"
			class="sui-modal-content sui-content-fade-in"
			aria-modal="true"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-desc`"
		>
			<div class="sui-box">
				<button class="sui-screen-reader-text" @click="closeModal">
					{{ $i18n.dialogs.close }}
				</button>

				<div class="sui-box-header">
					<h3 class="sui-box-title">
						{{ $i18n.playlists.titles.visibility_settings }}
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
					<p>
						{{ $i18n.playlists.descriptions.visibility_settings }}
					</p>

					<div class="sui-box-settings-row">
						<div class="sui-box-settings-col-2">
							<span class="sui-settings-label">
								{{ $i18n.playlists.labels.permissions }}
							</span>

							<span class="sui-description">
								{{ $i18n.playlists.descriptions.permissions }}
							</span>

							<div class="sui-form-field">
								<label
									class="sui-checkbox"
									v-if="$vars.flags.network > 0"
								>
									<input
										type="checkbox"
										aria-labelledby="playlist-role-super-admin-label"
										checked
										disabled
									/>
									<span aria-hidden="true"></span>
									<span id="playlist-role-super-admin-label">
										{{ $i18n.labels.super_admin }}
									</span>
								</label>
								<label class="sui-checkbox">
									<input
										type="checkbox"
										aria-labelledby="playlist-role-administrator-label"
										checked
										disabled
									/>
									<span aria-hidden="true"></span>
									<span
										id="playlist-role-administrator-label"
									>
										{{ $i18n.labels.administrator }}
									</span>
								</label>
								<label
									class="sui-checkbox"
									v-for="(label, role) in getRoles"
									:key="role"
								>
									<input
										type="checkbox"
										v-model="roles"
										:aria-labelledby="`playlist-role-${role}-label`"
										:value="role"
									/>

									<span aria-hidden="true"></span>

									<span :id="`playlist-role-${role}-label`">
										{{ label }}
									</span>
								</label>
							</div>
						</div>
					</div>

					<div class="sui-box-settings-row">
						<div class="sui-box-settings-col-2">
							<span class="sui-settings-label">
								{{ $i18n.playlists.labels.location }}
							</span>

							<span class="sui-description">
								{{ $i18n.playlists.descriptions.location }}
							</span>

							<div
								class="sui-form-field"
								v-if="showLocationSettings"
							>
								<label
									class="sui-label"
									for="wpmudev-videos-playlist-location"
								>
									{{ $i18n.playlists.labels.choose_location }}
								</label>

								<sui-select2
									v-model="locations"
									id="wpmudev-videos-playlist-location"
									label-id="wpmudev-videos-playlist-location-label"
									:options="getLocations"
									:multiple="true"
									:placeholder="
										$i18n.playlists.labels.choose_location
									"
									:parent-element="modal"
								/>
							</div>
							<div class="sui-form-field" v-else>
								<sui-notice type="info">
									<p
										v-html="
											sprintf(
												$i18n.playlists.notices
													.enable_contextual_help,
												$vars.urls.settings
											)
										"
									></p>
								</sui-notice>
							</div>
						</div>
					</div>
				</div>

				<div class="sui-box-footer sui-content-center">
					<button
						type="button"
						class="sui-button sui-button-blue"
						:class="loadingClass"
						aria-live="polite"
						@click="saveChanges"
					>
						<span class="sui-button-text-default">
							{{ $i18n.buttons.save_changes }}
						</span>
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
import { getOption } from '@/helpers/utils'
import Modal from '@/components/mixins/modal'
import SuiIcon from '@/components/sui/sui-icon'
import SuiNotice from '@/components/sui/sui-notice'
import { updatePlaylist } from '@/helpers/playlists'
import SuiSelect2 from '@/components/sui/sui-select2'

export default {
	name: 'PlaylistSettingsForm',

	mixins: [Modal],

	components: {
		SuiIcon,
		SuiNotice,
		SuiSelect2,
	},

	data() {
		return {
			modal: 'wpmudev-videos-playlist-settings-modal',
			saving: false,
			playlist: {},
			roles: [],
			locations: [],
		}
	},

	created() {
		this.$root.$on('openPlaylistSettingsFormModal', (data) => {
			this.playlist = data.playlist
			this.locations = data.playlist.playlist_locations
			this.roles = data.playlist.playlist_roles
			this.closeFocus = data.focus

			this.openModal()
		})
	},

	computed: {
		/**
		 * Get the loading class for the button.
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
		 * Get the no. of videos available in current playlist.
		 *
		 * @since 1.8.0
		 *
		 * @return {int}
		 */
		videosCount() {
			if (this.playlist.videos && this.playlist.videos.length > 0) {
				return this.playlist.videos.length
			} else {
				return 0
			}
		},

		/**
		 * Get available list of roles.
		 *
		 * @since 1.8.0
		 *
		 * @return array
		 */
		getRoles() {
			return this.$moduleVars.roles || []
		},

		/**
		 * Get the list of locations.
		 *
		 * @since 1.8.0
		 *
		 * @return object
		 */
		getLocations() {
			let list = []
			// Get the list of locations.
			let locations = this.$moduleVars.locations

			// Format playlists.
			Object.keys(locations).forEach(function (id) {
				list.push({
					id: id,
					text: locations[id],
				})
			})

			return list
		},

		/**
		 * Check if we can show playlist location settings.
		 *
		 * @since 1.8.4
		 *
		 * @returns {boolean}
		 */
		showLocationSettings() {
			return !!getOption('contextual_help')
		},
	},

	methods: {
		/**
		 * Save the playlist visibility settings.
		 *
		 * Vuex will take care of updating the state.
		 *
		 * @since 1.8.0
		 */
		async saveChanges() {
			if (this.playlist.id > 0 && !this.saving) {
				// Set saving flag.
				this.saving = true

				// Update the playlist.
				let result = await updatePlaylist(this.playlist.id, {
					locations: this.locations,
					roles: this.roles,
				})

				if (result.success) {
					// Close the modal.
					this.closeModal()

					// Show success notice.
					this.$root.$emit('showTopNotice', {
						message: this.$i18n.playlists.notices
							.playlist_settings_updated,
					})
				} else {
					// Show error notice.
					this.$root.$emit('showTopNotice', {
						type: 'error',
						message: this.$i18n.playlists.notices
							.playlist_settings_update_failed,
					})
				}

				// Remove saving flag.
				this.saving = false
			}
		},
	},
}
</script>
