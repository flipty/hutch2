<template>
	<div class="sui-box">
		<div class="sui-box-header">
			<h2 class="sui-box-title">
				{{ $i18n.settings.titles.import_export }}
			</h2>
		</div>
		<div class="sui-box-body">
			<import-configs />

			<export-configs />
		</div>
	</div>
</template>

<script>
import ImportConfigs from './import-export/import-configs'
import ExportConfigs from './import-export/export-configs'

export default {
	name: 'ImportExport',

	components: {
		ImportConfigs,
		ExportConfigs,
	},

	data() {
		return {}
	},

	computed: {},
}
</script>
