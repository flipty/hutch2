import Vue from 'vue'
import App from './app'
import router from './router'
import store from '@/store/store'
import Fragment from 'vue-fragment'
import { sprintf } from 'sprintf-js'
import { validMember, expiredMember, dashInstalled } from '@/helpers/utils'

Vue.config.productionTip = false

// Global functions.
Vue.mixin({
	methods: {
		sprintf,
		validMember,
		expiredMember,
		dashInstalled,
	},
})

// Global vars.
Vue.prototype.$i18n = window.ivtI18n
Vue.prototype.$vars = window.ivtVars
Vue.prototype.$moduleVars = window.ivtModuleVars

Vue.use(Fragment.Plugin)

new Vue({
	router,
	render: (h) => h(App),
	store,
}).$mount('#wpmudev-videos-tutorials-app')
