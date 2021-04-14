<template>
	<fragment>
		<span class="sui-field-prefix">
			<label :for="`${form}-video-end`" class="sui-checkbox">
				<input
					v-model="endEnable"
					type="checkbox"
					:id="`${form}-video-end`"
					:aria-labelledby="`${form}-video-end-label`"
				/>
				<span aria-hidden="true"></span>
				<span :id="`${form}-video-end-label`">
					{{ $i18n.videos.labels.end_at }}
				</span>
			</label>
		</span>

		<input
			placeholder="00:00"
			class="sui-form-control sui-input-sm sui-field-has-prefix"
			:disabled="!endEnable"
			v-model.lazy="endTime"
		/>
	</fragment>
</template>

<script>
export default {
	name: 'VideoEndTime',

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
		 * Video end flag model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		endEnable: {
			get() {
				return this.video.end_enabled
			},

			set(enabled) {
				let video = this.video

				video.end_enabled = enabled ? 1 : 0

				// Emit video update event.
				this.$emit('update:video', video)

				// Emit video url update event.
				this.$root.$emit('syncUrlEmbed', {
					form: this.form,
				})
			},
		},

		/**
		 * Video end time option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		endTime: {
			get() {
				return this.video.end_time
			},

			set(end_time) {
				let video = this.video

				video.end_time = end_time

				// Emit video update event.
				this.$emit('update:video', video)

				// Emit the video url sync event.
				this.$root.$emit('syncUrlEmbed', {
					form: this.form,
				})
			},
		},
	},
}
</script>
