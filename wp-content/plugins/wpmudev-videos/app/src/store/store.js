import Vue from 'vue'
import Vuex from 'vuex'
import videos from './modules/videos'
import settings from './modules/settings'
import playlists from './modules/playlists'

Vue.use(Vuex)

export default new Vuex.Store({
	namespaced: true,
	modules: {
		videos: videos,
		settings: settings,
		playlists: playlists,
	},
})
