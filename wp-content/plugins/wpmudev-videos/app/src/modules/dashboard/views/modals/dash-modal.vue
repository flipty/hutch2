<template>
	<div class="sui-modal sui-modal-md">
		<div
			role="dialog"
			id="wpmudev-videos-install-activate"
			class="sui-modal-content sui-content-fade-out"
			aria-modal="true"
			aria-labelledby="wpmudev-videos-install-activate-title"
			aria-describedby="wpmudev-videos-install-activate-desc"
		>
			<div class="sui-box">
				<div
					class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60"
				>
					<figure class="sui-box-banner" aria-hidden="true">
						<image-tag
							src="modal/modal-header-install-login.png"
							:alt="getLabels.title"
						/>
					</figure>

					<button
						@click="dismiss"
						class="sui-button-icon sui-button-float--right"
					>
						<sui-icon icon="close" size="md" />
						<span class="sui-screen-reader-text">
							{{ $i18n.dialogs.close }}
						</span>
					</button>

					<h3
						id="wpmudev-videos-install-activate-title"
						class="sui-box-title sui-lg"
					>
						{{ getLabels.title }}
					</h3>

					<p
						id="wpmudev-videos-install-activate-desc"
						class="sui-description"
					>
						{{ getLabels.desc }}
					</p>
				</div>

				<div class="sui-box-footer sui-flatten sui-content-center">
					<a
						class="sui-button sui-button-blue"
						:target="getLabels.target"
						:href="getLabels.link"
					>
						<sui-icon icon="wpmudev-logo" />
						{{ getLabels.button }}
					</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { restGet } from '@/helpers/api'
import Modal from '@/components/mixins/modal'
import SuiIcon from '@/components/sui/sui-icon'
import ImageTag from '@/components/elements/image-tag'

export default {
	name: 'DashModal',

	components: { ImageTag, SuiIcon },

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-install-activate',
			closeFocus: 'wpmudev-videos-install-activate-title',
		}
	},

	mounted() {
		// Open the modal on render.
		this.openModal()
	},

	methods: {
		/**
		 * Dismiss the modal and set the flag.
		 *
		 * @since 1.8.0
		 */
		dismiss() {
			// Close the modal.
			this.closeModal()

			// Make sure to set the flag.
			restGet({
				path: 'actions',
				params: {
					action: 'dismiss_dash',
				},
			})
		},
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
					desc: this.sprintf(
						this.$i18n.dashboard.descriptions.install_dash,
						this.$vars.user_name
					),
					button: this.$i18n.dashboard.buttons.install_dash,
					link:
						'https://premium.wpmudev.org/project/wpmu-dev-dashboard/',
					target: '_blank',
				}
			} else if (!this.dashActive()) {
				return {
					title: this.$i18n.dashboard.labels.activate_dash,
					desc: this.sprintf(
						this.$i18n.dashboard.descriptions.activate_dash,
						this.$vars.user_name
					),
					button: this.$i18n.dashboard.buttons.activate_dash,
					link: this.$vars.urls.plugins,
					target: '_self',
				}
			} else {
				return {
					title: this.$i18n.dashboard.labels.login_dash,
					desc: this.sprintf(
						this.$i18n.dashboard.descriptions.login_dash,
						this.$vars.user_name
					),
					button: this.$i18n.dashboard.buttons.login_dash,
					link: this.$vars.urls.dash_login,
					target: '_self',
				}
			}
		},
	},
}
</script>
