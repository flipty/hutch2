<template>
	<!-- When membership is not valid for videos -->
	<sui-notice type="purple">
		<p>{{ $i18n.playlists.notices.get_access }}</p>
		<p
			v-html="
				sprintf(
					$i18n.playlists.notices.create_custom_videos,
					$vars.urls.videos
				)
			"
		></p>
		<p>
			<a
				class="sui-button sui-button-purple"
				target="_blank"
				href="https://premium.wpmudev.org/project/unbranded-video-tutorials/?utm_source=integrated_video_tutorials&utm_medium=plugin&utm_campaign=integrated_video_tutorials_modal_upgrade"
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
