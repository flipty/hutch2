import Vue from 'vue'
import { restGet, restPost, restDelete } from '@/helpers/api'

/**
 * Centralized management of playlists data.
 *
 * We use Vuex keep the playlist in a centralized state so we don't
 * have to call the API always.
 *
 * @since 1.8.0
 */
const playlists = {
	namespaced: true,
	state: {
		playlists: {}, // Full playlist list.
		filtered: [], // For search filter.
	},

	getters: {
		/**
		 * Get a single playlist object.
		 *
		 * If playlist is already available in Vuex, it will
		 * return the video object. If not, an empty object.
		 *
		 * @param {object} state Current state.
		 *
		 * @return {*}
		 */
		playlist: (state) => (id) => {
			if (state.playlists[id]) {
				return state.playlists[id]
			} else {
				return false
			}
		},
	},

	mutations: {
		/**
		 * Update the whole playlist list in state.
		 *
		 * This will replace the current list with new list.
		 * Please make sure you have all the playlists.
		 *
		 * @param {object} state Current state.
		 * @param {object} playlists Playlists data.
		 */
		storePlaylists: (state, playlists) => {
			Vue.set(state, 'playlists', playlists)
		},

		/**
		 * Update the filtered playlist list.
		 *
		 * This will replace the current list with new list.
		 *
		 * @param {object} state Current state.
		 * @param {array} ids Playlist IDs.
		 */
		storeFiltered: (state, ids) => {
			Vue.set(state, 'filtered', ids)
		},

		/**
		 * Update a single playlist data in state.
		 *
		 * If playlist exist, it will replace the playlist object,
		 * if not, it will add the playlist object.
		 *
		 * @param {object} state Current state.
		 * @param {object} playlist Playlist data.
		 */
		storePlaylist: (state, playlist) => {
			if (playlist.id && playlist.id > 0) {
				Vue.set(state.playlists, playlist.id, playlist)
			}
		},

		/**
		 * Delete a single playlist from the state.
		 *
		 * @param {object} state Current state.
		 * @param {integer} id Playlist ID.
		 */
		removePlaylist: (state, id) => {
			if (id > 0) {
				Vue.delete(state.playlists, id)
			}
		},
	},

	actions: {
		/**
		 * Re-initialize the playlist list forcefully.
		 *
		 * We need to call the API and get the playlist,
		 * then update the store state with the new list.
		 *
		 * @param {object} Commit and State.
		 * @param {object} params Additional params for API request.
		 *
		 * @return void
		 */
		init: async ({ commit, state }, params) => {
			await restGet({
				path: 'playlists',
				params: params,
			}).then((response) => {
				if (response.success && response.data) {
					let playlists = {}
					let filtered = []

					// Setup the list data.
					response.data.forEach(function (playlist) {
						playlists[playlist.id] = playlist
						filtered.push(playlist.id)
					})

					// Update the playlist list.
					commit('storePlaylists', playlists)
					// Update the playlist filtered ids.
					commit('storeFiltered', filtered)
				}
			})
		},

		/**
		 * Get playlist list using API.
		 *
		 * We need to call the API and get the playlist,
		 * then update the store state with the new list.
		 * Don't worry about using params, we will add the
		 * results to Vuex.
		 *
		 * @param {object} Commit and State.
		 * @param {object} params Parameter to pass to API.
		 *
		 * @return array
		 */
		getPlaylists: async ({ commit, state }, params) => {
			let result = []

			await restGet({
				path: 'playlists',
				params: params,
			}).then((response) => {
				if (response.success && response.data) {
					let playlists = state.playlists

					// Setup the list data.
					response.data.forEach(function (video) {
						playlists[video.id] = video
					})

					// Update the video list.
					commit('storePlaylists', videos)

					// Get the result.
					result = response.data
				}
			})

			return result
		},

		/**
		 * Get a single playlist object using API.
		 *
		 * Use this only if the playlist is not already
		 * found in state.
		 *
		 * @param {object} Commit and State.
		 * @param {integer} id Video ID.
		 *
		 * @return {object}
		 */
		getPlaylist: async ({ commit, state }, id) => {
			let playlist = {}

			if (id > 0) {
				await restGet({
					path: 'playlists/' + id,
				}).then((response) => {
					if (response.success && response.data) {
						// Update the playlist data.
						commit('storePlaylist', response.data)

						// Get the video.
						playlist = response.data
					}
				})
			}

			return playlist
		},

		/**
		 * Create a playlist object using API.
		 *
		 * Use this so we will take care the updating of
		 * playlist object in Vuex state. Almost identical to
		 * update action, but here we don't check for id.
		 *
		 * @param {object} Commit and State.
		 * @param {object} playlist Playlist data.
		 *
		 * @return {object}
		 */
		createPlaylist: async ({ commit, state }, playlist) => {
			let result = {
				success: false,
				playlist: {},
				data: {},
			}

			await restPost({
				path: 'playlists',
				data: playlist,
			}).then((response) => {
				if (response.success && response.data) {
					// Update the playlist data.
					commit('storePlaylist', response.data)
					// Add new playlist to top.
					let filtered = state.filtered.concat([response.data.id])
					// Update the playlist filtered ids.
					commit('storeFiltered', filtered)

					// Update result.
					result.success = true
					result.playlist = response.data
				} else if (response.data) {
					result.data = response.data
				}
			})

			return result
		},

		/**
		 * Update a single playlist object using API.
		 *
		 * Use this so we will take care the updating of
		 * playlist object in Vuex state.
		 *
		 * @param {object} Commit and State.
		 * @param {object} data Playlist data.
		 *
		 * @return {object}
		 */
		updatePlaylist: async ({ commit, state }, data) => {
			let result = {
				success: false,
				playlist: {},
				data: {},
			}

			if (data.id && data.id > 0 && data.playlist) {
				await restPost({
					path: 'playlists/' + data.id,
					data: data.playlist,
				}).then((response) => {
					if (response.success && response.data) {
						// Update the playlist data.
						commit('storePlaylist', response.data)

						// Update result.
						result.success = true
						result.playlist = response.data
					} else if (response.data) {
						result.data = response.data
					}
				})
			}

			return result
		},

		/**
		 * Delete a single playlist object using API.
		 *
		 * Use this so we will take care removing the
		 * playlist object from Vuex state.
		 *
		 * @param {object} Commit and State.
		 * @param {integer} id Playlist ID.
		 *
		 * @return {object}
		 */
		deletePlaylist: async ({ commit, state }, id) => {
			let result = {
				success: false,
				message: '',
			}

			if (id > 0) {
				await restDelete({
					path: 'playlists/' + id,
				}).then((response) => {
					if (response.success) {
						// Delete the playlist data.
						commit('removePlaylist', id)

						// Remove item from filtered list.
						let filtered = state.filtered.filter(function (
							playlistId
						) {
							return id !== playlistId
						})

						// Update the playlist filtered ids.
						commit('storeFiltered', filtered)

						// Update result.
						result.success = true
						result.message = response.data.message
					} else {
						// Update failed result.
						result.success = false
						result.message = response.message
					}
				})
			}

			return result
		},

		/**
		 * Set a playlist value in state.
		 *
		 * @param {object} Commit and State.
		 * @param {object} playlist Playlist data.
		 *
		 * @return void
		 */
		setPlaylist: ({ commit, state }, playlist) => {
			if (playlist.id && playlist.id > 0) {
				// Update the playlist data.
				commit('storePlaylist', playlist)
			}
		},

		/**
		 * Unset a playlist object in state.
		 *
		 * @param {object} Commit and State.
		 * @param {object} id Playlist ID.
		 *
		 * @return void
		 */
		unsetPlaylist: ({ commit, state }, id) => {
			if (id > 0) {
				// Delete the playlist data.
				commit('removePlaylist', id)
			}
		},

		/**
		 * Set a filtered playlist ids in state.
		 *
		 * @param {object} Commit and State.
		 * @param {array} ids Playlist IDs.
		 *
		 * @return {Promise<void>}
		 */
		setFiltered: ({ commit, state }, ids) => {
			// Update the playlist ids data.
			commit('storeFiltered', ids)
		},
	},
}

export default playlists
