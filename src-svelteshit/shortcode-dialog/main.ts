// Import our custom CSS
import '../shared/bootstrap-forms.scss';

import App from './App.svelte';

const app = new App( {
	target: document.querySelector( '#arve-shortcode-dialog' ),
} );

export default app;
