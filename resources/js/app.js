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
let deferredPrompt;

// Firebase
import { initializeApp } from "firebase/app";
import { getMessaging } from "firebase/messaging";

const firebaseConfig = {
    apiKey: import.meta.env.VITE_FIREBASE_APIKEY,
    authDomain: import.meta.env.VITE_AUTH_DOMAIN,
    projectId: import.meta.env.VITE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_APP_ID,
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

window.messaging = messaging;

window.addEventListener("beforeinstallprompt", (e) => {
    e.preventDefault();
    deferredPrompt = e;
    console.log("install button");

    // Show your custom install button
    const installButton = document.querySelector("#installButton");
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
});

Alpine.start();
