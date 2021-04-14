<template>
	<div class="sui-form-field">
		<label
			class="sui-label"
			:for="`${form}-playlist-title`"
			:id="`${form}-playlist-title-label`"
		>
			{{ $i18n.playlists.labels.playlist_name }}
		</label>

		<input
			v-model="title"
			:placeholder="$i18n.playlists.labels.placeholder_name"
			:id="`${form}-playlist-title`"
			class="sui-form-control"
			:aria-labelledby="`${form}-playlist-title-label`"
			:aria-describedby="`${form}-playlist-title-desc`"
		/>
	</div>
</template>

<script>
export default {
	name: 'PlaylistTitle',

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
		 * Playlist title option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		title: {
			get() {
				return this.playlist.title
			},

			set(title) {
				let playlist = this.playlist

				playlist.title = title

				// Emit playlist update event.
				this.$emit('update:playlist', playlist)
			},
		},
	},
}
</script>
