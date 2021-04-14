<template>
	<sui-notice type="info">
		<p>{{ getLabels.desc }}</p>

		<p>
			<a
				class="sui-button sui-button-blue"
				:href="getLabels.link"
				:target="getLabels.target"
			>
				{{ getLabels.button }}
			</a>
		</p>
	</sui-notice>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import SuiNotice from '@/components/sui/sui-notice'

export default {
	name: 'DashNotice',

	components: {
		SuiNotice,
		SuiIcon,
	},

	computed: {
		/**
		 * Get labels and links for the banner.
		 *
		 * Based on the status of WPMUDEV Dash plugin status,
		 * set the labels and links for the banner.
		 *
		 * @since 1.8.4
		 *
		 * @return {*}
		 */
		getLabels() {
			if (!this.dashInstalled()) {
				return {
					desc: this.$i18n.notices.install_dash,
					button: this.$i18n.buttons.install_dash,
					link: this.$vars.urls.dash_install,
					target: '_blank',
				}
			} else if (!this.dashActive()) {
				return {
					desc: this.$i18n.notices.activate_dash,
					button: this.$i18n.buttons.activate_dash,
					link: this.$vars.urls.plugins,
					target: '_self',
				}
			} else {
				return {
					desc: this.$i18n.notices.login_dash,
					button: this.$i18n.buttons.login_dash,
					link: this.$vars.urls.dash_login,
					target: '_self',
				}
			}
		},
	},
}
</script>
