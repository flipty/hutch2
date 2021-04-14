<template>
	<sui-notice type="purple">
		<p>{{ $i18n.notices.membership_expired }}</p>
		<p>
			<a
				href="https://premium.wpmudev.org/?utm_source=integrated_video_tutorials&utm_medium=plugin&utm_campaign=integrated_video_tutorials_notice_renew"
				target="_blank"
				class="sui-button sui-button-purple"
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
