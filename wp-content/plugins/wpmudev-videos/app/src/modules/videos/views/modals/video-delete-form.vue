<template>
	<div class="sui-modal sui-modal-sm">
		<div
			:id="modal"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-desc`"
			class="sui-modal-content sui-content-fade-in"
			aria-modal="true"
			role="dialog"
		>
			<div class="sui-box">
				<div
					class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60"
				>
					<button
						class="sui-button-icon sui-button-float--right"
						@click="closeModal"
						:id="`${modal}-close`"
					>
						<i class="sui-icon-close sui-md" aria-hidden="true"></i>
						<span class="sui-screen-reader-text">
							{{ $i18n.dialogs.close }}
						</span>
					</button>

					<h3 :id="`${modal}-title`" class="sui-box-title sui-lg">
						{{ $i18n.videos.labels.delete_video }}
					</h3>

					<p :id="`${modal}-desc`" class="sui-description">
						{{ $i18n.videos.descriptions.delete_video }}
					</p>
				</div>

				<div class="sui-box-footer sui-flatten sui-content-center">
					<button
						class="sui-button sui-button-ghost"
						@click="closeModal"
					>
						{{ $i18n.dialogs.cancel }}
					</button>

					<button
						type="button"
						:id="`${modal}-submit`"
						class="sui-button sui-button-red sui-button-ghost"
						:class="loadingClass"
						aria-live="polite"
						@click="deleteVideo"
					>
						<span class="sui-button-text-default">
							{{ $i18n.buttons.delete }}
						</span>
						<span class="sui-button-text-onload">
							<i
								class="sui-icon-loader sui-loading"
								aria-hidden="true"
							></i>
							{{ $i18n.buttons.deleting }}
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Modal from '@/components/mixins/modal'
import { deleteVideo } from '@/helpers/videos'

export default {
	name: 'VideoDeleteForm',

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-video-delete-modal',
			deleting: false,
			video: {},
		}
	},

	created() {
		// Open modal on event.
		this.$root.$on('openVideoDeleteFormModal', (data) => {
			this.video = data.video
			this.closeFocus = data.focus
			this.openFocus = this.modal + '-close'

			// Open current modal.
			this.openModal()
		})
	},

	computed: {
		/**
		 * Get the loading class for the button.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.deleting,
			}
		},
	},

	methods: {
		/**
		 * Delete the current video and update state.
		 *
		 * Vuex will take care of updating the state.
		 *
		 * @since 1.8.0
		 *
		 * @return {Promise<void>}
		 */
		async deleteVideo() {
			this.deleting = true

			// Delete the video.
			let result = await deleteVideo(this.video.id)

			if (result.success) {
				// Close the modal.
				this.closeModal()

				// Fire deleted event.
				this.$root.$emit('customVideoDeleted', this.video)

				// Show success notice.
				this.$root.$emit('showTopNotice', {
					message: this.$i18n.videos.notices.video_deleted,
				})

				this.video = {}
			} else {
				// Show error notice.
				this.$root.$emit('showTopNotice', {
					type: 'error',
					message: result.message,
				})
			}

			this.deleting = false
		},
	},
}
</script>
