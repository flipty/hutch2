<template>
	<div class="sui-wrap">
		<sui-header :title="$i18n.settings.titles.settings" />

		<div class="sui-row-with-sidenav" v-cloak>
			<div class="sui-sidenav">
				<ul class="sui-vertical-tabs sui-sidenav-hide-md">
					<router-link class="sui-vertical-tab" tag="li" to="/" exact>
						<a>{{ $i18n.settings.titles.display_settings }}</a>
					</router-link>
					<router-link
						class="sui-vertical-tab"
						tag="li"
						to="/permissions"
					>
						<a>{{ $i18n.settings.titles.permissions }}</a>
					</router-link>
					<router-link
						class="sui-vertical-tab"
						tag="li"
						to="/import-export"
					>
						<a>{{ $i18n.settings.titles.import_export }}</a>
					</router-link>
					<router-link class="sui-vertical-tab" tag="li" to="/data">
						<a>{{ $i18n.settings.titles.data }}</a>
					</router-link>
				</ul>

				<mobile-nav :selected="$route.path" :paths="nav" />
			</div>

			<router-view />
		</div>

		<!-- Import confirmation modal -->
		<import-confirmation />

		<!-- Import progress modal -->
		<import-progress />

		<!-- Import progress modal -->
		<delete-confirmation />

		<sui-footer />
	</div>
</template>

<script>
import SuiHeader from '@/components/sui/sui-header'
import SuiFooter from '@/components/sui/sui-footer'
import SuiSelect from '@/components/sui/sui-select'
import MobileNav from '@/components/elements/mobile-nav'
import DeleteConfirmation from './tabs/data/modals/delete-confirmation'
import ImportProgress from './tabs/import-export/modals/import-progress'
import ImportConfirmation from './tabs/import-export/modals/import-confirmation'

export default {
	name: 'App',

	components: {
		SuiHeader,
		SuiFooter,
		SuiSelect,
		MobileNav,
		ImportProgress,
		ImportConfirmation,
		DeleteConfirmation,
	},

	data() {
		return {
			nav: {
				'/': this.$i18n.settings.titles.display_settings,
				'/permissions': this.$i18n.settings.titles.permissions,
				'/import-export': this.$i18n.settings.titles.import_export,
				'/data': this.$i18n.settings.titles.data,
			},
		}
	},
}
</script>

<style lang="scss">
@import 'styles/main';
</style>
