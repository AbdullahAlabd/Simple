/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component("chat", require("./components/Chat.vue").default);
Vue.component("side-panel", require("./components/SidePanel.vue").default);
Vue.component("conversation", require("./components/Conversation.vue").default);
Vue.component(
    "message-input",
    require("./components/MessageInput.vue").default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});

// $(".messages").animate({
//     scrollTop: $(document).height()
//   }, "fast");

//   $("#profile-img").click(function () {
//     $("#status-options").toggleClass("active");
//   });

//   $(".expand-button").click(function () {
//     $("#profile").toggleClass("expanded");
//     $("#contacts").toggleClass("expanded");
//   });

//   $("#status-options ul li").click(function () {
//     $("#profile-img").removeClass();
//     $("#status-online").removeClass("active");
//     $("#status-away").removeClass("active");
//     $("#status-busy").removeClass("active");
//     $("#status-offline").removeClass("active");
//     $(this).addClass("active");

//     if ($("#status-online").hasClass("active")) {
//       $("#profile-img").addClass("online");
//     } else if ($("#status-away").hasClass("active")) {
//       $("#profile-img").addClass("away");
//     } else if ($("#status-busy").hasClass("active")) {
//       $("#profile-img").addClass("busy");
//     } else if ($("#status-offline").hasClass("active")) {
//       $("#profile-img").addClass("offline");
//     } else {
//       $("#profile-img").removeClass();
//     };

//     $("#status-options").removeClass("active");
//   });

//   function newMessage() {
//     message = $(".input-message").html();
//     if ($.trim(message) == '') {
//       return false;
//     }
//     $('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt=""/><p>' + message + '</p></li>')
//       .appendTo($('.messages ul'));
//     $('.input-message').html(null);
//     $('.contact.active .preview').html('<span>You: </span>' + message);
//     $(".messages").animate({
//       scrollTop: $(document).height()
//     }, "fast");
//   };

//   $('.submit').click(function () {
//     newMessage();
//   });

//   $(window).on('keydown', function (e) {
//     if (e.which == 13) {
//       newMessage();
//       return false;
//     }
//   });

//   function myfunction() {
//     var icon = document.getElementById("expand");
//     var div = document.getElementById('contact');
//     var img = document.getElementById('contimg');
//     var state = document.getElementById('status');
//     var tag = document.getElementById('tag');
//     div.classList.toggle("expand_div");
//     img.classList.toggle('expand_img');
//     tag.classList.toggle('tag')
//     if (state.style.display === "none") {
//       state.style.display = "block";
//     } else {
//       state.style.display = "none";
//     }
//   }
