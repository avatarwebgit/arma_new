/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {
}

import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Pusher = Pusher;

//window.Echo = new Echo({
//    broadcaster: 'pusher',
//    key: import.meta.env.VITE_PUSHER_APP_KEY,
//    wsHost: import.meta.env.PUSHER_HOST,
//    wsPort: import.meta.env.PUSHER_PORT,
//    disableStats: true,
//    forceTLS: true,
//    cluster: 'ap2',
//});

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY, // Make sure this is set correctly in your .env file
    wsHost: 'ws.armaitimex.com', // Your WebSocket host without the protocol and trailing slash
    wsPort: 443, // 443 for HTTPS
    wssPort: 443, // 443 for HTTPS
    disableStats: true,
    encrypted: true,
    enabledTransports: ['wss'], // Use 'wss' for secure WebSocket connections
    forceTLS: true // Use TLS for secure connections
});
Pusher.logToConsole=true;


