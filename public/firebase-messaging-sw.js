importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
    apiKey: "AIzaSyBOy3lWU6BPHO_q4yOOQI6Rjr4lCcUcMgY",
    authDomain: "heypal-4fd57.firebaseapp.com",
    projectId: "heypal-4fd57",
    storageBucket: "heypal-4fd57.appspot.com",
    messagingSenderId: "998203189129",
    appId: "1:998203189129:web:bcb3d061014d40402b2358",
    measurementId: "G-ZM2ZLJ1LB8"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();