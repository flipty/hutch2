<template>
	<div class="sui-box">
		<div class="sui-box-header">
			<h3 class="sui-box-title">
				<sui-icon icon="playlist" class="wpmudev-videos-custom-icon" />
				{{ $i18n.dashboard.titles.playlists }}
			</h3>
		</div>

		<div class="sui-box-body">
			<p>{{ $i18n.dashboard.descriptions.playlists }}</p>

			<p v-if="!hasPlaylists">
				<a
					role="button"
					class="sui-button sui-button-blue"
					:href="$vars.urls.playlists + '#/create'"
				>
					<sui-icon icon="plus" />
					{{ $i18n.dashboard.buttons.add_playlist }}
				</a>
			</p>
		</div>

		<table
			class="sui-table sui-table-flushed wpmudev-videos-box-table"
			v-if="hasPlaylists"
		>
			<thead>
				<tr>
					<th class="wpmudev-videos-row--name">
						{{ $i18n.dashboard.labels.recently_added_playlists }}
					</th>
					<th class="wpmudev-videos-row--options">
						<span class="sui-screen-reader-text">
							{{ $i18n.dashboard.labels.playlists_options_menu }}
						</span>
					</th>
				</tr>
			</thead>

			<tbody>
				<tr v-for="playlist in getPlaylists" :key="playlist.id">
					<td class="sui-table-item-title wpmudev-videos-row--name">
						<div class="wpmudev-videos-name-wrapper">
							<list-thumb
								:thumb="playlist.thumbnail"
								:hide-icon="true"
								class="playlist-thumb"
							/>
							<a
								:href="`${$vars.urls.playlists}#/edit/${playlist.id}`"
							>
								{{ playlist.title }}
							</a>
						</div>
					</td>

					<td class="wpmudev-videos-row--options">
						<div class="sui-dropdown">
							<button
								class="sui-button-icon sui-dropdown-anchor"
								:aria-label="$i18n.dashboard.labels.actions"
							>
								<sui-icon icon="widget-settings-config" />
							</button>
							<ul>
								<li>
									<a
										:href="`${$vars.urls.playlists}#/edit/${playlist.id}`"
									>
										<sui-icon icon="pencil" />
										{{ $i18n.buttons.edit }}
									</a>
								</li>
								<li>
									<a
										:href="`${$vars.urls.playlists}#/videos/${playlist.id}`"
									>
										<sui-icon icon="align-justify" />
										{{ $i18n.dashboard.buttons.add_videos }}
									</a>
								</li>
								<li>
									<a
										:href="`${$vars.urls.playlists}#/settings/${playlist.id}`"
									>
										<sui-icon
											icon="widget-settings-config"
										/>
										{{
											$i18n.dashboard.buttons
												.visibility_settings
										}}
									</a>
								</li>
								<li>
									<button
										class="beehive-copy-shortcode"
										@click="copiedNotice"
										:data-clipboard-text="
											getShortCode(playlist)
										"
									>
										<sui-icon icon="code" />
										{{
											$i18n.dashboard.buttons
												.copy_shortcode
										}}
									</button>
								</li>
								<li v-if="playlist.playlist_type === 'custom'">
									<a
										:href="`${$vars.urls.playlists}#/delete/${playlist.id}`"
										class="wpmudev-videos-red"
									>
										<sui-icon icon="trash" />
										{{ $i18n.buttons.delete }}
									</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="sui-box-footer" v-if="hasPlaylists">
			<a
				role="button"
				class="sui-button sui-button-blue"
				:href="$vars.urls.playlists + '#/create'"
			>
				<sui-icon icon="plus" />
				{{ $i18n.dashboard.buttons.add_playlist }}
			</a>

			<div class="sui-actions-right">
				<a
					role="button"
					class="sui-button sui-button-ghost"
					:href="$vars.urls.playlists"
				>
					<sui-icon icon="eye" />
					{{ $i18n.dashboard.buttons.view_all }}
				</a>
			</div>
		</div>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import ListThumb from '@/components/elements/list-thumb'

export default {
	name: 'Playlists',

	components: { SuiIcon, ListThumb },

	/**
	 * On page render, get the list of playlists
	 * and store them in Vuex.
	 *
	 * @since 1.8.0
	 *
	 * @return {Promise<void>}
	 */
	created() {
		this.$store.dispatch('playlists/init', {
			count: 5,
		})
	},

	computed: {
		/**
		 * Get the playlist list from Vuex.
		 *
		 * We us this computed method to sort the
		 * latest playlist first.
		 *
		 * @since 1.8.3
		 *
		 * @return {object}
		 */
		getPlaylists() {
			// Get the playlists.
			let playlists = this.$store.state.playlists.playlists
			// Init empty array.
			let sorted = []

			Object.keys(playlists)
				.sort() // Sort.
				.reverse() // Reverse the order.
				.forEach(function (id) {
					sorted.push(playlists[id])
				})

			return sorted
		},

		/**
		 * Check if we have playlists available.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		hasPlaylists() {
			return this.getPlaylists.length > 0
		},
	},

	methods: {
		/**
		 * Get shortcode for the video.
		 *
		 * @since 1.8.0
		 *
		 * @return {string}
		 */
		getShortCode(playlist) {
			return '[wpmudev_video_group group="' + playlist.slug + '"]'
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
	},
}
</script>
