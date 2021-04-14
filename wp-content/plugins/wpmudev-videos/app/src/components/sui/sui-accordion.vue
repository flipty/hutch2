<template>
	<div class="sui-accordion sui-accordion-block" ref="accordion">
		<slot></slot>
	</div>
</template>

<script>
export default {
	name: 'SuiAccordion',

	mounted() {
		// Intialize accordion.
		SUI.suiAccordion(this.$refs.accordion)
	},
}
</script>
