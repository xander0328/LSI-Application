import './bootstrap';

import 'flowbite';

import FilePondPluginGetFile from 'filepond-plugin-get-file';
// FilePond.registerPlugin(FilePondPluginGetFile);

import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';  // Import default SweetAlert2 styles
import '@sweetalert2/theme-borderless/borderless.css';  
window.Swal = Swal;

import UAParser from 'ua-parser-js';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect'
 
window.Alpine = Alpine;
window.UAParser = UAParser;

Alpine.plugin(intersect)
Alpine.start();


if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/serviceworker.js')
        .then(registration => {
            console.log('Service Worker registered:', registration);
        })
        .catch(error => {
            console.error('Service Worker registration failed:', error);
        });

        
        
       
        
} 
let deferredPrompt;
        
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            console.log('install button');
            
            // Show your custom install button
            const installButton = document.querySelector('#installButton');
            installButton.style.display = 'block';
            
            installButton.addEventListener('click', () => {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                deferredPrompt = null;
                });
            });
        });


