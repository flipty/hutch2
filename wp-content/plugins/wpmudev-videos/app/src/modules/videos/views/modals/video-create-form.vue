<template>
	<div class="sui-modal sui-modal-lg">
		<div
			role="dialog"
			class="sui-modal-content sui-content-fade-out"
			aria-modal="true"
			aria-live="polite"
			:id="modal"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-desc`"
		>
			<!-- Video host selector -->
			<video-host-slide
				:form="modal"
				:next="`${modal}-url-form`"
				:video.sync="video"
				@dismiss="closeModal"
			/>

			<!-- Video url form -->
			<video-url-slide
				:form="modal"
				:next="`${modal}-playlist-form`"
				:prev="`${modal}-host-selector`"
				:video.sync="video"
				@dismiss="closeModal"
			/>

			<!-- Video playlist form -->
			<video-playlist-slide
				:form="modal"
				:prev="`${modal}-url-form`"
				:video.sync="video"
				@dismiss="closeModal"
			/>
		</div>
	</div>
</template>

<script>
import Modal from '@/components/mixins/modal'
import VideoUrlSlide from './slides/video-url-slide'
import VideoHostSlide from './slides/video-host-slide'
import ImageTag from '@/components/elements/image-tag'
import VideoPlaylistSlide from './slides/video-playlist-slide'

export default {
	name: 'VideoCreateForm',

	components: {
		ImageTag,
		VideoUrlSlide,
		VideoHostSlide,
		VideoPlaylistSlide,
	},

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-video-create-modal',
			closeFocus: 'wpmudev-videos-create-form-opener',
			video: this.emptyVideo(),
		}
	},

	created() {
		// On create button click.
		this.$root.$on('openVideoCreateModal', this.openModal)

		// On modal close reset the form.
		this.$on('modal:close', function () {
			this.video = this.emptyVideo()
		})
	},

	mounted() {
		// If asked to open.
		if (
			this.$route.params.action &&
			'create' === this.$route.params.action
		) {
			this.openModal()
		}
	},

	methods: {
		/**
		 * Get an empty video object.
		 *
		 * @since 1.8.0
		 *
		 * @returns {object}
		 */
		emptyVideo() {
			return {
				host: '',
				url: '',
				title: '',
				start_enabled: 0,
				end_enabled: 0,
				start_time: '',
				end_time: '',
				playlists: [],
				thumbnail: {
					id: 0,
					file: '',
					url: '',
				},
				duration: '',
				embed: '',
			}
		},
	},
}
</script>
