module.exports = {
	main: {
		options: {
			mode: 'zip',
			archive: './release/<%= pkg.archive %>.zip'
		},
		expand: true,
		cwd: './',
		src: ['**/*', '!node_modules/**', '!release/**'],
		dest: './'
	}
};
