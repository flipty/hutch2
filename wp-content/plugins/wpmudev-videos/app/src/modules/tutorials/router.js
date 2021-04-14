import Vue from 'vue'
import Router from 'vue-router'
import VideosList from './views/videos-list'

Vue.use(Router)

export default new Router({
	linkActiveClass: 'current',
	routes: [
		{
			path: '/:action?/:playlist?/:video?',
			name: 'VideosList',
			component: VideosList,
			props: true,
		},
	],
})
