<template>
	<fragment>
		<div class="sui-footer" v-html="$vars.whitelabel.footer_text"></div>
		<ul v-if="!$vars.whitelabel.hide_branding" class="sui-footer-nav">
			<li>
				<a href="https://premium.wpmudev.org/hub/" target="_blank">
					{{ $i18n.footer.hub }}
				</a>
			</li>
			<li>
				<a
					href="https://premium.wpmudev.org/projects/category/plugins/"
					target="_blank"
				>
					{{ $i18n.footer.plugins }}
				</a>
			</li>
			<li>
				<a href="https://premium.wpmudev.org/roadmap/" target="_blank">
					{{ $i18n.footer.roadmap }}
				</a>
			</li>
			<li>
				<a
					href="https://premium.wpmudev.org/hub/support/"
					target="_blank"
				>
					{{ $i18n.footer.support }}
				</a>
			</li>
			<li>
				<a href="https://premium.wpmudev.org/docs/" target="_blank">
					{{ $i18n.footer.docs }}
				</a>
			</li>
			<li>
				<a
					href="https://premium.wpmudev.org/hub/community/"
					target="_blank"
				>
					{{ $i18n.footer.community }}
				</a>
			</li>
			<li>
				<a href="https://premium.wpmudev.org/academy/" target="_blank">
					{{ $i18n.footer.academy }}
				</a>
			</li>
			<li>
				<a
					href="https://premium.wpmudev.org/terms-of-service/"
					target="_blank"
				>
					{{ $i18n.footer.tos }}
				</a>
			</li>
			<li>
				<a href="https://incsub.com/privacy-policy/" target="_blank">
					{{ $i18n.footer.privacy }}
				</a>
			</li>
		</ul>
		<ul v-if="!$vars.whitelabel.hide_branding" class="sui-footer-social">
			<li>
				<a href="https://www.facebook.com/wpmudev" target="_blank">
					<sui-icon icon="social-facebook" />
					<span class="sui-screen-reader-text">
						{{ $i18n.footer.facebook }}
					</span>
				</a>
			</li>
			<li>
				<a href="https://twitter.com/wpmudev" target="_blank">
					<sui-icon icon="social-twitter" />
					<span class="sui-screen-reader-text">
						{{ $i18n.footer.twitter }}
					</span>
				</a>
			</li>
			<li>
				<a href="https://www.instagram.com/wpmu_dev/" target="_blank">
					<sui-icon icon="instagram" />
					<span class="sui-screen-reader-text">
						{{ $i18n.footer.instagram }}
					</span>
				</a>
			</li>
		</ul>
	</fragment>
</template>

<script>
import SuiIcon from '@/components/sui/sui-icon'

export default {
	name: 'SuiFooter',

	components: { SuiIcon },
}
</script>
