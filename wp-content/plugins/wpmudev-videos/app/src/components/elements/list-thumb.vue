<template>
	<span
		class="wpmudev-videos-list-thumb"
		aria-hidden="true"
		:data-icon="getIcon"
		:style="getStyle"
		:class="getClass"
		v-if="tag === 'span'"
	></span>
	<div
		class="wpmudev-videos-list-thumb"
		aria-hidden="true"
		:data-icon="getIcon"
		:style="getStyle"
		:class="getClass"
		v-else
	></div>
</template>

<script>
export default {
	name: 'ListThumb',

	props: {
		thumb: {
			type: Object | Array,
			required: true,
		},
		isCustom: {
			type: Boolean,
			default: false,
		},
		icon: {
			type: String,
			default: 'custom',
		},
		hideIcon: {
			type: Boolean,
			default: false,
		},
		tag: {
			type: String,
			default: 'div',
		},
	},

	computed: {
		/**
		 * Check if current video has thumbnail.
		 *
		 * @since 1.8.0
		 *
		 * @return {boolean}
		 */
		hasThumb() {
			return this.thumb.url && '' !== this.thumb.url
		},

		/**
		 * Get the style to set the custom thumb.
		 *
		 * If thumb url is empty, we don't have to
		 * set the styles.
		 *
		 * @since 1.8.0
		 *
		 * @return {object}
		 */
		getStyle() {
			if (this.hasThumb) {
				return {
					'background-image': 'url(' + this.thumb.url + ')',
				}
			}
		},

		/**
		 * Get the classes dynamically.
		 *
		 * For default videos we need dashicons class.
		 * For custom videos without thumb also we need
		 * dashicons class.
		 *
		 * @since 1.8.0
		 *
		 * @return {object}
		 */
		getClass() {
			return {
				dashicons: (!this.isCustom || !this.hasThumb) && !this.hideIcon,
			}
		},

		/**
		 * Get the icon for the thumb.
		 *
		 * If custom video, we need to use custom icon
		 * if the thumb is empty.
		 *
		 * @since 1.8.0
		 *
		 * @return {string}
		 */
		getIcon() {
			if (this.isCustom && !this.hasThumb) {
				return 'custom'
			} else if (!this.isCustom) {
				return this.icon
			} else {
				return false
			}
		},
	},
}
</script>
