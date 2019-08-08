<template>
  <div class="content">
    <div class="contact-profile" id="contact">
      <img :src="reciever.imgUrl" id="contimg" alt />
      <div id="tag">
        <p style="position:absolute;top:-10;left:70px;">{{reciever.name}}</p>
        <small
          class="form-text text-muted"
          style="position: absolute;top:15px;left:70px; color: rgb(167, 167, 167)"
        >{{reciever.handle}}</small>
      </div>
      <div class="top-bar-btns p-3">
        <i class="material-icons d-block mr-3" aria-hidden="true" >group_add</i>
        <i class="fa fa-user-circle fa-lg d-block" id="expand" aria-hidden="true" onclick="myfunction()"></i>
      </div>
    </div>

    <div class="messages" id="messages">
      <ul>
        <li 
          v-bind="messages"
          v-for="message in messages"
          v-bind:key="message.id"
          :class="(message.sender_id===user.id?'sent':'replies')"
          @mouseover="massageHover"
        >
          <img :src="(message.sender_id===user.id?senderImgUrl:reciever.imgUrl)" />
          <p data-toggle="popover" :data-content="message.created_at" style="white-space: pre-line">{{message.content}}</p>
        </li>
      </ul>
    </div>
    <message-input v-on:newMessage="addMessage"></message-input>
  </div>
</template>

<script>
import Axios from 'axios';
export default {
  name: "mainContent",
  props: ['conversationId', 'user'],
  data() {
    return {
      cnt: 100,
      conversationID: null,
      parallelConversationID: null,
      senderImgUrl: "http://emilcarlsson.se/assets/mikeross.png", //to be removed
      reciever: {
        id: null,
        imgUrl: "http://emilcarlsson.se/assets/harveyspecter.png",
        name: "Nour",
        handle: "@nour7",
        status: "Life is Life" // about or bio
      },
      messages: []
    };
  },
  methods: {
    
    addMessage(message = '') {
      const msg = {
        id: ++this.cnt, //tobe edited
        sender_id: this.user.id,
        content: message,
        timespan: Date.now()
      };
      this.messages.push(msg);
    },
    massageHover() {
      $(document).ready(function(){
          $('[data-toggle="popover"]').popover({
              placement : 'left',
              trigger : 'hover',
          });
      });
    },
  },
  updated() {
    let messagesComponent = document.getElementById('messages');
    messagesComponent.scrollTop = messagesComponent.scrollHeight;
  },
  mounted(){
    Axios.get('/messages/showAll/'+this.conversationId)
    .then(res => {
      this.messages = res.data;
    })
    .catch(e => {
      console.log(e);
    });
    let messagesComponent = document.getElementById('messages');
    messagesComponent.scrollTop = messagesComponent.scrollHeight;
  }
};
</script>

<style scoped>
.content {
  float: right;
  width: 60%;
  height: 100%;
  overflow: hidden;
  position: relative;
}
@media screen and (max-width: 735px) {
  .content {
    width: calc(100% - 58px);
    min-width: 300px !important;
  }
}
@media screen and (min-width: 900px) {
  .content {
    width: calc(100% - 340px);
  }
}
.content .contact-profile {
  width: 100%;
  height: 60px;
  line-height: 60px;
  background: #f5f5f5;
}


.content .contact-profile img {
  width: 46px;
  border-radius: 50%;
  float: left;
  margin: 6px 12px 0 9px;
}
.content .contact-profile p {
  float: left;
}
.top-bar-btns {
  display: flex;
  flex-flow: row left;
  align-items: center;
  float: right;
}

.top-bar-btns i{
  
}

.top-bar-btns i:hover{
  color: #8fbeee!important;
  cursor: pointer;
}


.content .contact-profile .social-media {
  float: right;
}
.content .contact-profile .social-media i {
  margin-left: 14px;
  cursor: pointer;
}
.content .contact-profile .social-media i:nth-last-child(1) {
  margin-right: 20px;
}
.content .contact-profile .social-media i:hover {
  color: #435f7a;
}
.content .messages {
  height: auto;
  min-height: calc(100% - 120px);
  max-height: calc(100% - 120px);
  overflow-y: scroll;
  overflow-x: hidden;
}
@media screen and (max-width: 735px) {
  .content .messages {
    max-height: calc(100% - 105px);
  }
}
.content .messages::-webkit-scrollbar {
  width: 8px;
  background: transparent;
}
.content .messages::-webkit-scrollbar-thumb {
  background-color: rgba(0, 0, 0, 0.3);
}
.content .messages ul li {
  display: inline-block;
  clear: both;
  float: left;
  margin: 15px 15px 0px 15px !important;
  width: calc(100% - 25px);
  font-size: 0.9em;
}
.content .messages ul li.sent img {
  margin: 2px 8px 0 0;
}
.content .messages ul li.sent p {
  word-wrap: break-word;
  background: #435f7a;
  color: #f5f5f5;
  margin-bottom: 0px;
}
.content .messages ul li.replies img {
  float: right;
  margin: 2px 0 0 8px;
}
.content .messages ul li.replies p {
  word-wrap: break-word;
  background: #f5f5f5;
  float: right;
  margin-bottom: 0px;
}
.content .messages ul li img {
  width: 30px;
  border-radius: 50%;
  float: left;
}
.content .messages ul li p {
  display: inline-block;
  padding: 10px 15px;
  border-radius: 20px;
  max-width: 70%;
  line-height: 130%;
}
@media screen and (min-width: 735px) {
  .content .messages ul li p {
    max-width: 70%;
  }
}
.content .messages ul li:nth-last-child(1) {
  margin-bottom: 40px!important;
}

</style>
