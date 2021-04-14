<template>
	<fragment>
		<div class="sui-header">
			<h1 class="sui-header-title">{{ title }}</h1>

			<div class="sui-actions-left" v-if="actionsLeft">
				<slot name="actions-left"></slot>
			</div>

			<div class="sui-actions-right" v-if="actionsRight">
				<slot name="actions-right"></slot>

				<a
					v-if="showDocumentation"
					class="sui-button sui-button-ghost"
					href="https://premium.wpmudev.org/docs/wpmu-dev-plugins/integrated-video-tutorials/"
					target="_blank"
				>
					<sui-icon icon="academy" />
					{{ $i18n.header.doc }}
				</a>
			</div>
		</div>

		<!-- Dynamic admin top notices-->
		<div class="sui-floating-notices">
			<top-notice v-if="showTopNotice"></top-notice>
		</div>
	</fragment>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'
import TopNotice from '@/components/elements/top-notice'

export default {
	name: 'SuiHeader',

	components: { TopNotice, SuiIcon },

	props: {
		title: {
			type: String,
			required: true,
		},
		showDocLink: {
			type: Boolean,
			default: true,
		},
		showTopNotice: {
			type: Boolean,
			default: true,
		},
		actionsRight: {
			type: Boolean,
			default: true,
		},
		actionsLeft: {
			type: Boolean,
			default: false,
		},
	},

	computed: {
		/**
		 * Check if we need to show documentation button.
		 *
		 * @since 1.8.0
		 *
		 * @returns {boolean}
		 */
		showDocumentation() {
			return this.showDocLink && !this.$vars.whitelabel.hide_doc_link
		},
	},
}
</script>
