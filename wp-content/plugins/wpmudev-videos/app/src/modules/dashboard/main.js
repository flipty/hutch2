import Vue from 'vue'
import App from './app'
import store from '@/store/store'
import Fragment from 'vue-fragment'
import { sprintf } from 'sprintf-js'
import {
	getOption,
	dashActive,
	validMember,
	expiredMember,
	dashInstalled,
	dashConnected,
} from '@/helpers/utils'

Vue.config.productionTip = false

// Global functions.
Vue.mixin({
	methods: {
		sprintf,
		getOption,
		dashActive,
		validMember,
		expiredMember,
		dashInstalled,
		dashConnected,
	},
})

// Global vars.
Vue.prototype.$i18n = window.ivtI18n
Vue.prototype.$vars = window.ivtVars
Vue.prototype.$moduleVars = window.ivtModuleVars

Vue.use(Fragment.Plugin)

new Vue({
	render: (h) => h(App),
	store,
}).$mount('#wpmudev-videos-dashboard-app')
