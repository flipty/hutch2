<template>
	<div class="sui-box-settings-row">
		<div class="sui-box-settings-col-1">
			<span class="sui-settings-label">
				{{ $i18n.settings.labels.reset_settings }}
			</span>
			<span class="sui-description">
				{{ $i18n.settings.descriptions.reset_settings }}
			</span>
		</div>
		<div class="sui-box-settings-col-2">
			<!-- Reset button -->
			<button
				@click="$root.$emit('openSettingsResetModal')"
				type="button"
				id="wpmudev-videos-data-reset-confirmation-opener"
				class="sui-button sui-button-ghost"
			>
				<i class="sui-icon-undo" aria-hidden="true"></i>
				{{ $i18n.settings.labels.reset }}
			</button>

			<p class="sui-description">
				{{ $i18n.settings.descriptions.reset_settings_data }}
			</p>
		</div>
	</div>
</template>
