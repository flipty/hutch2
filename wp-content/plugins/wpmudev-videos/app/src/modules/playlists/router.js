import Vue from 'vue'
import Router from 'vue-router'
import Playlists from './views/playlists'

Vue.use(Router)

export default new Router({
	linkActiveClass: 'current',
	routes: [
		{
			path: '/:action?/:playlist?',
			name: 'Playlists',
			component: Playlists,
			props: true,
		},
	],
})
