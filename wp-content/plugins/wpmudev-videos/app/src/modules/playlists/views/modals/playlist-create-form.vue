<template>
	<div class="sui-modal sui-modal-lg">
		<div
			role="dialog"
			class="sui-modal-content"
			aria-modal="true"
			aria-live="polite"
			:id="modal"
			:aria-labelledby="`${modal}-title`"
			:aria-describedby="`${modal}-desc`"
		>
			<!-- Playlist settings form -->
			<playlist-settings-slide
				:form="modal"
				:playlist.sync="playlist"
				@dismiss="closeModal"
			/>

			<!-- Playlist videos form -->
			<playlist-videos-slide
				:form="modal"
				:playlist.sync="playlist"
				@dismiss="closeModal"
			/>
		</div>
	</div>
</template>

<script>
import Modal from '@/components/mixins/modal'
import ImageTag from '@/components/elements/image-tag'
import PlaylistVideosSlide from './slides/playlist-videos-slide'
import PlaylistSettingsSlide from './slides/playlist-settings-slide'

export default {
	name: 'VideoCreateForm',

	components: {
		ImageTag,
		PlaylistVideosSlide,
		PlaylistSettingsSlide,
	},

	mixins: [Modal],

	data() {
		return {
			modal: 'wpmudev-videos-playlist-create-modal',
			closeFocus: 'wpmudev-videos-playlist-create-opener',
			playlist: this.emptyPlaylist(),
		}
	},

	created() {
		// On create button click.
		this.$root.$on('openPlaylistCreateModal', this.openModal)

		// On modal close reset the form.
		this.$on('modal:close', () => {
			this.playlist = this.emptyPlaylist()
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
		 * Get an empty playlist object.
		 *
		 * @since 1.8.0
		 *
		 * @returns {object}
		 */
		emptyPlaylist() {
			return {
				title: '',
				description: '',
				videos: [],
				locations: [],
				thumbnail: {
					id: 0,
					file: '',
					url: '',
				},
				type: 'custom',
			}
		},
	},
}
</script>
