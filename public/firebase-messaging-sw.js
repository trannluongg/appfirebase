importScripts('https://www.gstatic.com/firebasejs/8.6.5/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.6.5/firebase-messaging.js');


const firebaseConfig = {
    apiKey: "AIzaSyA5F2Kkdr3Pv1IyIr5BzkRsZHd0_f39Zpc",
    authDomain: "appnotify-b8b74.firebaseapp.com",
    projectId: "appnotify-b8b74",
    storageBucket: "appnotify-b8b74.appspot.com",
    messagingSenderId: "676518578234",
    appId: "1:676518578234:web:123729eeb7bb2d73a2cd03",
    measurementId: "G-4JK7CNW80T"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
