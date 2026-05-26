import { defineConfig } from "vite";
import { resolve } from "path";

export default defineConfig(({ command }) => ({
  plugins: [],

  server: {
    origin: "http://localhost:5173",
    port: 5173,
  },

  build: {
    outDir: "dist", // CHANGE THIS - use dist instead of assets
    emptyOutDir: false,
    manifest: true,
    minify: "terser",
    cssCodeSplit: false,
    rollupOptions: {
      input: {
        "js/app": resolve(__dirname, "assets/js/app.js"),
        "js/cart": resolve(__dirname, "assets/js/cart.js"),
        "js/product-gallery": resolve(__dirname, "assets/js/product-gallery.js"),
        "js/shop-filters": resolve(__dirname, "assets/js/shop-filters.js"),
        "js/checkout": resolve(__dirname, "assets/js/checkout.js"),
      },
      output: {
        assetFileNames: "[name][extname]",
        entryFileNames: "[name].js", // This will now output to dist/[name].js
        chunkFileNames: "js/chunks/[name].js",
      },
    },
    target: "es2020",
  },

  resolve: {
    alias: {
      "@": resolve(__dirname, "src"),
      "@js": resolve(__dirname, "assets/js"),
    },
  },

  optimizeDeps: {
    include: ["alpinejs"],
  },
}));
