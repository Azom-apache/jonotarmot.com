
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
import {
    getMessaging,
    getToken,
    onMessage,
} from "https://www.gstatic.com/firebasejs/10.11.1/firebase-messaging.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional

const firebaseConfig = {
  apiKey: "AIzaSyBOy3lWU6BPHO_q4yOOQI6Rjr4lCcUcMgY",
  authDomain: "heypal-4fd57.firebaseapp.com",
  projectId: "heypal-4fd57",
  storageBucket: "heypal-4fd57.appspot.com",
  messagingSenderId: "998203189129",
  appId: "1:998203189129:web:bcb3d061014d40402b2358",
  measurementId: "G-ZM2ZLJ1LB8"
};
console.log(firebaseConfig);
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// 
getToken(messaging)
  .then(async (token) => {
    console.log("Token:", token);
    if(token) {
        // 
        // await saveFcmToken(token)
    }
  })
  .catch((err) => {
    console.log("Error getting token:", err);
  });

onMessage(messaging, (payload) => {
    console.log( 'payload',payload);
    $('#pendingCallModal').modal('show')
    generateNotification(payload);
});
function saveFcmToken(fcmToken) {
   

    $.ajax({
        method: "POST",
        url: "/fcm/tokens?_tk=" + CSRF,
        contentType: "application/json",
        data: JSON.stringify({token: fcmToken}),
        success: (res) => {
            if (fcmToken) {
                setCookie(FIREBASE_COOKIE_NAME, fcmToken, FIREBASE_COOKIE_TTL_DAYS);
                setCookie(NOTIFICATION_PERMISSION_COOKIE_NAME, "", -1);
            } else {
                setCookie(FIREBASE_COOKIE_NAME, fcmToken, -1);
                setCookie(NOTIFICATION_PERMISSION_COOKIE_NAME, "denied", NOTIFICATION_PERMISSION_COOKIE_TTL_DAYS);
            }
        },
        error: (err) => {
            console.log("Error during fcm save operation");
        }
    });
}

function generateNotification(payload) {
    if (Notification.permission === "granted") {
        // we can send an os level notification here or it is better to show an in web view
        // pop up notification
        const notificationOptions = {
            body: payload.notification.body,
            image: payload.notification.image,
            icon: '/favicon.ico'
        }

        const notification = new Notification(payload.notification.title, notificationOptions, null);
        notification.addEventListener("click", () => {
            window.open('http://localhost:8000/payment');
        });
    }
}