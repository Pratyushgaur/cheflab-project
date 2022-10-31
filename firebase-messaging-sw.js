importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyB_ym9qT9oWdc25CMIjXJVX-Ku6XhrwhnA",
    projectId: "chef-leb",
    messagingSenderId: "307095509147",
    appId: "1:307095509147:web:c382e5e84230f9a27f8e3e"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});