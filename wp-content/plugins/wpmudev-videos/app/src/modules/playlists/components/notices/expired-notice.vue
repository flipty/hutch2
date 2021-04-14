<template>
	<!-- When no custom videos are found and Dash plugin is inactive -->
	<sui-notice type="purple">
		<p
			v-html="
				sprintf(
					$i18n.playlists.notices.default_videos_not_available,
					$vars.urls.videos
				)
			"
		></p>
		<p>
			<a
				class="sui-button sui-button-purple"
				target="_blank"
				href="https://premium.wpmudev.org/?utm_source=integrated_video_tutorials&utm_medium=plugin&utm_campaign=integrated_video_tutorials_modal_renew"
			>
				{{ $i18n.buttons.renew_membership }}
			</a>
		</p>
	</sui-notice>
</template>

<script>
import SuiNotice from '@/components/sui/sui-notice'

export default {
	name: 'ExpiredNotice',

	components: { SuiNotice },
}
</script>
