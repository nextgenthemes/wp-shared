<script lang="ts">
	import { data } from "./store";
	const { settings, sections, premiumSections, premiumUrlPrefix } = data;

	const { log } = console;

	export let optionKey;
	const type = settings[optionKey].type;
	const label = settings[optionKey].label;
	const tag = settings[optionKey].tag;
	const sectionLabel = sections[ settings[optionKey].tag ];

	let premiumURL;

	setPremiumURL();

	function setPremiumURL() {
		if ( premiumSections.includes( tag ) ) {
			premiumURL = premiumUrlPrefix + tag;
		}
	}

</script>

<span class="ngt-label-text ngt-label-text--{type}">
	{label}
	{#if premiumURL}
		 <span>(</span><a href={premiumURL}>{sectionLabel}</a><span>)</span>
	{/if}
</span>

<style lang="scss">

	.ngt-label-text {
		display: block;
		margin-bottom: 3px;
		font-weight: 600;

		span {
			opacity: .5;
		}
	}

	.ngt-label-text--boolean {
		display: inline;
	}
</style>
