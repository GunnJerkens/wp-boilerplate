var imagemin = require("imagemin"),    // The imagemin module.
    webp = require("imagemin-webp");   // imagemin's WebP plugin.

(async () => {
  await imagemin(['./public/content/themes/gj-boilerplate/img/*.{jpg,png}'], {
    destination: './public/content/themes/gj-boilerplate/img/webp',
    plugins: [
      webp({
        quality: [80]
      })
    ]
  });
  console.log("Images converted!");
})();