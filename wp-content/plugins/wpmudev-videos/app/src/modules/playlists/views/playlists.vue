<template>
	<sui-accordion>
		<playlist-loader v-if="loading" />
		<sortable-elements @update="orderChange">
			<playlist-item
				v-for="playlist in getPlaylists"
				:selected.sync="selected"
				:playlist="playlist"
				:key="playlist.id"
				:action="getAction"
			/>
		</sortable-elements>
	</sui-accordion>
</template>

<script>
import { restGet } from '@/helpers/api'
import PlaylistItem from './sections/playlist-item'
import SuiAccordion from '@/components/sui/sui-accordion'
import PlaylistLoader from './../components/playlist-loader'
import SortableElements from '@/components/elements/sortable-elements'

export default {
	name: 'Playlists',

	components: {
		SuiAccordion,
		PlaylistItem,
		PlaylistLoader,
		SortableElements,
	},

	props: {
		selected: {
			type: Object,
			required: true,
		},
		action: {
			type: String,
			default: '',
		},
		playlist: {
			type: Number | String,
			default: 0,
		},
		loading: {
			type: Boolean,
			default: false,
		},
	},

	mounted() {
		// Setup accordion.
		jQuery('.sui-accordion').each(function () {
			SUI.suiAccordion(this)
		})

		// Init clipboard JS.
		new ClipboardJS('.beehive-copy-shortcode')
	},

	computed: {
		/**
		 * Get the action object data.
		 *
		 * @since 1.8.0
		 *
		 * @return {*}
		 */
		getAction() {
			return {
				id: this.playlist,
				action: this.action,
			}
		},

		/**
		 * Get the playlist list from Vuex.
		 *
		 * We us this computed method to sort the
		 * playlists in order.
		 *
		 * @since 1.8.3
		 *
		 * @return {object}
		 */
		getPlaylists() {
			let playlists = []
			// Get vuex data.
			let storePlaylists = this.$store.state.playlists.playlists
			let storeFiltered = this.$store.state.playlists.filtered

			// Only if it's array.
			if (Array.isArray(storeFiltered)) {
				storeFiltered.forEach(function (id) {
					if (storePlaylists[id]) {
						playlists.push(storePlaylists[id])
					}
				})
			}

			return playlists
		},
	},

	methods: {
		/**
		 * Emit the delete modal open event.
		 *
		 * @since 1.8.0
		 */
		openBulkDeleteForm() {
			this.$root.$emit('openPlaylistBulkDeleteFormModal', {
				playlist: 0,
				focus: 'wpmudev-videos-playlist-item-' + 0,
			})
		},

		/**
		 * Handle order change of the playlist.
		 *
		 * @param {object} event Event
		 *
		 * @since 1.8.4
		 */
		orderChange(event) {
			// Get moved playlist ID.
			let playlist = event.item.getAttribute('data-id')

			if (playlist > 0 && event.oldIndex !== event.newIndex) {
				restGet({
					path: 'playlists/reorder',
					params: {
						playlist: playlist,
						from: event.oldIndex,
						to: event.newIndex,
					},
				}).then((response) => {
					//window.console.log(response)
				})
			}
		},
	},
}
</script>
