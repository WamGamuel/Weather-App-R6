import axios from 'axios';

window.axios = axios;

// Set default header for AJAX requests
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';