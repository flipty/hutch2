import Vue from 'vue'
import Data from './tabs/data'
import Router from 'vue-router'
import Display from './tabs/display'
import Permissions from './tabs/permissions'
import ImportExport from './tabs/import-export'

Vue.use(Router)

export default new Router({
	linkActiveClass: 'current',
	routes: [
		{
			path: '/',
			name: 'Display',
			component: Display,
		},
		{
			path: '/permissions',
			name: 'Permissions',
			component: Permissions,
		},
		{
			path: '/import-export',
			name: 'ImportExport',
			component: ImportExport,
		},
		{
			path: '/data',
			name: 'Data',
			component: Data,
		},
	],
})
