<template>
	<div
		:id="`${form}-playlist-settings`"
		class="sui-modal-slide sui-active sui-loaded"
	>
		<div class="sui-box">
			<div
				class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60 sui-spacing-sides--100"
			>
				<whitelabel-modal-banner
					src="modal/modal-header-playlists.png"
					:alt="$i18n.playlists.labels.create_playlist"
				/>

				<button
					@click="$emit('dismiss')"
					class="sui-button-icon sui-button-float--right"
				>
					<sui-icon icon="close" size="md" />
					<span class="sui-screen-reader-text">
						{{ $i18n.dialogs.close }}
					</span>
				</button>

				<h3 :id="`${form}-title`" class="sui-box-title sui-lg">
					{{ $i18n.playlists.labels.create_playlist }}
				</h3>

				<p :id="`${form}-desc`" class="sui-description">
					{{ $i18n.playlists.descriptions.create_playlist }}
				</p>
			</div>

			<div class="sui-box-body">
				<!-- Playlist title -->
				<playlist-title :form="form" :playlist.sync="playlist" />

				<!-- Playlist description -->
				<playlist-description :form="form" :playlist.sync="playlist" />

				<hr class="wpmudev-videos-break" />

				<!-- Playlist thumbnail -->
				<playlist-thumbnail :form="form" :playlist.sync="playlist" />
			</div>

			<div class="sui-box-footer">
				<button
					class="sui-button sui-button-ghost"
					@click="$emit('dismiss')"
				>
					{{ $i18n.buttons.cancel }}
				</button>
				<div class="sui-actions-right">
					<button
						:data-modal-slide="`${form}-playlist-videos`"
						data-modal-slide-intro="next"
						role="button"
						class="sui-button"
						:disabled="!canContinue"
					>
						{{ $i18n.dialogs.continue }}
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import PlaylistTitle from './../../../components/fields/playlist-title'
import PlaylistThumbnail from './../../../components/fields/playlist-thumbnail'
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'
import PlaylistDescription from './../../../components/fields/playlist-description'

export default {
	name: 'PlaylistSettingsSlide',

	components: {
		SuiIcon,
		PlaylistTitle,
		PlaylistThumbnail,
		PlaylistDescription,
		WhitelabelModalBanner,
	},

	props: {
		form: {
			type: String,
			required: true,
		},
		playlist: {
			type: Object,
			required: true,
		},
	},

	computed: {
		/**
		 * Check if we can continue to next slide.
		 *
		 * Continue if the title is not empty.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		canContinue() {
			return this.playlist.title !== ''
		},
	},
}
</script>
