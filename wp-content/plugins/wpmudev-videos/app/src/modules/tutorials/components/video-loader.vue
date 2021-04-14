<template>
	<div class="wpmudev-videos-loader--block">
		<div class="wpmudev-videos-loader--title"></div>

		<div class="wpmudev-videos-loader--description"></div>

		<div class="wpmudev-videos-loader--videos">
			<video-loader-item />
			<video-loader-item />
			<video-loader-item />
			<video-loader-item />
		</div>
	</div>
</template>

<script>
import VideoLoaderItem from './video-loader-item'

export default {
	name: 'VideoLoader',

	components: { VideoLoaderItem },
}
</script>
