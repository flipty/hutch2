<template>
	<fragment>
		<span class="sui-field-prefix">
			<label :for="`${form}-video-start`" class="sui-checkbox">
				<input
					v-model="startEnable"
					type="checkbox"
					:id="`${form}-video-start`"
					:aria-labelledby="`${form}-video-start-label`"
				/>
				<span aria-hidden="true"></span>
				<span :id="`${form}-video-start-label`">
					{{ $i18n.videos.labels.start_at }}
				</span>
			</label>
		</span>

		<input
			placeholder="00:00"
			class="sui-form-control sui-input-sm sui-field-has-prefix"
			:disabled="!startEnable"
			v-model.lazy="startTime"
		/>
	</fragment>
</template>

<script>
export default {
	name: 'VideoStartTime',

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
		 * Video start flag model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		startEnable: {
			get() {
				return this.video.start_enabled
			},

			set(enabled) {
				let video = this.video

				video.start_enabled = enabled ? 1 : 0

				// Emit video update event.
				this.$emit('update:video', video)

				// Emit video url update event.
				this.$root.$emit('syncUrlEmbed', {
					form: this.form,
				})
			},
		},

		/**
		 * Video start time option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		startTime: {
			get() {
				return this.video.start_time
			},

			set(start_time) {
				let video = this.video

				video.start_time = start_time

				// Emit video update event.
				this.$emit('update:video', video)

				// Emit video url update event.
				this.$root.$emit('syncUrlEmbed', {
					form: this.form,
				})
			},
		},
	},
}
</script>
