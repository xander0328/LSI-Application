var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    "/offline",
    "/images/icons/icon-72x72.png",
    "/images/icons/icon-96x96.png",
    "/images/icons/icon-128x128.png",
    "/images/icons/icon-144x144.png",
    "/images/icons/icon-152x152.png",
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-384x384.png",
    "/images/icons/icon-512x512.png",
    "/images/icons/splash-640x1136.png",
    "/images/icons/splash-750x1334.png",
    "/images/icons/splash-1242x2208.png",
    "/images/icons/splash-1125x2436.png",
    "/images/icons/splash-828x1792.png",
    "/images/icons/splash-1242x2688.png",
    "/images/icons/splash-1536x2048.png",
    "/images/icons/splash-1668x2224.png",
    "/images/icons/splash-1668x2388.png",
    "/images/icons/splash-2048x2732.png",
];

// Cache on install
self.addEventListener("install", (event) => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match("offline");
            })
    );
});

importScripts("https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"
);

// Initialize Firebase using your configuration
firebase.initializeApp({
    apiKey: "AIzaSyBi4oNVlyHAk6hdk42V7XugS_eR8_ianVw", // Replace with your actual API key
    authDomain: "lsi-app-541ad.firebaseapp.com",
    projectId: "lsi-app-541ad",
    storageBucket: "lsi-app-541ad.appspot.com",
    messagingSenderId: "740784195857",
    appId: "1:740784195857:web:01c322ecbcf6cc18bda4b0",
});

// Retrieve Firebase Messaging instance
const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );
    // Customize notification here
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon || "/firebase-logo.png",
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
