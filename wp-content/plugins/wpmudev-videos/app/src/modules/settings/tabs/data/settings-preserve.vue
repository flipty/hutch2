<template>
	<div class="sui-form-field">
		<h4 class="sui-settings-label">
			{{ $i18n.settings.titles.settings }}
		</h4>
		<span class="sui-description side-tabs-description">
			{{ $i18n.settings.descriptions.data_settings }}
		</span>
		<div class="sui-side-tabs">
			<div class="sui-tabs-menu">
				<sui-tab-radio
					id="wpmudev-videos-settings-keep"
					name="wpmudev-videos-settings-data"
					:option="true"
					:label="$i18n.settings.labels.preserve"
					v-model="settingsClear"
				/>
				<sui-tab-radio
					id="wpmudev-videos-settings-reset"
					name="wpmudev-videos-settings-data"
					:option="false"
					v-model="settingsClear"
					:label="$i18n.settings.labels.reset"
				/>
			</div>
		</div>
	</div>
</template>

<script>
import SuiTabRadio from '@/components/sui/sui-tab-radio'

export default {
	name: 'SettingsPreserve',

	components: { SuiTabRadio },

	computed: {
		/**
		 * Computed model object to manage settings clear settings.
		 *
		 * @since 1.8.1
		 *
		 * @returns {string}
		 */
		settingsClear: {
			get() {
				return this.getOption('keep_settings')
			},
			set(value) {
				this.setOption('keep_settings', value)
			},
		},
	},

	methods: {
		/**
		 * On radio change, update the selected value.
		 *
		 * @param {string} value Current value.
		 *
		 * @since 1.8.1
		 */
		handleChange(value) {
			this.settingsClear = value
		},
	},
}
</script>
