<template>
	<sui-notice type="purple">
		<p>{{ $i18n.notices.get_access }}</p>
		<p>
			<a
				href="https://premium.wpmudev.org/project/unbranded-video-tutorials/?utm_source=integrated_video_tutorials&utm_medium=plugin&utm_campaign=integrated_video_tutorials_notice_upgrade"
				target="_blank"
				class="sui-button sui-button-purple"
			>
				{{ $i18n.buttons.get_access }}
			</a>
		</p>
	</sui-notice>
</template>

<script>
import SuiNotice from '@/components/sui/sui-notice'

export default {
	name: 'UpgradeNotice',

	components: { SuiNotice },
}
</script>
