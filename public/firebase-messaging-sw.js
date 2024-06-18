// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyBi4oNVlyHAk6hdk42V7XugS_eR8_ianVw",
    authDomain: "lsi-app-541ad.firebaseapp.com",
    projectId: "lsi-app-541ad",
    storageBucket: "lsi-app-541ad.appspot.com",
    messagingSenderId: "740784195857",
    appId: "1:740784195857:web:01c322ecbcf6cc18bda4b0"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});

// for click-action
self.addEventListener('notificationclick', function(event) {
    let url = event.notification.data.click_action || '/';
    event.notification.close(); // Close the notification
    event.waitUntil(
        clients.matchAll({type: 'window'}).then(windowClients => {
            // Check if there is already a window/tab open with the target URL
            for (let i = 0; i < windowClients.length; i++) {
                let client = windowClients[i];
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            // If not, then open a new window/tab to the target URL
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});
