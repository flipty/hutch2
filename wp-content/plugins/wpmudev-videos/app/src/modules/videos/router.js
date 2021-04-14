import Vue from 'vue'
import Router from 'vue-router'
import VideosBox from './views/videos-box'

Vue.use(Router)

export default new Router({
	linkActiveClass: 'current',
	routes: [
		{
			path: '/:action?/:video?',
			name: 'VideosBox',
			component: VideosBox,
			props: true,
		},
	],
})
