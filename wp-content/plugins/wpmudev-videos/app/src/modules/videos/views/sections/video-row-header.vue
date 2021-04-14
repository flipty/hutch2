<template>
	<div
		role="heading"
		class="wpmudev-videos-accordion--heading wpmudev-videos-accordion--row"
	>
		<div class="wpmudev-videos-accordion--col-large">
			<button
				class="wpmudev-videos-accordion--title"
				aria-expanded="false"
				:id="`wpmudev-videos-accordion-item-${video.id}--label`"
				:aria-controls="`wpmudev-videos-accordion-item-${video.id}`"
				:disabled="disabled"
				@click="showVideo"
				v-if="!isOpen"
			>
				<list-thumb
					:thumb="video.thumbnail || {}"
					:is-custom="isCustomVideo"
					:icon="video.video_slug"
					class="video-thumb"
				/>

				<span
					class="sui-icon-play sui-sm video-icon"
					aria-hidden="true"
				></span>

				<span class="video-name">{{ video.video_title }}</span>
			</button>

			<fragment v-else>
				<p class="video-name">{{ video.video_title }}</p>

				<p class="video-length">{{ video.video_duration }}</p>
			</fragment>
		</div>

		<div class="wpmudev-videos-accordion--col-small">
			<div class="wpmudev-videos-accordion--actions">
				<sui-button-icon
					icon="add-playlist"
					ref="playlistButton"
					:label="$i18n.videos.buttons.add_to_playlist"
					:outlined="true"
					:tooltip="$i18n.videos.labels.add_to_playlist"
					:disabled="disabled"
					@click="openPlaylistForm"
				/>

				<sui-button-icon
					icon="code"
					class="beehive-copy-shortcode"
					:label="$i18n.videos.buttons.copy_shortcode"
					:outlined="true"
					:tooltip="$i18n.videos.buttons.copy_shortcode"
					:data-clipboard-text="getShortCode"
					:disabled="disabled"
					@click="copiedNotice"
					v-if="isOpen"
				/>

				<sui-button-icon
					icon="pencil"
					:label="$i18n.videos.buttons.edit_video"
					:outlined="true"
					:tooltip="$i18n.videos.buttons.edit_video"
					:disabled="disabled"
					@click="openEditForm"
					v-if="isOpen && isCustomVideo"
				/>
				<sui-button-icon
					icon="pencil"
					:label="$i18n.videos.buttons.edit_title"
					:outlined="true"
					:tooltip="$i18n.videos.buttons.edit_title"
					:disabled="disabled"
					@click="openTitleForm"
					v-else-if="isOpen"
				/>

				<p class="sui-description" v-if="!isOpen">
					{{ video.video_duration || $i18n.videos.labels.unknown }}
				</p>

				<div class="sui-dropdown" v-if="!isOpen">
					<button
						class="sui-button-icon sui-dropdown-anchor"
						:disabled="disabled"
					>
						<span
							class="sui-icon-widget-settings-config"
							aria-hidden="true"
						></span>
						<span class="sui-screen-reader-text">
							{{ $i18n.videos.labels.video_actions }}
						</span>
					</button>

					<ul>
						<li v-if="isCustomVideo">
							<button
								ref="editButton"
								@click="openEditForm"
								:disabled="disabled"
							>
								<span
									class="sui-icon-pencil"
									aria-hidden="true"
								></span>
								{{ $i18n.videos.buttons.edit_video }}
							</button>
						</li>

						<li v-else>
							<button
								ref="editButton"
								@click="openTitleForm"
								:disabled="disabled"
							>
								<span
									class="sui-icon-pencil"
									aria-hidden="true"
								></span>
								{{ $i18n.videos.buttons.edit_title }}
							</button>
						</li>

						<li>
							<button
								class="beehive-copy-shortcode"
								:disabled="disabled"
								@click="copiedNotice"
								:data-clipboard-text="getShortCode"
							>
								<span
									class="sui-icon-code"
									aria-hidden="true"
								></span>
								{{ $i18n.videos.buttons.copy_shortcode }}
							</button>
						</li>

						<li v-if="isCustomVideo">
							<button
								@click="openDeleteForm"
								:disabled="disabled"
								class="wpmudev-videos-red"
								ref="deleteButton"
							>
								<span
									class="sui-icon-trash"
									aria-hidden="true"
								></span>
								{{ $i18n.videos.buttons.delete_video }}
							</button>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import ListThumb from '@/components/elements/list-thumb'
import SuiButtonIcon from '@/components/sui/sui-button-icon'

export default {
	name: 'VideoRowHeader',

	components: {
		ListThumb,
		SuiButtonIcon,
	},

	props: {
		video: {
			type: Object,
			required: true,
		},
		isOpen: {
			type: Boolean,
			default: false,
		},
		disabled: {
			type: Boolean,
			default: false,
		},
		action: {
			type: Object,
			default: {
				id: 0,
				action: '',
			},
		},
	},

	mounted() {
		// Process url actions.
		this.doAction()
	},

	computed: {
		/**
		 * Check if current video is custom video.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		isCustomVideo() {
			return this.video.video_type && 'custom' === this.video.video_type
		},

		/**
		 * Get shortcode of the current video.
		 *
		 * @since 1.8.0
		 *
		 * @return {string}
		 */
		getShortCode() {
			if (this.isCustomVideo) {
				return '[wpmudev-video video="' + this.video.id + '"]'
			} else {
				return '[wpmudev-video video="' + this.video.video_slug + '"]'
			}
		},
	},

	methods: {
		/**
		 * Emit the video title edit modal event.
		 *
		 * @since 1.8.0
		 */
		openTitleForm(event) {
			this.$root.$emit('openVideoTitleFormModal', {
				video: this.video,
				focus: event.target,
			})
		},

		/**
		 * Emit the video edit modal event.
		 *
		 * This event should be only available for
		 * the custom video type.
		 *
		 * @since 1.8.0
		 */
		openEditForm(event) {
			this.$root.$emit('openVideoEditFormModal', {
				video: this.video,
				focus: event.target,
			})
		},

		/**
		 * Emit the video playlist form modal event.
		 *
		 * @since 1.8.0
		 */
		openPlaylistForm(event) {
			this.$root.$emit('openVideoPlaylistFormModal', {
				video: this.video,
				focus: event.target,
			})
		},

		/**
		 * Emit the delete modal open event.
		 *
		 * @since 1.8.0
		 */
		openDeleteForm(event) {
			this.$root.$emit('openVideoDeleteFormModal', {
				video: this.video,
				focus: event.target,
			})
		},

		/**
		 * Show the shortcode copied message.
		 *
		 * @since 1.8.0
		 */
		copiedNotice() {
			this.$root.$emit('showTopNotice', {
				message: this.$i18n.notices.shortcode_copied,
			})
		},

		/**
		 * Navigate to video view action.
		 *
		 * @since 1.8.0
		 */
		showVideo() {
			this.$router.push({
				name: 'VideosBox',
				params: {
					action: 'view',
					video: this.video.id,
				},
			})
		},

		/**
		 * Perform the action from url.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		doAction() {
			// Only if current video.
			if ('' !== this.action.action && this.action.id == this.video.id) {
				switch (this.action.action) {
					case 'edit':
						this.$refs.editButton.click()
						break
					case 'delete':
						if (this.$refs.deleteButton) {
							this.$refs.deleteButton.click()
						}
						break
					case 'playlist':
						// Click on the playlist button.
						this.$refs.playlistButton.$el.click()
						break
				}
			}
		},
	},
}
</script>
