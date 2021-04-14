<template>
	<div class="sui-form-field">
		<h4 class="sui-settings-label">
			{{ $i18n.settings.labels.data }}
		</h4>
		<span class="sui-description side-tabs-description">
			{{ $i18n.settings.descriptions.data_data }}
		</span>
		<div class="sui-side-tabs">
			<div class="sui-tabs-menu">
				<sui-tab-radio
					id="wpmudev-videos-data-keep"
					:option="true"
					:label="$i18n.settings.labels.keep"
					v-model="dataClear"
					@change="dataChange"
				/>
				<sui-tab-radio
					id="wpmudev-videos-data-remove"
					:option="false"
					:label="$i18n.settings.labels.remove"
					v-model="dataClear"
					@change="dataChange"
				/>
			</div>
		</div>
	</div>
</template>

<script>
import SuiTabRadio from '@/components/sui/sui-tab-radio'

export default {
	name: 'DataPreserve',

	components: { SuiTabRadio },

	computed: {
		/**
		 * Computed model object to manage data clear settings.
		 *
		 * @since 1.8.1
		 *
		 * @returns {string}
		 */
		dataClear: {
			get() {
				return this.getOption('keep_data')
			},
			set(value) {
				this.setOption('keep_data', value)
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
		dataChange(value) {
			this.dataClear = value
		},
	},
}
</script>
