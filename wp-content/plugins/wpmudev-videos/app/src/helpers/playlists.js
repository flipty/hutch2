/**
 * Playlists helper functions.
 *
 * @since 1.8.0
 * @author Joel James <joel@incsub.com>
 *
 * Beehive, Copyright 2007-2019 Incsub (http://incsub.com).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

import store from '@/store/store'

/**
 * Get a playlist object.
 *
 * If you pass second param as true, then we will try
 * to get the playlist from API if not found in state.
 *
 * @param {integer} id Video ID.
 * @param {boolean} checkApi Should check API if not found.
 *
 * @since 1.8.0
 *
 * @return {object}
 */
export async function getPlaylist(id, checkApi = false) {
	let playlist = store.getters['playlists/playlist'](id)

	// Only if set.
	if (!playlist && checkApi) {
		playlist = await store.dispatch('playlists/getPlaylist', id)
	} else if (!playlist) {
		playlist = {}
	}

	return playlist
}

/**
 * Get the list of playlist.
 *
 * Please note, we will be calling the API directly
 * and store the individual playlist from the result to
 * the Vuex.
 *
 * @param {object} params Params for API.
 *
 * @since 1.8.0
 *
 * @return {array}
 */
export async function getPlaylists(params = {}) {
	// Get the list.
	return await store.dispatch('playlists/getPlaylists', params)
}

/**
 * Create a playlist using API.
 *
 * This is a async function, so make sure to use `await` when you
 * call it. So that the function will wait for he response.
 *
 * @param {object} playlist Playlist object.
 *
 * @since 1.8.0
 *
 * @return {object}
 */
export async function createPlaylist(playlist) {
	return await store.dispatch('playlists/createPlaylist', playlist)
}

/**
 * Update a single playlist using API.
 *
 * This is a async function, so make sure to use `await` when you
 * call it. So that the function will wait for he response.
 *
 * @param {integer} id Playlist ID.
 * @param {object} playlist Playlist object.
 *
 * @since 1.8.0
 *
 * @return {object}
 */
export async function updatePlaylist(id, playlist) {
	return await store.dispatch('playlists/updatePlaylist', {
		id: id,
		playlist: playlist,
	})
}

/**
 * Delete a playlist using API.
 *
 * This is a async function, so make sure to use `await` when you
 * call it. So that the function will wait for he response.
 *
 * @param {integer} id Playlist ID.
 *
 * @since 1.8.0
 *
 * @return {object}
 */
export async function deletePlaylist(id) {
	return await store.dispatch('playlists/deletePlaylist', id)
}
