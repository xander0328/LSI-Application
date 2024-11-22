// Import Firebase app and messaging modules
importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js");

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
messaging.onBackgroundMessage((payload) => {
    console.log(
        "[sw.js] Received background message ",
        payload
    );
    // Customize notification here
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: "/images/icons/icon-72x72.png"
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
