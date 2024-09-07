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


