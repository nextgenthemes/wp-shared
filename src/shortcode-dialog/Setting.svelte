<script lang="ts">
	import { options, data } from "./store";
	const { settings, sections, premiumSections, premiumUrlPrefix } = data;

	import LabelText from './LabelText.svelte';
	const { log } = console;

	export let optionKey: string;
	export let displayHelp;

	const setting = settings[optionKey];
	const { description, type, ui, tag } = setting;
	const sectionLabel = sections[ tag ];
</script>

{#if 'hidden' !== ui}
	<div>
		<p> 
			{#if 'url' === optionKey}

				<label>
					<LabelText {setting} {sectionLabel} {premiumSections} {premiumUrlPrefix} />
					<input type="text" class="large-text" bind:value={$options[optionKey]} />
				</label>

			{:else if 'string' === type}

				<label>
					<LabelText {setting} {sectionLabel} {premiumSections} {premiumUrlPrefix} />
					<input type="text" class="large-text" bind:value={$options[optionKey]} />
				</label>

			{:else if 'boolean' === type}

				<label>
					<input type="checkbox" bind:checked={$options[optionKey]} />
					<LabelText {setting} {sectionLabel} {premiumSections} {premiumUrlPrefix} />
				</label>

			{:else if 'select' === type}

				<label>
					<LabelText {setting} {sectionLabel} {premiumSections} {premiumUrlPrefix} />
					<select bind:value={$options[optionKey]}>
						{#each Object.entries(settings[optionKey].options) as [ selectKey, selectLabel ] }
							<option value={selectKey}>
								{selectLabel}
							</option>
						{/each}
					</select>
				</label>

			{:else if 'integer' === type}

				<label>
					<LabelText {setting} {sectionLabel} {premiumSections} {premiumUrlPrefix} />
					<input type="number" bind:value={$options[optionKey]} />
				</label>

			{:else}

				<h3>Error: type {type} not implemented</h3>

			{/if}

		</p>
		{#if displayHelp && description }
			<p>
				{description}
			</p>
		{/if}
		<hr>
	</div>
{/if}

<style lang="scss">
	.medium-text--license-key {
		width: 350px;
	}
</style>
