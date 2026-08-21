import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
	plugins: [
		laravel({
			input: [
				'resources/assets/sass/app.scss',
				'resources/assets/js/app.js',
			],
			refresh: true,
		}),
	],
	css: {
		preprocessorOptions: {
			scss: {
				// Bootstrap 4 and Dropzone are resolved from node_modules, and
				// both still use @import, which current Sass warns about.
				loadPaths: ['node_modules'],
				quietDeps: true,
				silenceDeprecations: ['import', 'global-builtin', 'color-functions'],
			},
		},
	},
});
