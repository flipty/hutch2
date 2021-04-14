<template>
	<div class="sui-box sui-message sui-message-lg wpmudev-videos-box-message">
		<div class="sui-message-content">
			<h2 class="wpmudev-videos-box-message--title">
				{{ getLabels.title }}
			</h2>

			<p class="sui-description">
				{{ getLabels.desc }}
			</p>

			<p>
				<a
					class="sui-button sui-button-blue"
					:href="getLabels.link"
					:target="getLabels.target"
				>
					<sui-icon icon="wpmudev-logo" />
					{{ getLabels.button }}
				</a>
			</p>
		</div>

		<image-tag
			src="banner/devman-banner.png"
			:alt="getLabels.title"
			:class="'sui-image sui-image-center'"
			v-if="!$vars.whitelabel.hide_branding"
		/>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import ImageTag from '@/components/elements/image-tag'

export default {
	name: 'DashBanner',

	components: {
		ImageTag,
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
					title: this.$i18n.dashboard.labels.install_dash,
					desc: this.$i18n.dashboard.descriptions.banner_install_dash,
					button: this.$i18n.dashboard.buttons.install_dash,
					link:
						'https://premium.wpmudev.org/project/wpmu-dev-dashboard/',
					target: '_blank',
				}
			} else if (!this.dashActive()) {
				return {
					title: this.$i18n.dashboard.labels.activate_dash,
					desc: this.$i18n.dashboard.descriptions
						.banner_activate_dash,
					button: this.$i18n.dashboard.buttons.activate_dash,
					link: this.$vars.urls.plugins,
					target: '_self',
				}
			} else {
				return {
					title: this.$i18n.dashboard.labels.login_dash,
					desc: this.$i18n.dashboard.descriptions.banner_login_dash,
					button: this.$i18n.dashboard.buttons.login_dash,
					link: this.$vars.urls.dash_login,
					target: '_self',
				}
			}
		},
	},
}
</script>
