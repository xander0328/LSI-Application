import "./bootstrap";

import "flowbite";
import axios from "axios";

// Jquery
import $ from "jquery";
window.$ = $;

// FilePond
import * as FilePond from "filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginGetFile from "filepond-plugin-get-file";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-get-file/dist/filepond-plugin-get-file.min.css";
window.FilePond = FilePond;
window.FilePondPluginGetFile = FilePondPluginGetFile;
window.FilePondPluginImagePreview = FilePondPluginImagePreview;

// Flatpciker
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
window.flatpickr = flatpickr;

// DOMPurify
import DOMPurify from "dompurify";
window.DOMPurify = DOMPurify;

// Moment JS
import moment from "moment";
window.moment = moment;

// Calendar (FullCalendar)
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import interactionPlugin from "@fullcalendar/interaction";
window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;
window.interactionPlugin = interactionPlugin;

// Quill
import Quill from "quill";
import "quill/dist/quill.snow.css";
window.Quill = Quill;

// Sweet Alert
import Swal from "sweetalert2/dist/sweetalert2.js";
// import 'sweetalert2/dist/sweetalert2.min.css';  // Import default SweetAlert2 styles
import "@sweetalert2/theme-borderless/borderless.css";
window.Swal = Swal;

// Toastr
import toastr from "toastr/toastr";
import "toastr/build/toastr.min.css";
toastr.options = {
    closeButton: true,
    progressBar: true,
    preventDuplicates: true,
    positionClass: "toast-bottom-right",
    showDuration: "100",
    hideDuration: "100",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "slideDown",
    hideMethod: "slideUp",
};
window.toastr = toastr;

// Parser for Session getting
import UAParser from "ua-parser-js";
window.UAParser = UAParser;

// QrCode
import { Html5QrcodeScanner } from "html5-qrcode";
import { Html5Qrcode } from "html5-qrcode";
window.Html5QrcodeScanner = Html5QrcodeScanner;
window.Html5Qrcode = Html5Qrcode;

// ChartsJS
import { Chart } from "chart.js/auto";
window.Chart = Chart;

// Alpine
import Alpine from "alpinejs";
import intersect from "@alpinejs/intersect";
import resize from "@alpinejs/resize";
Alpine.plugin(intersect, resize);
window.Alpine = Alpine;

// PWA Setup
if ("serviceWorker" in navigator) {
    navigator.serviceWorker
        .register("/serviceworker.js")
        .then((registration) => {
            console.log("Service Worker registered:", registration);
        })
        .catch((error) => {
            console.error("Service Worker registration failed:", error);
        });
}

import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

// Your Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyBi4oNVlyHAk6hdk42V7XugS_eR8_ianVw", // Replace with your actual API key
    authDomain: "lsi-app-541ad.firebaseapp.com",
    projectId: "lsi-app-541ad",
    storageBucket: "lsi-app-541ad.appspot.com",
    messagingSenderId: "740784195857",
    appId: "1:740784195857:web:01c322ecbcf6cc18bda4b0",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

document.addEventListener("alpine:init", () => {
    Alpine.data("notificationComponent", () => ({
        async checkPermission() {
            const permission = await Notification.permission;
            if (permission === "granted") {
                $("#toast-interactive").addClass("hidden");
            }
        },
        async requestPermission() {
            try {
                // Request notification permission from the user
                const permission = await Notification.requestPermission();

                if (permission === "granted") {
                    console.log("Notification permission granted.");

                    // Get the FCM token
                    const token = await getToken(messaging, {
                        vapidKey:
                            "BKIPwy0AfIkgcxZH_iGfH5AySmDRl-gLdWxqof-mC7SIOoYB06y9FlsXhForjmiL4E_cG-zehV-pyMA_zC4nsTk",
                    });

                    if (token) {
                        console.log("FCM Token:", token);
                        this.sendTokenToServer(token);
                    } else {
                        console.log(
                            "No registration token available. Request permission to generate one."
                        );
                    }
                } else {
                    console.log("Notification permission not granted.");
                }

                this.checkPermission();
            } catch (error) {
                console.error("Error getting permission or token:", error);
            }
        },
        async sendTokenToServer(token) {
            try {
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");
                const response = await fetch("/store-token", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({ device_token: token }),
                });
                const data = await response.json();
                console.log("Token sent to server:", data);
            } catch (error) {
                console.error("Error sending token to server:", error);
            }
        },
    }));
});
// Handle incoming messages
onMessage(messaging, (payload) => {
    console.log("Message received: ", payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };

    new Notification(notificationTitle, notificationOptions);
});

// Request permission when the script is loaded
// requestPermission();

// async function sendTokenToServer(token) {
//     try {
//         const response = await fetch("/api/device-token", {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/json",
//                 "X-CSRF-Token": document
//                     .querySelector('meta[name="csrf-token"]')
//                     .getAttribute("content"), // If using CSRF protection
//             },
//             body: JSON.stringify({
//                 token: token,
//                 user_id: yourUserId, // Replace with actual user ID
//             }),
//         });

//         const data = await response.json();
//         console.log(data.message);
//     } catch (error) {
//         console.error("Error sending token to server:", error);
//     }
// }

// requestNotificationPermission();
// sendTokenToServer(deviceToken);

// PWA Installation
let deferredPrompt;
window.addEventListener("beforeinstallprompt", (e) => {
    e.preventDefault();
    deferredPrompt = e;
    console.log("install button");

    // Show your custom install button
    const installButton = document.querySelector("#installButton");
    const installButtonHolder = document.querySelector("#installButtonHolder");

    if (installButton) {
        installButton.classList.remove("hidden");

        installButton.addEventListener("click", () => {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === "accepted") {
                    console.log("User accepted the A2HS prompt");
                } else {
                    console.log("User dismissed the A2HS prompt");
                }
                deferredPrompt = null;
            });
        });
    }
    if (installButtonHolder) {
        installButtonHolder.classList.remove("hidden");
        installButtonHolder.classList.add("flex");
    }
});

window.addEventListener("beforeinstallpromptresponsive", (e) => {
    e.preventDefault();
    deferredPrompt = e;
    console.log("install button");

    // Show your custom install button
    const installButton = document.querySelector("#installButtonRes");
    const installButtonHolder = document.querySelector("#installButtonHolderRes");

    if (installButton) {
        installButton.classList.remove("hidden");

        installButton.addEventListener("click", () => {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === "accepted") {
                    console.log("User accepted the A2HS prompt");
                } else {
                    console.log("User dismissed the A2HS prompt");
                }
                deferredPrompt = null;
            });
        });
    }
    if (installButtonHolder) {
        installButtonHolder.classList.remove("hidden");
        installButtonHolder.classList.add("flex");
    }
});

Alpine.start();
