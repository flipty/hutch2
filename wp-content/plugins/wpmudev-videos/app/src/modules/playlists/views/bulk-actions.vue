<template>
	<div class="sui-box sui-box-sticky">
		<div class="sui-box-search">
			<label
				for="wpmudev-videos-playlists-bulk-check"
				class="sui-checkbox"
			>
				<input
					type="checkbox"
					id="wpmudev-videos-playlists-bulk-check"
					v-model="selectAll"
					@change="bulkSelect"
				/>
				<span aria-hidden="true"></span>
			</label>

			<sui-select
				v-model="action"
				:options="options"
				:is-small="true"
				class="sui-select-inline"
				id="wpmudev-videos-playlists-bulk-actions"
			/>

			<button
				type="button"
				:class="buttonClass"
				aria-live="polite"
				@click="handleBulkAction"
			>
				<span class="sui-button-text-default">
					<sui-icon icon="check" />
					{{ $i18n.buttons.apply }}
				</span>
				<span class="sui-button-text-onload">
					<sui-icon icon="loader" class="sui-loading" />
					{{ $i18n.buttons.processing }}
				</span>
			</button>
		</div>
	</div>
</template>

<script>
import { mapState } from 'vuex'
import { restPost } from '@/helpers/api'
import SuiIcon from '@/components/sui/sui-icon'
import SuiSelect from '@/components/sui/sui-select'

export default {
	name: 'BulkActions',

	components: { SuiSelect, SuiIcon },

	props: {
		selected: {
			type: Object,
			required: true,
		},
	},

	data() {
		return {
			options: {
				'': this.$i18n.playlists.labels.bulk_actions,
				delete: this.$i18n.buttons.delete,
			},
			action: '',
			processing: false,
			selectAll: false,
		}
	},

	computed: {
		/**
		 * Get button classes.
		 *
		 * Set loading class if processing.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		buttonClass() {
			return {
				'sui-button': true,
				'sui-button-onload-text': this.processing,
			}
		},

		/**
		 * Get the playlist list from Vuex.
		 *
		 * @since 1.8.0
		 *
		 * @return {object}
		 */
		...mapState('playlists', ['playlists']),
	},

	methods: {
		/**
		 * Handle the bulk action click.
		 *
		 * @since 1.8.0
		 */
		async handleBulkAction() {
			// Only when action is set.
			if (this.action === '' || !Object.keys(this.selected).length) {
				return
			}

			this.processing = true

			switch (this.action) {
				case 'delete':
					await this.bulkDelete()
					break
			}

			this.processing = false
		},

		/**
		 * Process bulk deleting the playlist and videos.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		async bulkDelete() {
			await restPost({
				path: 'playlists/bulk-actions',
				data: {
					action: 'delete',
					items: this.selected,
				},
			}).then((response) => {
				if (response.success && response.data) {
					// Update playlists and videos.
					this.$store.dispatch('videos/init')
					this.$store.dispatch('playlists/init')
				}
			})
		},

		/**
		 * Handle the bulk select action.
		 *
		 * @since 1.8.0
		 *
		 * @returns {void}
		 */
		bulkSelect() {
			let selected = {}

			// Get playlists.
			let playlists = this.playlists

			// Only if all selected.
			if (this.selectAll) {
				Object.keys(playlists).forEach(function (id) {
					let playlist = playlists[id]

					// Select both playlist and all videos as selected.
					selected[playlist.id] = {
						selected: true,
						videos: playlist.videos,
					}
				})
			}

			// Emit selected update event.
			this.$emit('update:selected', selected)
		},
	},
}
</script>
