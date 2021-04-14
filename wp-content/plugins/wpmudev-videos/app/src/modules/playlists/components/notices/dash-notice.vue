<template>
	<!-- When no custom videos are found and Dash plugin is inactive -->
	<sui-notice type="info">
		<p>{{ getLabels.desc }}</p>
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
				class="sui-button sui-button-blue"
				:target="getLabels.target"
				:href="getLabels.link"
			>
				{{ getLabels.button }}
			</a>
		</p>
	</sui-notice>
</template>

<script>
import SuiNotice from '@/components/sui/sui-notice'

export default {
	name: 'DashNotice',

	components: { SuiNotice },

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
					desc: this.$i18n.playlists.notices.install_plugin,
					button: this.$i18n.buttons.install_dash,
					link: this.$vars.urls.dash_install,
					target: '_blank',
				}
			} else if (!this.dashActive()) {
				return {
					desc: this.$i18n.playlists.notices.activate_plugin,
					button: this.$i18n.buttons.activate_dash,
					link: this.$vars.urls.plugins,
					target: '_self',
				}
			} else {
				return {
					desc: this.$i18n.playlists.notices.login_plugin,
					button: this.$i18n.buttons.login_dash,
					link: this.$vars.urls.dash_login,
					target: '_self',
				}
			}
		},
	},
}
</script>
