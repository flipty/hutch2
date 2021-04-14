<template>
	<div class="sui-modal sui-modal-sm">
		<div
			role="dialog"
			class="sui-modal-content sui-content-fade-out"
			aria-modal="true"
			:id="modal"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-title`"
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
						{{ $i18n.videos.labels.video_title }}
					</h3>

					<p :id="`${modal}-desc`" class="sui-description">
						{{ $i18n.videos.descriptions.change_title }}
					</p>

					<div class="sui-form-field">
						<input
							v-model="title"
							class="sui-form-control"
							id="wpmudev-videos-video-title-form-title-input"
							:placeholder="$i18n.videos.labels.video_title"
						/>
					</div>

					<button
						type="button"
						class="sui-button sui-button-blue"
						aria-live="polite"
						:class="loadingClass"
						@click="saveChanges"
					>
						<span class="sui-button-text-default">
							{{ $i18n.buttons.save_changes }}
						</span>
						<span class="sui-button-text-onload">
							<i
								class="sui-icon-loader sui-loading"
								aria-hidden="true"
							></i>
							{{ $i18n.buttons.saving_changes }}
						</span>
					</button>
				</div>

				<div
					class="sui-box-footer sui-flatten sui-content-center"
				></div>

				<whitelabel-modal-banner
					src="summary/dashboard.png"
					img-class="sui-image sui-image-center"
					:alt="$i18n.videos.labels.video_title"
				/>
			</div>
		</div>
	</div>
</template>

<script>
import Modal from '@/components/mixins/modal'
import { updateVideo } from '@/helpers/videos'
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'

export default {
	name: 'VideoTitleForm',

	components: { WhitelabelModalBanner },

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-video-title-modal',
			openFocus: 'wpmudev-videos-video-title-form-title-input',
			title: '',
			video: {},
			saving: false,
		}
	},

	created() {
		// Open the modal on event.
		this.$root.$on('openVideoTitleFormModal', (data) => {
			this.video = data.video
			this.title = data.video.video_title
			this.closeFocus = data.focus
			this.openFocus = this.modal + '-close'

			this.openModal()
		})
	},

	computed: {
		/**
		 * Get loading class when saving.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		loadingClass() {
			return {
				'sui-button-onload-text': this.saving,
			}
		},
	},

	methods: {
		/**
		 * Save title change to the db.
		 *
		 * Vuex will take care of updating the object.
		 *
		 * @since 1.8.0
		 */
		async saveChanges() {
			if (this.title.length > 0 && this.video.id) {
				this.saving = true

				// Delete the video.
				let result = await updateVideo(this.video.id, {
					title: this.title,
				})

				// Close the modal.
				this.closeModal()

				if (result.success) {
					// Show success notice.
					this.$root.$emit('showTopNotice', {
						message: sprintf(
							this.$i18n.videos.notices.video_title_updated,
							this.title
						),
					})
				} else {
					// Show error notice.
					this.$root.$emit('showTopNotice', {
						type: 'error',
						message: this.$i18n.videos.notices
							.video_title_update_failed,
					})
				}

				// Reset modal.
				this.resetModal()

				this.saving = false
			}
		},

		/**
		 * Reset the modal form fields.
		 *
		 * @since 1.8.0
		 */
		resetModal() {
			this.video = {}
			this.title = ''
		},
	},
}
</script>
