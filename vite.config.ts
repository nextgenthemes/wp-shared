import { resolve } from 'path';
import { defineConfig } from 'vite';
import { svelte } from '@sveltejs/vite-plugin-svelte';

// https://vitejs.dev/config/
export default defineConfig( {
	plugins: [ svelte() ],
	root: 'src',
	build: {
		rollupOptions: {
			input: {
				index: resolve( __dirname, 'src/index.html' ),
				settings: resolve( __dirname, 'src/settings.html' ),
			},
		},
		outDir: '../dist',
	},
} );
