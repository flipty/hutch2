<template>
	<div class="sui-border-frame">
		<div class="sui-form-field">
			<label
				for="wpmudev-videos-settings-tutorials-position"
				id="wpmudev-videos-settings-tutorials-position-label"
				class="sui-label"
			>
				{{ $i18n.settings.labels.location }}
			</label>
			<sui-select
				v-model="menuLocation"
				:options="menuLocations"
				id="wpmudev-videos-settings-tutorials-position"
				aria-labelledby="wpmudev-videos-settings-tutorials-position-label"
			/>
		</div>
		<div class="sui-form-field">
			<label
				for="wpmudev-videos-settings-tutorials-title"
				id="wpmudev-videos-settings-tutorials-title-label"
				class="sui-label"
			>
				{{ $i18n.settings.descriptions.wp_sidebar }}
			</label>
			<input
				v-model="menuTitle"
				:placeholder="$i18n.settings.labels.tutorials"
				id="wpmudev-videos-settings-tutorials-title"
				class="sui-form-control"
				aria-labelledby="wpmudev-videos-settings-tutorials-title-label"
			/>
		</div>
	</div>
</template>

<script>
import SuiSelect from '@/components/sui/sui-select'

export default {
	name: 'ShowMenuSub',

	components: { SuiSelect },

	computed: {
		/**
		 * Get menu locations from backend.
		 *
		 * @since 1.8.0
		 *
		 * @returns {array}
		 */
		menuLocations() {
			if (this.$moduleVars.menu_locations) {
				return this.$moduleVars.menu_locations
			} else {
				return []
			}
		},

		/**
		 * Menu title option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		menuTitle: {
			get() {
				return this.getOption(
					'menu_title',
					this.$i18n.settings.labels.tutorials
				)
			},
			set(value) {
				this.setOption('menu_title', value)
			},
		},

		/**
		 * Menu location option model.11
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		menuLocation: {
			get() {
				return this.getOption('menu_location', 'none')
			},
			set(value) {
				this.setOption('menu_location', value)
			},
		},
	},
}
</script>
