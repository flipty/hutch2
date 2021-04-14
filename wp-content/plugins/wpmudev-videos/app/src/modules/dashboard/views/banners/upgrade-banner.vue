<template>
	<div class="sui-box sui-message sui-message-lg wpmudev-videos-box-message">
		<div class="sui-message-content">
			<h2 class="wpmudev-videos-box-message--title">
				{{ $i18n.dashboard.labels.get_access }}
			</h2>

			<p class="sui-description">
				{{
					sprintf(
						$i18n.dashboard.descriptions.get_access,
						$vars.user_name
					)
				}}
			</p>

			<p>
				<a
					target="_blank"
					href="https://premium.wpmudev.org/project/unbranded-video-tutorials/?utm_source=integrated_video_tutorials&utm_medium=plugin&utm_campaign=integrated_video_tutorials_banner_get"
					class="sui-button sui-button-purple"
				>
					{{ $i18n.dashboard.buttons.get_access }}
				</a>
			</p>
		</div>

		<image-tag
			src="banner/expired-banner.png"
			:alt="$i18n.dashboard.labels.get_access"
			class="sui-image sui-image-center"
		/>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import ImageTag from '@/components/elements/image-tag'

export default {
	name: 'UpgradeBanner',

	components: { ImageTag, SuiIcon },
}
</script>
