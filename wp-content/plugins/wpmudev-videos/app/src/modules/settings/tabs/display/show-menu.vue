<template>
	<div class="sui-box-settings-row sui-flushed">
		<div class="sui-box-settings-col-1">
			<span class="sui-settings-label">
				{{ $i18n.settings.labels.tutorials_tab }}
			</span>
			<span class="sui-description">
				{{ $i18n.settings.descriptions.tutorials_tab }}
			</span>
		</div>
		<div class="sui-box-settings-col-2">
			<div class="sui-form-field">
				<label
					for="wpmudev-videos-settings-tutorials-tab"
					class="sui-toggle"
				>
					<input
						v-model="showMenu"
						type="checkbox"
						id="wpmudev-videos-settings-tutorials-tab"
					/>
					<span class="sui-toggle-slider"></span>
				</label>
				<label
					for="wpmudev-videos-settings-tutorials-tab"
					class="sui-toggle-label"
				>
					{{ $i18n.settings.descriptions.wp_sidebar }}
				</label>
			</div>
			<!-- Sub items -->
			<show-menu-sub v-if="showMenu" />
		</div>
	</div>
</template>

<script>
import ShowMenuSub from './show-menu-sub'

export default {
	name: 'ShowMenu',

	components: { ShowMenuSub },

	computed: {
		/**
		 * Show menu option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		showMenu: {
			get() {
				return this.getOption('show_menu')
			},
			set(value) {
				this.setOption('show_menu', value)
			},
		},
	},
}
</script>
