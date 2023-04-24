<script lang="ts">
	export let setting: OptionProps;
	export let sectionLabel: string;
	export let premiumSections: string[];
	export let premiumUrlPrefix: string;

	const { type, label, tag } = setting;

	const { log } = console;

	let premiumURL;

	setPremiumURL();

	function setPremiumURL() {
		if ( premiumSections.includes( tag ) ) {
			premiumURL = premiumUrlPrefix + tag;
		}
	}
</script>

<span class="label-text label-text--{type}">
	{label}
	{#if premiumURL}
		 <span>(</span><a href={premiumURL}>{sectionLabel}</a><span>)</span>
	{/if}
</span>

<style lang="scss">

	.label-text {
		display: block;
		margin-bottom: 3px;
		font-weight: 600;

		span {
			opacity: .5;
		}
	}

	.label-text--boolean {
		display: inline;
	}
</style>
