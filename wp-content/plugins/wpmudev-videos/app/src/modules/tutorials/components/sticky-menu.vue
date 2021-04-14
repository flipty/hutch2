<template>
	<div
		role="navigation"
		aria-labelledby="wpmudev-videos-navigation--label"
		aria-hidden="true"
		ref="stickyMenu"
		:class="mainClass"
	>
		<div class="wpmudev-videos-section--menu-nav">
			<button
				class="prev"
				:disabled="disableRight"
				@click="slideMenu(-20)"
			>
				<sui-icon icon="chevron-left" size="sm" />
			</button>

			<button class="next" :disabled="disableLeft" @click="slideMenu(20)">
				<sui-icon icon="chevron-right" size="sm" />
			</button>
		</div>

		<ul role="menu" class="wpmudev-videos-section--menu" ref="menuParent">
			<li role="none" v-for="playlist in playlists" :key="playlist.id">
				<a
					role="menuitem"
					:class="2 === playlist.id ? 'active' : ''"
					v-on:click="goToSection(playlist.id, $event)"
				>
					{{ playlist.title }}
				</a>
			</li>
		</ul>
	</div>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'StickyMenu',

	props: {
		playlists: {
			type: Object,
			default: {},
		},
	},

	components: { SuiIcon },

	data() {
		return {
			sticky: false,
			disableLeft: false,
			disableRight: true,
		}
	},

	mounted() {
		// Update arrows.
		this.updateArrows()

		// Handle scroll event.
		window.addEventListener('scroll', this.handleScroll)
		// Handle resize event.
		window.addEventListener('resize', this.updateArrows)
	},

	beforeDestroy() {
		// Remove event listener.
		window.removeEventListener('scroll', this.handleScroll)
		// Remove resize event.
		window.removeEventListener('resize', this.updateArrows)
	},

	computed: {
		/**
		 * Get the element class based on the flag.
		 *
		 * @since 1.8.0
		 *
		 * @returns {*}
		 */
		mainClass() {
			return {
				'wpmudev-videos-section--menu-group': true,
				'wpmudev-videos-sticky': this.sticky,
			}
		},

		/**
		 * Get the offset position of the menu.
		 *
		 * @since 1.8.0
		 *
		 * @returns int
		 */
		offsetTop() {
			// Menu element.
			let menu = this.$refs.stickyMenu

			let rect = menu.getBoundingClientRect()
			let scrollTop =
				window.pageYOffset || document.documentElement.scrollTop

			return rect.top + scrollTop
		},
	},

	methods: {
		/**
		 * Slide menu elements to new position.
		 *
		 * We slide 30px on each click.
		 *
		 * @param {int} offset Slide position value.
		 *
		 * @since 1.8.4
		 */
		slideMenu(offset) {
			// Menu element.
			let el = this.$refs.menuParent

			// Scroll.
			el.scroll({
				left: el.scrollLeft + offset,
				behavior: 'auto',
			})

			// Update the arrows.
			this.updateArrows()
		},

		/**
		 * Update navigation arrows when required.
		 *
		 * Call then when widnow is resized, items changed.
		 *
		 * @since 1.8.4
		 */
		updateArrows() {
			// Menu element.
			let el = this.$refs.menuParent
			let maxScroll = el.scrollWidth - el.clientWidth

			this.disableRight = el.scrollLeft <= 0
			this.disableLeft = el.scrollLeft >= maxScroll
		},

		/**
		 * Handle the window scroll event.
		 *
		 * Check if we need to apply sticky class.
		 *
		 * @since 1.8.0
		 */
		handleScroll() {
			// When the page offset is higher than menu.
			this.sticky = window.pageYOffset > this.offsetTop
		},

		/**
		 * Get offset of the element.
		 *
		 * @param {object} el Element.
		 *
		 * @since 1.8.0
		 *
		 * @return {*}
		 */
		getElementOffset(el) {
			let top = 0
			let left = 0
			let element = document.getElementById(el)

			do {
				top += element.offsetTop || 0
				left += element.offsetLeft || 0
				element = element.offsetParent
			} while (element)

			return {
				top,
				left,
			}
		},

		/**
		 * Scroll to a section in the page.
		 *
		 * @param {string} id Element ID.
		 * @param {object} event Event.
		 *
		 * @since 1.8.0
		 */
		goToSection(id, event) {
			let blockId = 'section-playlist-' + id
			let blockPos = this.getElementOffset(blockId)
			let floatNav = 120

			window.scrollTo({
				top: blockPos.top - floatNav,
				left: 0,
				behavior: 'smooth',
			})

			let i
			let navEl = event.target
			let navLi = navEl.parentElement.parentElement.querySelectorAll(
				'li > a'
			)

			for (i = 0; i < navLi.length; ++i) {
				if (navLi[i].classList.contains('active')) {
					navLi[i].classList.remove('active')
				}
			}

			navEl.classList.add('active')

			event.preventDefault()
		},
	},
}
</script>
