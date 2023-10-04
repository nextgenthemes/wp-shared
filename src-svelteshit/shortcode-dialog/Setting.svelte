<script lang="ts">
	import { options, data } from "./store";
	const { settings, sections, premiumSections, premiumUrlPrefix } = data;

	import LabelText from '../shared/LabelText.svelte';
	const { log } = console;

	export let showModal: boolean;
	export let optionKey: string;
	export let displayHelp;

	const setting = settings[optionKey];
	const { description, type, ui, tag, placeholder, label } = setting;
	const sectionLabel = sections[ tag ];

	const isBool = ('boolean' == type);

	const span = ('url' == optionKey) || ('description' == optionKey);

	function uploadImage() {
		const image = window.wp 
			.media( {
				title: 'Upload Image',
				multiple: false,
			} )
			.open(  )
			.on( 'select', function () {
				// This will return the selected image from the Media Uploader, the result is an object
				const uploadedImage = image.state().get( 'selection' ).first();
				// We convert uploadedImage to a JSON object to make accessing it easier
				const attachmentID = uploadedImage.toJSON().id;
				$options[ optionKey ] = attachmentID;
			} );
	}
</script>

{#if 'hidden' !== ui}
	<div class="setting-wrap" class:span2="{span}">

		<div class:input-group="{! isBool}">

			<div class:form-floating="{! isBool}" style="position: relative" class:form-check="{false}" class:form-switch="{false}" >

				{#if 'string' === type || 'attachment' === type}
					<input type="text" class="form-control" id="{optionKey}" {placeholder} bind:value={$options[optionKey]} />
				{:else if 'integer' === type}
					<input type="number" class="form-control" id="{optionKey}" {placeholder} bind:value={$options[optionKey]} />
				{:else if 'boolean' === type}
					<input type="checkbox" id="{optionKey}" bind:checked={$options[optionKey]} />
				{:else if 'select' === type}
					<select class="form-control" id="{optionKey}" bind:value={$options[optionKey]}>
						{#each Object.entries(settings[optionKey].options) as [ selectKey, selectLabel ] }
							<option value={selectKey}>
								{selectLabel}
							</option>
						{/each}
					</select>
				{:else}
					<strong>Error: type {type} not implemented</strong>
				{/if}

				<label for="{optionKey}" class:form-check-label="{isBool}">{label}</label>

				{#if premiumSections.includes( tag )}
					<a class="button-primary premium-link" href={premiumUrlPrefix + tag}>{sectionLabel}</a>
				{/if}
			</div>

			{#if 'attachment' === type}
				<button class="button-secondary button-secondary--select-thumbnail" type="button" on:click|preventDefault={() => { uploadImage() }}>Select Image</button>
			{/if}
		</div>

		{#if displayHelp && description }
			<p>
				{@html description}
			</p>
		{/if}
	</div>
{/if}

<style lang="scss">
	input[type="checkbox"] {
		background: none !important;
	}

	select {
		background-position-y: 81% !important;
		max-width: none !important;
	}

	p {
		margin-top: 3px;
		overflow: hidden;
	}

	.button-secondary--select-thumbnail {
		margin-left: 0 !important;
	}

	.setting-wrap {
		margin-bottom: .5rem;
	}

	.span2 {
		grid-column: span 2;
	}

	.form-switch {
		position: relative;
	}

	.premium-link {
		position: absolute;
		top: 0;
		right: 0;
		font-size: .7rem;
		min-height: 0;
	}

	::placeholder {
		transition: color .1s ease-in-out;
	}

	.form-floating > .form-control:focus::placeholder {
		color: rgba(var(--bs-body-color-rgb), 0.65);
	}
</style>
