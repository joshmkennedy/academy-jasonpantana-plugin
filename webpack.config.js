const defaults = require("@wordpress/scripts/config/webpack.config.js");

module.exports = {
  ...defaults,
  entry: {
    ...defaults.entry(),
    profile: { import: "./assets/src/profile.ts" },
  },
  module: {
    ...defaults.module,
    rules: [
      ...defaults.module.rules,
      {
        test: /\.tsx?$/,
        use: [
          {
            loader: "ts-loader",
            options: {
              configFile: "tsconfig.json",
              transpileOnly: true,
            },
          },
        ],
      },
    ],
  },

  resolve: {
    extensions: [
      ".ts",
      ".tsx",
      ...(defaults.resolve
        ? defaults.resolve.extensions || [".js", ".jsx"]
        : []),
    ],
  },
};
