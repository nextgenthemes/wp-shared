<script lang="ts">
	import { options, data } from "./store";
	const { settings, sections } = data;
	import { onMount } from 'svelte';
	import Setting from "./Setting.svelte";
	import Dialog from "./Dialog.svelte";

	const domParser = new DOMParser;
	const { log, warn } = console;

	let showModal;
	let displayHelp = false;

	function processUrl( urlOrEmbedCode ) {

		const iframe = domParser.parseFromString( urlOrEmbedCode, 'text/html' ).querySelector( 'iframe' );

		if ( iframe && iframe.getAttribute( 'src' ) ) {
			$options['url'] = iframe.src;
			const { width, height } = iframe;
			if ( width && height ) {
				$options['aspect_ratio'] = aspectRatio( width, height );
			}

			return iframe.src;
		}

		return urlOrEmbedCode;
	}

	function aspectRatio( w, h ) {
		const arGCD = gcd( w, h );

		return w / arGCD + ':' + h / arGCD;
	}

	function gcd( a, b ) {
		if ( ! b ) {
			return a;
		}

		return gcd( b, a % b );
	}

	function uploadImage( optionKey ) {

		const image = window.wp
			.media( {
				title: 'Upload Image',
				multiple: false,
			} )
			.open()
			.on( 'select', function () {
				// This will return the selected image from the Media Uploader, the result is an object
				const uploadedImage = image.state().get( 'selection' ).first();
				// We convert uploadedImage to a JSON object to make accessing it easier
				const attachmentID = uploadedImage.toJSON().id;
				$options[ optionKey ] = attachmentID;
			} );
	}

	$: $options['url'] = processUrl($options['url']);
</script>

<button type="button" on:click|preventDefault={() => (showModal = true)}
	id="arve-btn"
	class="arve-btn button add_media"
	title="ARVE Advanced Responsive Video Embedder"
>
	<span class="wp-media-buttons-icon arve-icon"></span> Video (ARVE)
</button>

<Dialog bind:showModal>
	
	<div class="inputs">

		<div class="help-wrap">
			<button class="button-secondary button-secondary--help" on:click|preventDefault={ () => { displayHelp = !displayHelp } }>
				Help
			</button>
		</div>
		
		<div class="option-grid">

			{#each Object.keys($options) as optionKey }
		
				<Setting {optionKey} {showModal} {displayHelp} />

			{/each}

		</div>

		<!-- <p>{JSON.stringify($options, 0, 2)}</p> -->
	</div>

	<div class="shortcode-preview">

		[arve 
		{#each Object.entries($options) as [ optionKey, optionValue ] }
			{#if optionValue}
				{optionKey}="{optionValue}"
			{/if}
		{/each}/]

	</div>
</Dialog>

<style lang="scss">

	.arve-btn {
		padding-left: 3px;
	}

	.help-wrap {
		text-align: end;
	}

	.inputs {
		container-type: inline-size;
		padding-left: 10px;
		padding-right: 10px;
		overflow-x: hidden;
		overflow-y: auto;
		position: relative;
		background:
			/* Shadow covers */
			linear-gradient(white 30%, rgba(255,255,255,0)),
			linear-gradient(rgba(255,255,255,0), white 70%) 0 100%,

			/* Shadows */
			radial-gradient(farthest-side at 50% 0, rgba(0,0,0,.2), rgba(0,0,0,0)),
			radial-gradient(farthest-side at 50% 100%, rgba(0,0,0,.2), rgba(0,0,0,0)) 0 100%;
		background:
			/* Shadow covers */
			linear-gradient(white 30%, rgba(255,255,255,0)),
			linear-gradient(rgba(255,255,255,0), white 70%) 0 100%,

			/* Shadows */
			radial-gradient(farthest-side at 50% 0, rgba(0,0,0,.2), rgba(0,0,0,0)),
			radial-gradient(farthest-side at 50% 100%, rgba(0,0,0,.2), rgba(0,0,0,0)) 0 100%;
		background-repeat: no-repeat;
		background-color: white;
		background-size: 100% 40px, 100% 40px, 100% 14px, 100% 14px;

		/* Opera doesn't support this in the shorthand */
		background-attachment: local, local, scroll, scroll;
	}

	@container (min-width: 700px) {
		.option-grid {
			display: grid;
			grid-template-columns: minmax(0,50%) minmax(0,50%);
			column-gap: .5em;
		}
	}

	.shortcode-preview {
		margin: 10px;
		font-family: monospace;
	}

	[hidden] {
		display: none !important;
	}
</style>

