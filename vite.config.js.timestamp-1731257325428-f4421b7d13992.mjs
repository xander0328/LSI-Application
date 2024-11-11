// vite.config.js
import { defineConfig } from "file:///C:/laragon/www/LSI-Application/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/laragon/www/LSI-Application/node_modules/laravel-vite-plugin/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true
    })
  ],
  server: {
    host: "0.0.0.0",
    port: "3000",
    hmr: {
      host: "192.168.1.19"
    }
  }
  // build: {
  //     outDir: 'public/build', // This is optional, depending on your needs
  //     rollupOptions: {
  //         input: {
  //             manifest: 'public/manifest.json',
  //             serviceworker: 'public/serviceworker.js'
  //         }
  //     }
  // }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFxMU0ktQXBwbGljYXRpb25cIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXGxhcmFnb25cXFxcd3d3XFxcXExTSS1BcHBsaWNhdGlvblxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovbGFyYWdvbi93d3cvTFNJLUFwcGxpY2F0aW9uL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSBcInZpdGVcIjtcbmltcG9ydCBsYXJhdmVsIGZyb20gXCJsYXJhdmVsLXZpdGUtcGx1Z2luXCI7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXCJyZXNvdXJjZXMvY3NzL2FwcC5jc3NcIiwgXCJyZXNvdXJjZXMvanMvYXBwLmpzXCJdLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG4gICAgXSxcbiAgICBzZXJ2ZXI6IHtcbiAgICAgICAgaG9zdDogJzAuMC4wLjAnLFxuICAgICAgICBwb3J0OiAnMzAwMCcsXG4gICAgICAgIGhtcjoge1xuICAgICAgICAgICAgaG9zdDogXCIxOTIuMTY4LjEuMTlcIixcbiAgICAgICAgfSxcbiAgICB9LFxuICAgIC8vIGJ1aWxkOiB7XG4gICAgLy8gICAgIG91dERpcjogJ3B1YmxpYy9idWlsZCcsIC8vIFRoaXMgaXMgb3B0aW9uYWwsIGRlcGVuZGluZyBvbiB5b3VyIG5lZWRzXG4gICAgLy8gICAgIHJvbGx1cE9wdGlvbnM6IHtcbiAgICAvLyAgICAgICAgIGlucHV0OiB7XG4gICAgLy8gICAgICAgICAgICAgbWFuaWZlc3Q6ICdwdWJsaWMvbWFuaWZlc3QuanNvbicsXG4gICAgLy8gICAgICAgICAgICAgc2VydmljZXdvcmtlcjogJ3B1YmxpYy9zZXJ2aWNld29ya2VyLmpzJ1xuICAgIC8vICAgICAgICAgfVxuICAgIC8vICAgICB9XG4gICAgLy8gfVxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQW9SLFNBQVMsb0JBQW9CO0FBQ2pULE9BQU8sYUFBYTtBQUVwQixJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPLENBQUMseUJBQXlCLHFCQUFxQjtBQUFBLE1BQ3RELFNBQVM7QUFBQSxJQUNiLENBQUM7QUFBQSxFQUNMO0FBQUEsRUFDQSxRQUFRO0FBQUEsSUFDSixNQUFNO0FBQUEsSUFDTixNQUFNO0FBQUEsSUFDTixLQUFLO0FBQUEsTUFDRCxNQUFNO0FBQUEsSUFDVjtBQUFBLEVBQ0o7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFVSixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
