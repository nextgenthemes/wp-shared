import { writable } from 'svelte/store';

declare global {
	interface Window {
		wp;
		jQuery;
		ArveShortcodeDialogJsBefore;
	}
}

export const data = window.ArveShortcodeDialogJsBefore as InlineJsShortcodeDialog;
export const options = writable( data.options );
