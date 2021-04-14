<template>
	<div class="sui-box sui-message sui-message-lg">
		<image-tag
			src="message/empty-results.png"
			class="sui-image"
			:alt="$i18n.videos.labels.empty_search"
			v-if="!$vars.whitelabel.hide_branding"
		/>

		<div class="sui-message-content">
			<p
				v-html="sprintf($i18n.videos.descriptions.empty_search, search)"
			></p>
		</div>
	</div>
</template>

<script>
import ImageTag from '@/components/elements/image-tag'

export default {
	name: 'EmptyBox',

	components: { ImageTag },

	props: {
		search: {
			type: String,
			required: true,
		},
	},
}
</script>
