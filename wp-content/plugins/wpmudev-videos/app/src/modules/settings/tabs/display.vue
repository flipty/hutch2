<template>
	<div class="sui-box">
		<div class="sui-box-header">
			<h3 class="sui-box-title">
				{{ $i18n.settings.titles.display_settings }}
			</h3>
		</div>
		<div class="sui-box-body">
			<!-- Tutorials tab -->
			<show-menu />
			<!-- Help videos -->
			<contextual-help />
		</div>
		<box-footer :reload="shouldReload" />
	</div>
</template>

<script>
import ShowMenu from './display/show-menu'
import BoxFooter from '../components/box-footer'
import ShowMenuSub from './display/show-menu-sub'
import ContextualHelp from './display/contextual-help'

export default {
	name: 'Display',

	components: {
		ShowMenu,
		BoxFooter,
		ShowMenuSub,
		ContextualHelp,
	},

	data() {
		return {
			// Get initial values.
			showInitial: this.getOption('show_menu'),
			menuInitial: this.getOption('menu_location'),
		}
	},

	computed: {
		/**
		 * If menu option is changed, we need to reload.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		shouldReload() {
			let show = this.getOption('show_menu')
			let location = this.getOption('menu_location')

			return this.menuInitial !== location || this.showInitial !== show
		},
	},
}
</script>
