const path = require("path");

module.exports = {
	devtool: false,
	entry: "./admin/js/script.js",
	output: {
		filename: "ethc.js",
		path: path.resolve(__dirname, "admin/js"),
	},
};
