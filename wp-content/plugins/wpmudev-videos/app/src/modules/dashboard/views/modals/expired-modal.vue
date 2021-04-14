<template>
	<div class="sui-modal sui-modal-md">
		<div
			role="dialog"
			id="wpmudev-videos-expired-account"
			class="sui-modal-content sui-content-fade-out"
			aria-modal="true"
			aria-labelledby="wpmudev-videos-expired-account-title"
			aria-describedby="wpmudev-videos-expired-account-desc"
		>
			<div class="sui-box">
				<div
					class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60"
				>
					<figure class="sui-box-banner" aria-hidden="true">
						<image-tag
							src="modal/modal-header-upgrade.png"
							:alt="$i18n.dashboard.labels.expired_account"
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
						id="wpmudev-videos-expired-account-title"
						class="sui-box-title sui-lg"
					>
						{{ $i18n.dashboard.labels.expired_account }}
					</h3>

					<p
						id="wpmudev-videos-expired-account-desc"
						class="sui-description"
					>
						{{
							sprintf(
								$i18n.dashboard.descriptions.expired_account,
								$vars.user_name
							)
						}}
					</p>
				</div>
				<div class="sui-box-footer sui-flatten sui-content-center">
					<a
						id="wpmudev-videos-expired-account-button"
						class="sui-button sui-button-purple"
						target="_blank"
						href="https://premium.wpmudev.org/?utm_source=integrated_video_tutorials&utm_medium=plugin&utm_campaign=integrated_video_tutorials_modal_renew"
					>
						{{ $i18n.dashboard.buttons.expired_account }}
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
	name: 'ExpiredModal',

	components: { ImageTag, SuiIcon },

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-expired-account',
			closeFocus: 'wpmudev-videos-expired-account-button',
		}
	},

	mounted() {
		// Open modal on render.
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
}
</script>
