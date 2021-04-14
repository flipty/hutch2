<template>
	<input
		type="text"
		v-model="title"
		class="sui-form-control"
		:id="`${form}-video-title`"
	/>
</template>

<script>
export default {
	name: 'VideoTitle',

	props: {
		form: {
			type: String,
			required: true,
		},
		video: {
			type: Object,
			required: true,
		},
	},

	computed: {
		/**
		 * Video title option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		title: {
			get() {
				return this.video.title
			},

			set(title) {
				let video = this.video

				video.title = title

				// Emit video update event.
				this.$emit('update:video', video)
			},
		},
	},
}
</script>
