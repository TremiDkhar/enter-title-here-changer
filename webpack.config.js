const path = require('path');

module.exports = {
	devtool: false,
	entry: './admin/js/script.js',
	output: {
		filename: 'ethc.min.js',
		path: path.resolve(__dirname, 'admin/js'),
	},
	module: {
		rules: [
			{
				test: /\.m?js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
				},
			},
		],
	},
};
