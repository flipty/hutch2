<template>
	<div id="beehive-widget-body" class="sui-tabs sui-tabs-overflow">
		<div tabindex="-1" class="sui-tabs-navigation" aria-hidden="true">
			<button
				type="button"
				class="sui-button-icon sui-tabs-navigation--left"
			>
				<i class="sui-icon-chevron-left"></i>
			</button>
			<button
				type="button"
				class="sui-button-icon sui-tabs-navigation--right"
			>
				<i class="sui-icon-chevron-right"></i>
			</button>
		</div>

		<div role="tablist" class="sui-tabs-menu">
			<button
				v-if="canView('general')"
				type="button"
				role="tab"
				id="beehive-widget-tab--general_stats"
				class="sui-tab-item"
				aria-controls="beehive-widget-content--general_stats"
				:tabindex="'general' === defaultTab ? false : '-1'"
				:aria-selected="'general' === defaultTab ? 'true' : 'false'"
				:class="{ active: 'general' === defaultTab }"
			>
				{{ $i18n.label.general_stats }}
			</button>

			<button
				v-if="canView('audience')"
				type="button"
				role="tab"
				id="beehive-widget-tab--audience"
				class="sui-tab-item"
				aria-controls="beehive-widget-content--audience"
				:tabindex="'audience' === defaultTab ? false : '-1'"
				:aria-selected="'audience' === defaultTab ? 'true' : 'false'"
				:class="{ active: 'audience' === defaultTab }"
			>
				{{ $i18n.label.audience }}
			</button>

			<button
				v-if="canView('pages')"
				type="button"
				role="tab"
				id="beehive-widget-tab--top_pages"
				class="sui-tab-item"
				aria-controls="beehive-widget-content--top_pages"
				:tabindex="'pages' === defaultTab ? false : '-1'"
				:aria-selected="'pages' === defaultTab ? 'true' : 'false'"
				:class="{ active: 'pages' === defaultTab }"
			>
				{{ $i18n.label.top_pages }}
			</button>

			<button
				v-if="canView('traffic')"
				type="button"
				role="tab"
				id="beehive-widget-tab--traffic"
				class="sui-tab-item"
				aria-controls="beehive-widget-content--traffic"
				:tabindex="'traffic' === defaultTab ? false : '-1'"
				:aria-selected="'traffic' === defaultTab ? 'true' : 'false'"
				:class="{ active: 'traffic' === defaultTab }"
			>
				{{ $i18n.label.traffic }}
			</button>
		</div>

		<div class="sui-tabs-content">
			<general-stats
				v-if="canView('general')"
				:stats="stats"
				@tabChange="tabChange"
			/>

			<audience
				v-if="canView('audience')"
				:stats="stats"
				:selected-item="audienceDefault"
				:active-tab="defaultTab"
			/>

			<pages
				v-if="canView('pages')"
				:stats="stats"
				:active-tab="defaultTab"
			/>

			<traffic
				v-if="canView('traffic')"
				:stats="stats"
				:active-tab="defaultTab"
			/>
		</div>
	</div>
</template>

<script>
import Pages from './tabs/pages'
import Traffic from './tabs/traffic'
import Audience from './tabs/audience'
import { canViewStats } from '@/helpers/utils'
import GeneralStats from './tabs/general-stats'

export default {
	name: 'WidgetBody',

	props: ['stats'],

	components: {
		GeneralStats,
		Audience,
		Pages,
		Traffic,
	},

	data() {
		return {
			audienceDefault: 'sessions',
		}
	},

	mounted() {
		const body = jQuery('#beehive-widget-body')
		const navigation = body.find('.sui-tabs-navigation')

		// Initialize tabs.
		SUI.tabs()

		// Initialize overflow tabs.
		navigation.each(function () {
			SUI.tabsOverflow(jQuery(this))
		})
	},

	computed: {
		defaultTab() {
			if (this.canView('general')) {
				return 'general'
			} else if (this.canView('audience')) {
				return 'audience'
			} else if (this.canView('pages')) {
				return 'pages'
			} else {
				return 'traffic'
			}
		},
	},

	methods: {
		/**
		 * Check if current user can view.
		 *
		 * @param {string} type Stats type.
		 *
		 * @since 3.3.6
		 *
		 * @return {string|boolean}
		 */
		canView(type) {
			return canViewStats(type, 'dashboard')
		},

		/**
		 * Process tab change.
		 *
		 * @param {string} tab New tab
		 *
		 * @since 3.3.6
		 */
		tabChange(tab) {
			this.audienceDefault = tab
		},
	},
}
</script>
