<template>
	<div class="sui-box">
		<div class="sui-box-header">
			<h2 class="sui-box-title">
				{{ $i18n.settings.titles.permissions }}
			</h2>
		</div>

		<div class="sui-box-body">
			<roles-settings />
		</div>

		<box-footer />
	</div>
</template>

<script>
import BoxFooter from '../components/box-footer'
import RolesSettings from './permissions/roles-settings'

export default {
	name: 'Permissions',

	components: { BoxFooter, RolesSettings },
}
</script>
