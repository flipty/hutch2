<template>
	<div class="sui-box">
		<div class="sui-box-header">
			<h3 class="sui-box-title">
				{{ $i18n.settings.titles.data }}
			</h3>
		</div>
		<div class="sui-box-body">
			<div class="sui-box-settings-row">
				<div class="sui-box-settings-col-2">
					<p>{{ $i18n.settings.descriptions.data }}</p>
				</div>
			</div>
			<div class="sui-box-settings-row">
				<div class="sui-box-settings-col-1">
					<span class="sui-settings-label">
						{{ $i18n.settings.labels.uninstallation }}
					</span>
					<span class="sui-description">
						{{ $i18n.settings.descriptions.uninstallation }}
					</span>
				</div>
				<div class="sui-box-settings-col-2">
					<!-- Settings preservation -->
					<settings-preserve />
					<!-- Data preservation -->
					<data-preserve />
				</div>
			</div>

			<!-- Reset settings -->
			<reset-settings />
		</div>
		<box-footer />
	</div>
</template>

<script>
import DataPreserve from './data/data-preserve'
import BoxFooter from '../components/box-footer'
import ResetSettings from './data/reset-settings'
import SettingsPreserve from './data/settings-preserve'

export default {
	name: 'Data',

	components: {
		BoxFooter,
		DataPreserve,
		ResetSettings,
		SettingsPreserve,
	},
}
</script>
