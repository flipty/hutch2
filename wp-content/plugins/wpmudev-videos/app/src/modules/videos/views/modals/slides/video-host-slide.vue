<template>
	<div
		class="sui-modal-slide sui-active sui-loaded"
		data-modal-size="lg"
		:id="`${form}-host-selector`"
	>
		<div class="sui-box">
			<div
				class="sui-box-header sui-flatten sui-content-center sui-spacing-top--60 sui-spacing-right--60 sui-spacing-left--60"
			>
				<whitelabel-modal-banner
					src="modal/modal-header-videos.png"
					:alt="$i18n.videos.labels.add_custom_video"
				/>

				<button
					@click="$emit('dismiss')"
					class="sui-button-icon sui-button-float--right"
				>
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text">
						{{ $i18n.dialogs.close }}
					</span>
				</button>

				<h3 :id="`${form}-title`" class="sui-box-title sui-lg">
					{{ $i18n.videos.labels.add_custom_video }}
				</h3>

				<p :id="`${form}-desc`" class="sui-description">
					{{ $i18n.videos.descriptions.add_custom_video }}
				</p>
			</div>

			<video-host :form="form" :video.sync="video" />

			<div class="sui-box-footer sui-flatten sui-content-center">
				<button
					:data-modal-slide="next"
					data-modal-slide-intro="next"
					role="button"
					class="sui-button"
					:disabled="!video.host"
				>
					{{ $i18n.dialogs.continue }}
				</button>
			</div>
		</div>
	</div>
</template>

<script>
import VideoHost from './../../../components/fields/video-host'
import WhitelabelModalBanner from '@/components/elements/whitelabel-modal-banner'

export default {
	name: 'VideoHostSlide',

	components: {
		VideoHost,
		WhitelabelModalBanner,
	},

	props: {
		next: {
			type: String,
			required: true,
		},
		form: {
			type: String,
			required: true,
		},
		video: {
			type: Object,
			required: true,
		},
	},
}
</script>
