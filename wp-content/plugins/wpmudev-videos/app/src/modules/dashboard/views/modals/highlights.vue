<template>
	<div class="sui-modal sui-modal-md">
		<div
			role="dialog"
			:id="modal"
			class="sui-modal-content sui-content-fade-out"
			aria-modal="true"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-desc`"
		>
			<div class="sui-box">
				<div
					class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60"
				>
					<whitelabel-modal-banner
						src="welcome/playlist-reordering.png"
						:alt="$i18n.dashboard.titles.highlights"
					/>

					<button
						@click="dismiss"
						class="sui-button-icon sui-button-white sui-button-float--right"
					>
						<sui-icon icon="close" size="md" />
						<span class="sui-screen-reader-text">
							{{ $i18n.dialogs.close }}
						</span>
					</button>

					<h3 :id="`${modal}-title`" class="sui-box-title sui-lg">
						{{ $i18n.dashboard.titles.highlights }}
					</h3>
					<p
						:id="`${modal}-desc`"
						class="sui-description"
						v-html="$i18n.dashboard.descriptions.highlights"
					></p>
				</div>

				<div
					class="sui-box-footer sui-flatten sui-content-center sui-spacing-bottom--50"
				>
					<button class="sui-button" @click="dismiss">
						{{ $i18n.dashboard.buttons.got_it }}
					</button>
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
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'

export default {
	name: 'Highlights',

	components: {
		ImageTag,
		SuiIcon,
		WhitelabelModalBanner,
	},

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-welcome-highlight',
			closeFocus: 'wpmudev-videos-welcome-highlight-title',
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
					action: 'dismiss_welcome',
				},
			})
		},
	},
}
</script>
