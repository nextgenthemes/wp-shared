<script lang="ts">
	export let setting: OptionProps;
	export let sectionLabel: string;
	export let premiumSections: string[];
	export let premiumUrlPrefix: string;

	const { type, label, tag } = setting;
</script>



<div class="form-floating">
	<input type="text" class="form-control" placeholder="{placeholder}" bind:value={$options[optionKey]} id="{optionKey}" />
	<label for="{optionKey}">
		<LabelText {setting} {sectionLabel} {premiumSections} {premiumUrlPrefix} />
	
	
	</label>
</div>


<span class="label-text label-text--{type}">
	{label}
	{#if premiumSections.includes( tag )}
		 <span>(</span><a href={premiumUrlPrefix + tag}>{sectionLabel}</a><span>)</span>
	{/if}
</span>

<style lang="scss">


</style>
