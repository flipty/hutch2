<template>
	<div class="sui-box sui-message sui-message-lg wpmudev-videos-box-message">
		<div class="sui-message-content">
			<h2 class="wpmudev-videos-box-message--title">
				{{ $i18n.dashboard.labels.expired_account }}
			</h2>

			<p class="sui-description">
				{{
					sprintf(
						$i18n.dashboard.descriptions.expired_account,
						$vars.user_name
					)
				}}
			</p>

			<p>
				<membership-refresh-button />
				<a
					target="_blank"
					href="https://premium.wpmudev.org/?utm_source=integrated_video_tutorials&utm_medium=plugin&utm_campaign=integrated_video_tutorials_banner_renew"
					class="sui-button sui-button-purple"
				>
					{{ $i18n.dashboard.buttons.expired_account }}
				</a>
			</p>
		</div>

		<image-tag
			src="banner/expired-banner.png"
			:alt="$i18n.dashboard.labels.expired_account"
			class="sui-image sui-image-center"
		/>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import ImageTag from '@/components/elements/image-tag'
import MembershipRefreshButton from '@/components/elements/membership-refresh-button'

export default {
	name: 'ExpiredBanner',

	components: {
		ImageTag,
		MembershipRefreshButton,
		SuiIcon,
	},
}
</script>
