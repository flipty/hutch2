<template>
	<div class="sui-box-settings-row sui-flushed">
		<div class="sui-box-settings-col-1">
			<span class="sui-settings-label">
				{{ $i18n.settings.labels.help_videos }}
			</span>
			<span class="sui-description">
				{{ $i18n.settings.descriptions.help_videos }}
			</span>
		</div>
		<div class="sui-box-settings-col-2">
			<div class="sui-form-field">
				<label
					for="wpmudev-videos-settings-help-videos"
					class="sui-toggle"
				>
					<input
						v-model="contextualHelp"
						type="checkbox"
						value="1"
						id="wpmudev-videos-settings-help-videos"
					/>
					<span class="sui-toggle-slider"></span>
				</label>
				<label
					for="wpmudev-videos-settings-help-videos"
					class="sui-toggle-label"
				>
					{{ $i18n.settings.labels.contextual_help }}
				</label>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'ContextualHelp',

	computed: {
		/**
		 * Contexual help option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		contextualHelp: {
			get() {
				return this.getOption('contextual_help')
			},
			set(value) {
				this.setOption('contextual_help', value)
			},
		},
	},
}
</script>
