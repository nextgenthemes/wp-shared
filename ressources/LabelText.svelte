<script lang="ts">
	import { options, settings, sections, restURL, nonce } from "./store";
	const { log } = console;

	export let optionKey;
	const type = settings[optionKey].type;
	const label = settings[optionKey].label;
	const tag = settings[optionKey].tag;

	const premiumUrlPrefix = 'https://nextgenthemes.com/plugins/arve-';
	const sectionLabel = sections[ settings[optionKey].tag ];
</script>

<span class="ngt-label-text ngt-label-text--{type}">
	{label}
	{#if premiumUrlPrefix}
		 <span>(</span><a href={premiumUrlPrefix + tag}>{sectionLabel}</a><span>)</span>
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
