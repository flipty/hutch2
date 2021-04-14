<template>
	<div class="sui-box-selectors sui-box-selectors-col-2">
		<ul>
			<li v-for="(data, key) in hosts" :key="key">
				<label
					:for="`${form}-video-host-${key}`"
					class="sui-box-selector"
				>
					<input
						type="radio"
						:id="`${form}-video-host-${key}`"
						:name="`${form}-video-host-${key}`"
						:value="key"
						v-model="host"
					/>
					<span>
						<i
							v-if="data.icon"
							:class="data.icon"
							aria-hidden="true"
						></i>
						{{ data.name }}
					</span>
				</label>
			</li>
		</ul>
	</div>
</template>

<script>
export default {
	name: 'VideoHost',

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

	data() {
		return {
			hosts: this.$moduleVars.hosts,
		}
	},

	computed: {
		/**
		 * Video host option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {string}
		 */
		host: {
			get() {
				return this.video.host
			},

			set(host) {
				let video = this.video

				video.host = host

				// Emit video update event.
				this.$emit('update:video', video)
			},
		},
	},
}
</script>
