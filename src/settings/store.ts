import { writable } from 'svelte/store';

declare global {
	interface Window {
		wp;
		jQuery;
	}
}

const url = new URL( window.location.href );
const pageQueryVal = url.searchParams.get( 'page' );

if ( ! pageQueryVal ) {
	throw 'Need page url arg';
}

export const data = window[ pageQueryVal ] as InlineJS;
export const options = writable( data.options );
export const isSaving = writable( false );
export const message = writable( '' );

interface InlineJS {
	settings: Record< string, OptionProps >;
	sections: Record< string, string >;
	options: Record< string, number | string | boolean >;
	nonce: string;
	restUrl: string;
	premiumSections: string[];
	premiumUrlPrefix: string;
	definedKeys: string[];
}

interface OptionProps {
	label: string;
	tag: string;
	type: string;
	default: number | string | boolean;
	description?: string;
	descriptionlink?: string;
	descriptionlinktext?: string;
	placeholder?: string;
	options?: Record< string, string >;
	ui?: string;
}
