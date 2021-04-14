<template>
	<div class="sui-wrap">
		<!-- Videos grid -->
		<router-view :loading="loading" />
		<!-- Videos end -->
		<sui-footer />
	</div>
</template>

<script>
import SuiHeader from '@/components/sui/sui-header'
import SuiFooter from '@/components/sui/sui-footer'

export default {
	name: 'Main',

	components: { SuiHeader, SuiFooter },

	data() {
		return {
			loading: false,
		}
	},

	/**
	 * On page render, get the list of videos
	 * and playlist and store them in Vuex.
	 *
	 * @since 1.8.0
	 *
	 * @return {Promise<void>}
	 */
	async mounted() {
		this.loading = true

		// Update the data.
		await this.$store.dispatch('videos/init')
		await this.$store.dispatch('playlists/init')

		this.loading = false
	},
}
</script>

<style lang="scss">
@import 'styles/main';
</style>
