<template>
	<div class="sui-form-field">
		<label
			class="sui-label"
			:for="`${form}-playlist-desc`"
			:id="`${form}-playlist-desc-label`"
		>
			{{ $i18n.playlists.labels.playlist_desc }}
		</label>

		<textarea
			class="sui-form-control"
			v-model="description"
			:id="`${form}-playlist-desc`"
			:aria-labelledby="`${form}-playlist-desc-label`"
			:aria-describedby="`${form}-playlist-desc-desc`"
		></textarea>
	</div>
</template>

<script>
export default {
	name: 'PlaylistDescription',

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
		 * Playlist description option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		description: {
			get() {
				return this.playlist.description
			},
			set(description) {
				let playlist = this.playlist

				playlist.description = description

				// Emit playlist update event.
				this.$emit('update:playlist', playlist)
			},
		},
	},
}
</script>
