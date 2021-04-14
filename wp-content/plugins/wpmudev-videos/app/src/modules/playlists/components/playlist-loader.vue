<template>
	<div class="wpmudev-videos-loader sui-box">

		<div class="wpmudev-videos-loader--mask">
			<span class="sui-icon-loader sui-md sui-loading" aria-hidden="true"></span>
			{{ $i18n.playlists.labels.loading }}
		</div>

		<div class="wpmudev-videos-loader--content" aria-hidden="true">

			<div class="wpmudev-videos-loader--checkbox"></div>

			<div class="wpmudev-videos-loader--image"></div>

			<div class="wpmudev-videos-loader--name">
				<span></span>
			</div>

			<div class="wpmudev-videos-loader--actions">

				<div class="sui-button-icon">
					<span class="sui-icon-widget-settings-config" aria-hidden="true"></span>
				</div>

				<div class="sui-button-icon">
					<span class="sui-icon-chevron-down" aria-hidden="true"></span>
				</div>

			</div>

		</div>

	</div>
</template>
