importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyC0XTAcHDhk-YzguedH8yjg4hkRRNoi94k",
    projectId: "cheflab-user",
    messagingSenderId: "180746879110",
    appId: "1:180746879110:web:8440a4aab32734182e5107"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
