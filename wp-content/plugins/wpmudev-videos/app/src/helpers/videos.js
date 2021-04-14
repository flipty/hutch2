/**
 * Videos helper functions.
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
 * Get a video object.
 *
 * If you pass second param as true, then we will try
 * to get the video from API if not found in state.
 *
 * @param {integer} id Video ID.
 * @param {boolean} checkApi Should check API if not found.
 *
 * @since 1.8.0
 *
 * @return {object}
 */
export async function getVideo(id, checkApi = false) {
	let video = store.getters['videos/video'](id)

	// Only if set.
	if (!video && checkApi) {
		video = await store.dispatch('videos/getVideo', id)
	} else if (!video) {
		video = {}
	}

	return video
}

/**
 * Get the list of videos.
 *
 * Please note, we will be calling the API directly
 * and store the individual videos from the result to
 * the Vuex.
 *
 * @param {object} params Params for API.
 *
 * @since 1.8.0
 *
 * @return {array}
 */
export async function getVideos(params = {}) {
	// Get the list.
	return await store.dispatch('videos/getVideos', params)
}

/**
 * Create a video using API.
 *
 * This is a async function, so make sure to use `await` when you
 * call it. So that the function will wait for he response.
 *
 * @param {object} video Video object.
 *
 * @since 1.8.0
 *
 * @return {object}
 */
export async function createVideo(video) {
	return await store.dispatch('videos/createVideo', video)
}

/**
 * Update a single video using API.
 *
 * This is a async function, so make sure to use `await` when you
 * call it. So that the function will wait for he response.
 *
 * @param {integer} id Video ID.
 * @param {object} video Video object.
 *
 * @since 1.8.0
 *
 * @return {object}
 */
export async function updateVideo(id, video) {
	return await store.dispatch('videos/updateVideo', {
		id: id,
		video: video,
	})
}

/**
 * Delete a video using API.
 *
 * This is a async function, so make sure to use `await` when you
 * call it. So that the function will wait for he response.
 *
 * @param {integer} id Video ID.
 *
 * @since 1.8.0
 *
 * @return {object}
 */
export async function deleteVideo(id) {
	return await store.dispatch('videos/deleteVideo', id)
}

/**
 * Get a video embed object.
 *
 * If you pass second param as true, then we will try
 * to get the embed from API if not found in state.
 *
 * @param {integer} id Video ID.
 * @param {object}  data Extra args.
 * @param {boolean} checkApi Should check API if not found.
 *
 * @since 1.8.0
 *
 * @return {object}
 */
export async function getEmbed(id, data = {}, checkApi = true) {
	let embed = store.getters['videos/embed'](id)

	// Only if set.
	if (!embed && checkApi) {
		data.id = id

		embed = await store.dispatch('videos/getEmbed', data)
	} else if (!embed) {
		embed = {}
	}

	return embed
}
