const defaults = require("@wordpress/scripts/config/webpack.config.js");

module.exports = {
  ...defaults,
  entry: {
    ...defaults.entry(),
    global: { import: "./assets/src/global.ts" },
    search: { import: "./assets/src/search.ts" },
    profile: { import: "./assets/src/profile.ts" },
    ["aim-template"]: { import: "./assets/src/aim-template.ts" },
    ["icon-card-nav"]: { import: "./assets/src/icon-card-nav.ts" },
    ["registration-form"]: { import: "./assets/src/registration-form.ts" },
    ["protect-free-lesson"]: { import: "./assets/src/protect-free-lesson/index.ts" },
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
