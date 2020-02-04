var imagemin = require("imagemin"),    // The imagemin module.
  webp = require("imagemin-webp"),   // imagemin's WebP plugin.
  outputFolder = "./public/content/themes/gj-boilerplate/img/webp",            // Output folder
  PNGImages = "./public/content/themes/gj-boilerplate/img/*.png",         // PNG images
  JPEGImages = "./public/content/themes/gj-boilerplate/img/*.jpg";        // JPEG images

imagemin([PNGImages], outputFolder, {
  plugins: [webp({
      lossless: true // Losslessly encode images
  })]
});

imagemin([JPEGImages], outputFolder, {
  plugins: [webp({
    quality: 80 // Quality setting from 0 to 100
  })]
}).then(function() {
  console.log("Images converted!");
});