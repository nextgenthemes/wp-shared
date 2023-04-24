import { writable } from 'svelte/store';

declare global {
	interface Window {
		wp;
		jQuery;
		ngtSettingsTestData;
	}
}
const url = new URL( window.location.href );
const pageQueryVal = url.searchParams.get( 'page' );

if ( ! pageQueryVal ) {
	throw 'Need page url arg';
}

export const data = window[ pageQueryVal ] as InlineJsSettingsPage;
export const options = writable( data.options );
export const isSaving = writable( false );
export const message = writable( '' );
