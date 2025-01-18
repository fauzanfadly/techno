// vite.config.js
import { defineConfig } from "file:///C:/Users/fadly/OneDrive/Documents/Za%20Works/Project%20Fullstack/techno/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Users/fadly/OneDrive/Documents/Za%20Works/Project%20Fullstack/techno/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///C:/Users/fadly/OneDrive/Documents/Za%20Works/Project%20Fullstack/techno/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import vuetify from "file:///C:/Users/fadly/OneDrive/Documents/Za%20Works/Project%20Fullstack/techno/node_modules/@vuetify/vite-plugin/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.js",
        "resources/scss/variables.scss"
      ],
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    })
  ],
  // css: {
  //     preprocessorOptions: {
  //         scss: {
  //             additionalData: `@import "@/../scss/variables.scss";`,
  //         },
  //     },
  // },
  server: {
    host: process.env.VITE_PORT || "localhost",
    port: parseInt(process.env.VITE_PORT || "3000")
  },
  resolve: {
    alias: {
      "@": "/resources/js"
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxmYWRseVxcXFxPbmVEcml2ZVxcXFxEb2N1bWVudHNcXFxcWmEgV29ya3NcXFxcUHJvamVjdCBGdWxsc3RhY2tcXFxcdGVjaG5vXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxmYWRseVxcXFxPbmVEcml2ZVxcXFxEb2N1bWVudHNcXFxcWmEgV29ya3NcXFxcUHJvamVjdCBGdWxsc3RhY2tcXFxcdGVjaG5vXFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9DOi9Vc2Vycy9mYWRseS9PbmVEcml2ZS9Eb2N1bWVudHMvWmElMjBXb3Jrcy9Qcm9qZWN0JTIwRnVsbHN0YWNrL3RlY2huby92aXRlLmNvbmZpZy5qc1wiO2ltcG9ydCB7IGRlZmluZUNvbmZpZyB9IGZyb20gXCJ2aXRlXCI7XG5pbXBvcnQgbGFyYXZlbCBmcm9tIFwibGFyYXZlbC12aXRlLXBsdWdpblwiO1xuaW1wb3J0IHZ1ZSBmcm9tIFwiQHZpdGVqcy9wbHVnaW4tdnVlXCI7XG5pbXBvcnQgdnVldGlmeSBmcm9tIFwiQHZ1ZXRpZnkvdml0ZS1wbHVnaW5cIjtcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIGxhcmF2ZWwoe1xuICAgICAgICAgICAgaW5wdXQ6IFtcbiAgICAgICAgICAgICAgICBcInJlc291cmNlcy9jc3MvYXBwLmNzc1wiLFxuICAgICAgICAgICAgICAgIFwicmVzb3VyY2VzL2pzL2FwcC5qc1wiLFxuICAgICAgICAgICAgICAgIFwicmVzb3VyY2VzL3Njc3MvdmFyaWFibGVzLnNjc3NcIixcbiAgICAgICAgICAgIF0sXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICAgICAgdnVlKHtcbiAgICAgICAgICAgIHRlbXBsYXRlOiB7XG4gICAgICAgICAgICAgICAgdHJhbnNmb3JtQXNzZXRVcmxzOiB7XG4gICAgICAgICAgICAgICAgICAgIGJhc2U6IG51bGwsXG4gICAgICAgICAgICAgICAgICAgIGluY2x1ZGVBYnNvbHV0ZTogZmFsc2UsXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgIH0pLFxuICAgIF0sXG4gICAgLy8gY3NzOiB7XG4gICAgLy8gICAgIHByZXByb2Nlc3Nvck9wdGlvbnM6IHtcbiAgICAvLyAgICAgICAgIHNjc3M6IHtcbiAgICAvLyAgICAgICAgICAgICBhZGRpdGlvbmFsRGF0YTogYEBpbXBvcnQgXCJALy4uL3Njc3MvdmFyaWFibGVzLnNjc3NcIjtgLFxuICAgIC8vICAgICAgICAgfSxcbiAgICAvLyAgICAgfSxcbiAgICAvLyB9LFxuICAgIHNlcnZlcjoge1xuICAgICAgICBob3N0OiBwcm9jZXNzLmVudi5WSVRFX1BPUlQgfHwgXCJsb2NhbGhvc3RcIixcbiAgICAgICAgcG9ydDogcGFyc2VJbnQocHJvY2Vzcy5lbnYuVklURV9QT1JUIHx8ICczMDAwJyksXG4gICAgfSxcbiAgICByZXNvbHZlOiB7XG4gICAgICAgIGFsaWFzOiB7XG4gICAgICAgICAgICBcIkBcIjogXCIvcmVzb3VyY2VzL2pzXCIsXG4gICAgICAgIH0sXG4gICAgfSxcbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUErWSxTQUFTLG9CQUFvQjtBQUM1YSxPQUFPLGFBQWE7QUFDcEIsT0FBTyxTQUFTO0FBQ2hCLE9BQU8sYUFBYTtBQUVwQixJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPO0FBQUEsUUFDSDtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsTUFDSjtBQUFBLE1BQ0EsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLElBQ0QsSUFBSTtBQUFBLE1BQ0EsVUFBVTtBQUFBLFFBQ04sb0JBQW9CO0FBQUEsVUFDaEIsTUFBTTtBQUFBLFVBQ04saUJBQWlCO0FBQUEsUUFDckI7QUFBQSxNQUNKO0FBQUEsSUFDSixDQUFDO0FBQUEsRUFDTDtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUEsRUFRQSxRQUFRO0FBQUEsSUFDSixNQUFNLFFBQVEsSUFBSSxhQUFhO0FBQUEsSUFDL0IsTUFBTSxTQUFTLFFBQVEsSUFBSSxhQUFhLE1BQU07QUFBQSxFQUNsRDtBQUFBLEVBQ0EsU0FBUztBQUFBLElBQ0wsT0FBTztBQUFBLE1BQ0gsS0FBSztBQUFBLElBQ1Q7QUFBQSxFQUNKO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
