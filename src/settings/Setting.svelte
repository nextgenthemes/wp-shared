<script lang="ts">
	import { options, data, message } from "./store";
	const { settings, restUrl, nonce, definedKeys } = data;
	import LabelText from './LabelText.svelte';
	const { log } = console;

	export let optionKey;
	const description = settings[optionKey].description;
	const type = settings[optionKey].type;
	const ui = settings[optionKey].ui;

	const selectOptions = settings[optionKey].options;

	let isSaving = false;
	let textInputTimeout;

	function debouncedSaveOptions() {
		if (textInputTimeout) {
			clearTimeout(textInputTimeout)
		}
		textInputTimeout = setTimeout(saveOptions, 350)
	}

	function saveOptions( refreshAfterSave: boolean = false ) {

		if ( isSaving ) {
			$message = 'trying to save too fast';
			return;
		}

		// set the state so that another save cannot happen while processing
		isSaving = true;

		$message = 'Saving...';

		// Make a POST request to the REST API route that we registered in our PHP file
		window.jQuery.ajax( {
			url: restUrl + '/save',
			method: 'POST',
			data: $options,

			// set the nonce in the request header
			beforeSend( request ) {
				request.setRequestHeader( 'X-WP-Nonce', nonce );
			},

			// callback to run upon successful completion of our request
			success: () => {
				$message = 'Options saved';
				setTimeout( () => ( $message = '' ), 1000 );
			},

			// callback to run if our request caused an error
			error: ( errorData ) => {
				$message = errorData.responseText;
				refreshAfterSave = false;
			},

			// when our request is complete (successful or not), reset the state to indicate we are no longer saving
			complete: () => {
				isSaving = false;

				if ( refreshAfterSave ) {
					refreshAfterSave = false;
					window.location.reload();
				}
			},
		} );
	}

	function licenseKeyAction( action, product ) {
		$options['action'] = JSON.stringify( { action, product } );
		saveOptions( true );
	}

</script>

{#if 'hidden' !== ui}
	<div>
		<p>
			{#if 'license-key' === ui}
				<label>
					<LabelText {optionKey} />

					<input disabled={ definedKeys.includes( optionKey ) } type="text" class="medium-text medium-text--license-key" bind:value={$options[optionKey]} on:input={ () => { debouncedSaveOptions() }} />

					<button on:click={ () => { licenseKeyAction( 'activate', optionKey ) } } class="button button-secondary">Activate</button>
					<button on:click={ () => { licenseKeyAction( 'deactivate', optionKey ) } } class="button button-secondary">Deactivate</button>

					<div>
						Key Status: {$options[optionKey + '_status']}
					</div>
				</label>

			{:else if 'string' === type}

				<label>
					<LabelText {optionKey} />
					<input type="text" class="large-text" bind:value={$options[optionKey]} on:input={ () => { debouncedSaveOptions() }} />
				</label>

			{:else if 'boolean' === type}

				<label>
					<input type="checkbox" bind:checked={$options[optionKey]} on:change={ () => { saveOptions() }}>
					<LabelText {optionKey} />
				</label>

			{:else if 'select' === type}

				<label>
					<LabelText {optionKey} />
					<select bind:value={$options[optionKey]} on:change={ () => { saveOptions() }}>
						{#each Object.entries(settings[optionKey].options) as [ selectKey, selectLabel ] }
							<option value={selectKey}>
								{selectLabel}
							</option>
						{/each}
					</select>
				</label>

			{:else if 'integer' === type}

				<label>
					<LabelText {optionKey} />
					<input type="number" bind:value={$options[optionKey]} on:input={ () => { debouncedSaveOptions() }} />
				</label>

			{:else}

				<h3>Error: {type} not implemented</h3>

			{/if}

		</p>
		{#if description }
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
