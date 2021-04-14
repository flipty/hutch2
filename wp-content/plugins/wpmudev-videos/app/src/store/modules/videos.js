import Vue from 'vue'
import { restGet, restPost, restDelete } from '@/helpers/api'

/**
 * Centralized management of videos data.
 *
 * We use Vuex keep the video in a centralized state so we don't
 * have to call the API always.
 *
 * @since 1.8.0
 */
const videos = {
	namespaced: true,
	state: {
		videos: {}, // Full list of videos.
		embeds: {}, // Video embeds.
		filtered: [], // For search filter.
	},

	getters: {
		/**
		 * Get a single video object.
		 *
		 * If video is already available in Vuex, it will
		 * return the video object. If not, an empty object.
		 *
		 * @param {object} state Current state.
		 *
		 * @return {*}
		 */
		video: (state) => (id) => {
			if (state.videos[id]) {
				return state.videos[id]
			} else {
				return false
			}
		},

		/**
		 * Get a single video embed.
		 *
		 * If embed is already available in Vuex, it will
		 * return the embed object. If not, an empty object.
		 *
		 * @param {object} state Current state.
		 *
		 * @return {*}
		 */
		embed: (state) => (id) => {
			if (state.embeds[id]) {
				return state.embeds[id]
			} else {
				return false
			}
		},
	},

	mutations: {
		/**
		 * Update the whole video list in state.
		 *
		 * This will replace the current list with new list.
		 * Please make sure you have all videos.
		 *
		 * @param {object} state Current state.
		 * @param {object} videos Videos data.
		 */
		storeVideos: (state, videos) => {
			Vue.set(state, 'videos', videos)
		},

		/**
		 * Update the filtered videos list.
		 *
		 * This will replace the current list with new list.
		 *
		 * @param {object} state Current state.
		 * @param {array} ids Video IDs.
		 */
		storeFiltered: (state, ids) => {
			Vue.set(state, 'filtered', ids)
		},

		/**
		 * Update a single video data in state.
		 *
		 * If video exist, it will replace the video object,
		 * if not, it will add the video object.
		 *
		 * @param {object} state Current state.
		 * @param {object} video Video data.
		 */
		storeVideo: (state, video) => {
			if (video.id && video.id > 0) {
				Vue.set(state.videos, video.id, video)
			}
		},

		/**
		 * Add new item to the filered list.
		 *
		 * Useful after creating a video.
		 *
		 * @param {object} state Current state.
		 * @param {array} id Video ID.
		 */
		storeFilteredVideo: (state, id) => {
			state.filtered.push(id)
		},

		/**
		 * Update a single embed data in state.
		 *
		 * If embed exist, it will replace the embed object,
		 * if not, it will add the embed object.
		 *
		 * @param {object} state Current state.
		 * @param {object} embed Embed data.
		 */
		storeEmbed: (state, embed) => {
			if (embed.id && embed.id > 0) {
				Vue.set(state.embeds, embed.id, embed)
			}
		},

		/**
		 * Delete a single video from the state.
		 *
		 * @param {object} state Current state.
		 * @param {integer} id Video ID.
		 */
		removeVideo: (state, id) => {
			if (id > 0) {
				Vue.delete(state.videos, id)
			}
		},

		/**
		 * Delete a single video iframe from the state.
		 *
		 * @param {object} state Current state.
		 * @param {integer} id Video ID.
		 */
		removeEmbed: (state, id) => {
			if (id > 0) {
				Vue.delete(state.embeds, id)
			}
		},
	},

	actions: {
		/**
		 * Re-initialize the videos list forcefully.
		 *
		 * This gets the complete list of videos.
		 * We need to call the API and get the videos,
		 * then update the store state with the new list.
		 *
		 * @param {object} Commit and State.
		 * @param {object} params Additional params for API request.
		 *
		 * @return void
		 */
		init: async ({ commit, state }, params) => {
			await restGet({
				path: 'videos',
				params: params,
			}).then((response) => {
				if (response.success && response.data) {
					let videos = {}
					let filtered = []

					// Setup the list data.
					response.data.forEach(function (video) {
						videos[video.id] = video
						filtered.push(video.id)
					})

					// Update the video list.
					commit('storeVideos', videos)
					// Update the video filtered ids.
					commit('storeFiltered', filtered)
				}
			})
		},

		/**
		 * Get video list using API.
		 *
		 * We need to call the API and get the videos,
		 * then update the store state with the new list.
		 * Don't worry about using params, we will add the
		 * results to Vuex.
		 *
		 * @param {object} Commit and State.
		 * @param {object} params Parameter to pass to API.
		 *
		 * @return array
		 */
		getVideos: async ({ commit, state }, params) => {
			let result = []

			await restGet({
				path: 'videos',
				params: params,
			}).then((response) => {
				if (response.success && response.data) {
					let videos = state.videos

					// Setup the list data.
					response.data.forEach(function (video) {
						videos[video.id] = video
					})

					// Update the video list.
					commit('storeVideos', videos)

					// Get the result.
					result = response.data
				}
			})

			return result
		},

		/**
		 * Get a single video object using API.
		 *
		 * Use this only if the video is not already
		 * found in state.
		 *
		 * @param {object} Commit and State.
		 * @param {integer} id Video ID.
		 *
		 * @return {Promise<void>}
		 */
		getVideo: async ({ commit, state }, id) => {
			let video = {}

			if (id > 0) {
				await restGet({
					path: 'videos/' + id,
				}).then((response) => {
					if (response.success && response.data) {
						// Update the video data.
						commit('storeVideo', response.data)

						// Get the video.
						video = response.data
					}
				})
			}

			return video
		},

		/**
		 * Create a video object using API.
		 *
		 * Use this so we will take care the updating of
		 * video object in Vuex state. Almost identical to
		 * update action, but here we don't check for id.
		 *
		 * @param {object} Commit and State.
		 * @param {object} video Video data.
		 *
		 * @return {object}
		 */
		createVideo: async ({ commit, state }, video) => {
			let result = {
				success: false,
				video: {},
			}

			await restPost({
				path: 'videos',
				data: video,
			}).then((response) => {
				if (response.success && response.data) {
					// Update the video data.
					commit('storeVideo', response.data)

					// Store to filtered list.
					commit('storeFilteredVideo', response.data.id)

					// Update result.
					result.success = true
					result.video = response.data
				}
			})

			return result
		},

		/**
		 * Update a single video object using API.
		 *
		 * Use this so we will take care the updating of
		 * video object in Vuex state.
		 *
		 * @param {object} Commit and State.
		 * @param {object} data Video data.
		 *
		 * @return {object}
		 */
		updateVideo: async ({ commit, state }, data) => {
			let result = {
				success: false,
				video: {},
			}

			if (data.video && data.id && data.id > 0) {
				await restPost({
					path: 'videos/' + data.id,
					data: data.video,
				}).then((response) => {
					if (response.success && response.data) {
						// Update the video data.
						commit('storeVideo', response.data)

						// Update result.
						result.success = true
						result.video = response.data
					}
				})
			}

			return result
		},

		/**
		 * Delete a single video object using API.
		 *
		 * Use this so we will take care removing the
		 * video object from Vuex state.
		 *
		 * @param {object} Commit and State.
		 * @param {integer} id Video ID.
		 *
		 * @return {object}
		 */
		deleteVideo: async ({ commit, state }, id) => {
			let result = {
				success: false,
				message: '',
			}

			if (id > 0) {
				await restDelete({
					path: 'videos/' + id,
				}).then((response) => {
					if (response.success) {
						// Delete the video data.
						commit('removeVideo', id)

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
		 * Set a video value in state.
		 *
		 * @param {object} Commit and State.
		 * @param {object} video Video data.
		 *
		 * @return {Promise<void>}
		 */
		setVideo: ({ commit, state }, video) => {
			if (video.id && video.id > 0) {
				// Update the video data.
				commit('storeVideo', video)
			}
		},

		/**
		 * Get a single embed object using API.
		 *
		 * Use this only if the embed is not already
		 * found in state.
		 *
		 * @param {object} Commit and State.
		 * @param {object} data Video ID and other args.
		 *
		 * @return {Promise<void>}
		 */
		getEmbed: async ({ commit, state }, data) => {
			let embed = {}

			if (data.id && data.id > 0) {
				data.width = 1000
				await restGet({
					path: 'videos/' + data.id + '/embed',
					params: data,
				}).then((response) => {
					if (
						response.success &&
						response.data &&
						response.data.html
					) {
						// Get the video.
						embed = response.data

						// Add id.
						response.data.id = data.id

						// Update the embed data.
						commit('storeEmbed', response.data)
					}
				})
			}

			return embed
		},

		/**
		 * Set a embed value in state.
		 *
		 * @param {object} Commit and State.
		 * @param {object} data Embed data.
		 *
		 * @return {Promise<void>}
		 */
		setEmbed: ({ commit, state }, data) => {
			if (data.id && data.id > 0) {
				// Update the embed data.
				commit('storeEmbed', data.embed)
			}
		},

		/**
		 * Remove a video embed from state.
		 *
		 * @param {object} Commit and State.
		 * @param {object} video Video ID.
		 *
		 * @return {Promise<void>}
		 */
		unsetEmbed: ({ commit, state }, id) => {
			if (id > 0) {
				// Remove from state.
				commit('removeEmbed', id)
			}
		},

		/**
		 * Set a filtered video ids in state.
		 *
		 * @param {object} Commit and State.
		 * @param {array} ids Video IDs.
		 *
		 * @return {Promise<void>}
		 */
		setFiltered: ({ commit, state }, ids) => {
			// Update the video ids data.
			commit('storeFiltered', ids)
		},
	},
}

export default videos
