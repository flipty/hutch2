<template>
	<div class="sui-wrap">
		<sui-header :title="$i18n.dashboard.titles.dashboard" />

		<!-- Expired membership banner -->
		<expired-banner v-if="expiredMember()" />

		<!-- Upgrade membership banner -->
		<upgrade-banner v-else-if="shouldUpgrade" />

		<!-- Dash plugin install banner -->
		<dash-banner v-else-if="!validMember()" />

		<!-- Summary box -->
		<summary-box />
		<!-- Summary end -->

		<div class="sui-row">
			<div class="sui-col-md-6">
				<!-- Videos section -->
				<videos />
				<!-- videos end -->
			</div>

			<div class="sui-col-md-6">
				<!-- Playlists section -->
				<playlists />
				<!-- playlists end -->
			</div>
		</div>

		<!-- Dash plugin install modal -->
		<highlights v-if="showWelcome" />

		<!-- Expired membership modal -->
		<expired-modal v-else-if="showExpiredModal" />

		<!-- Upgrade membership modal -->
		<upgrade-modal v-else-if="showUpgradeModal" />

		<!-- Dash plugin install modal -->
		<dash-modal v-else-if="showDashModal" />

		<sui-footer />
	</div>
</template>

<script>
import Videos from './views/videos'
import Playlists from './views/playlists'
import SummaryBox from './views/summary-box'
import DashModal from './views/modals/dash-modal'
import Highlights from './views/modals/highlights'
import SuiFooter from '@/components/sui/sui-footer'
import SuiHeader from '@/components/sui/sui-header'
import DashBanner from './views/banners/dash-banner'
import ExpiredModal from './views/modals/expired-modal'
import UpgradeModal from './views/modals/upgrade-modal'
import ExpiredBanner from './views/banners/expired-banner'
import UpgradeBanner from './views/banners/upgrade-banner'

export default {
	name: 'App',

	components: {
		Videos,
		Playlists,
		SuiHeader,
		SuiFooter,
		SummaryBox,
		DashModal,
		Highlights,
		DashBanner,
		ExpiredModal,
		UpgradeModal,
		ExpiredBanner,
		UpgradeBanner,
	},

	computed: {
		/**
		 * Check if welcome modal is required.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		showWelcome() {
			return this.getOption('dismiss_welcome_notice', 0) <= 0
		},

		/**
		 * Check if dash modal can be shown.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		canShowModal() {
			return this.getOption('dismiss_dash_notice', 0) <= 0
		},

		/**
		 * Check if Dash plugin modal is required.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		showDashModal() {
			return !this.validMember() && this.canShowModal
		},

		/**
		 * Check if we need to show expired membership modal.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		showExpiredModal() {
			return (
				this.expiredMember() && this.dashActive() && this.canShowModal
			)
		},

		/**
		 * Check if we need to show upgrade membership modal.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		showUpgradeModal() {
			return this.shouldUpgrade && this.canShowModal
		},

		/**
		 * Check if current membership needs an upgrade.
		 *
		 * @since 1.8.2
		 *
		 * @return {boolean}
		 */
		shouldUpgrade() {
			return (
				!this.expiredMember() &&
				!this.validMember() &&
				this.dashConnected()
			)
		},
	},
}
</script>

<style lang="scss">
@import 'styles/main';
</style>
