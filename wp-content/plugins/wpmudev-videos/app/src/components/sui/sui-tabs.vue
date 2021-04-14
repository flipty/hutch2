<template>
	<div
		class="sui-tabs sui-tabs-overflow"
		:class="[
			flushed && true === flushed ? 'sui-tabs-flushed' : '',
			overflow && true === overflow ? 'sui-tabs-overflow' : '',
			customClass && '' !== customClass ? customClass : '',
		]"
		ref="suiTabs"
	>
		<div
			tabindex="-1"
			class="sui-tabs-navigation"
			aria-hidden="true"
			v-if="true === overflow"
		>
			<button
				type="button"
				class="sui-button-icon sui-tabs-navigation--left"
			>
				<sui-icon icon="chevron-left" />
			</button>

			<button
				type="button"
				class="sui-button-icon sui-tabs-navigation--right"
			>
				<sui-icon icon="chevron-right" />
			</button>
		</div>

		<div role="tablist" class="sui-tabs-menu" v-if="content">
			<button
				type="button"
				role="tab"
				:id="'tab--' + tab.id"
				class="sui-tab-item"
				:class="0 === key ? 'active' : ''"
				:aria-controls="'tab-content--' + tab.id"
				:aria-selected="0 === key ? true : false"
				:tabindex="0 === key ? '' : '-1'"
				v-for="(tab, key) in options"
				:key="key"
			>
				{{ label }}
			</button>
		</div>

		<div role="tablist" class="sui-tabs-menu" v-else>
			<button
				type="button"
				role="tab"
				:id="'tab--' + tab.id"
				class="sui-tab-item"
				:class="0 === key ? 'active' : ''"
				:aria-selected="0 === key ? true : false"
				:tabindex="0 === key ? '' : '-1'"
				v-for="(tab, key) in options"
				:key="key"
			>
				{{ tab.label }}
			</button>
		</div>

		<div class="sui-tabs-content" v-if="content">
			<slot name="tab-content"></slot>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'SuiTabs',

	components: { SuiIcon },

	props: {
		title: {
			type: String,
		},
		flushed: {
			type: Boolean,
			default: false,
		},
		overflow: {
			type: Boolean,
			default: false,
		},
		customClass: {
			type: String,
		},
		options: {},
		content: {
			type: Boolean,
			default: false,
		},
	},

	mounted() {
		const tabNav = jQuery(this.$refs.suiTabs).find('.sui-tabs-navigation')

		SUI.tabs()
		SUI.tabsOverflow(tabNav)
	},
}
</script>
