<script lang="ts">
	export let showModal; // boolean
	let dialog: HTMLDialogElement;

	function insertShortcode() {
		const preview = document.querySelector( '.shortcode-preview' );
		const text = preview.textContent.replace(/\s\s+/g, ' ').trim();

		window.wp.media.editor.insert( text );
		dialog.close();
	}

	$: if (dialog && showModal) {
		dialog.showModal();
	}
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<dialog
	bind:this={dialog}
	on:close={() => (showModal = false)}
	on:click|self={() => dialog.close()}
>
	<div on:click|stopPropagation class="grid">
		<slot />
		<div>
			<!-- svelte-ignore a11y-autofocus -->
			<button class="buttom-secondary" autofocus on:click={() => dialog.close()}>Cancel</button>
			<!-- svelte-ignore a11y-autofocus -->
			<button class="buttom-primary" autofocus on:click={() => insertShortcode()}>Insert Shortcode</button>
		</div>
	</div>
</dialog>

<style lang="scss">
	dialog {
		height: 99vh;
		max-width: 900px;
		width: 100vw;
		border-radius: 5px;
		border: 1px solid red;
		box-sizing: border-box;
		padding: 0;

		*,
		*:before,
		*:after {
			box-sizing: inherit;
		}

		&::backdrop {
			background-color: rgba(0, 0, 0, .8);
		}

		&[open] {
			animation: zoom .4s cubic-bezier(0.34, 1.56, 0.64, 1);

			&::backdrop {
				animation: fade .4s ease-out;
			}
		}

		&:not([open]) {
			display: none;
		}
	}

	.grid {
		height: 100%;
		display: grid;
		grid-template-columns: minmax(300px, 1fr);
		grid-template-rows:
			1fr
			auto
			auto;
		grid-template-areas:
			"."
			"."
			".";
		gap: 0px 0px;

		@media (min-width: 900px) {
			padding: 2rem;
		}
	}

	@keyframes zoom {
		from {
			transform: scale(0.8);
		}
		to {
			transform: scale(1);
		}
	}

	@keyframes fade {
		from {
			opacity: 0;
		}
		to {
			opacity: 1;
		}
	}

	button {
		display: block;
	}
</style>
