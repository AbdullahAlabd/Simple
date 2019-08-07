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
      <div class="top-bar-btns">
        <i class="fa fa-user-circle fa-lg" id="expand" aria-hidden="true" onclick="myfunction()"></i>
      </div>
    </div>

    <div class="messages">
      <ul>
        <li
          v-bind="messages"
          v-bind:key="message.id"
          v-for="message in messages"
          :class="(message.isFrom?'sent':'replies')"
        >
          <img :src="(message.isFrom?senderImgUrl:reciever.imgUrl)" />
          <p>{{message.text}}</p>
        </li>
      </ul>
    </div>

    <div class="message-input">
      <div class="wrap">
        <i
          class="far fa-grin-wink fa-2x"
          style="float: left; color:white; margin-right: 5px; margin-left: 5px"
        ></i>
        <div contenteditable="true" class="input-message" placeholder="Write your message..."></div>
        <button class="submit">
          <i
            class="fas fa-paper-plane fa-2x"
            style="float: left; color:white; margin-right: 5px; margin-left: 5px"
          ></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "mainContent",
  data() {
    return {
      conversationID: null,
      parallelConversationID: null,
      senderImgUrl: "http://emilcarlsson.se/assets/mikeross.png", //to be removed
      reciever: {
        id: null,
        imgUrl: "http://emilcarlsson.se/assets/harveyspecter.png",
        name: "Nour",
        handle: "@nour7",
        status: "Life is Life", // about or bio
      },
      messages: [
        {
          id: 0,
          isFrom: true,
          text:
            "How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!",
          timespan: null
        },
        {
          id: 1,
          isFrom: false,
          text:
            "When you're backed against the wall, break the god damn thing down.",
          timespan: null
        },
        {
          id: 2,
          isFrom: false,
          text: "Excuses don't win championships.",
          timespan: null
        },
        {
          id: 3,
          isFrom: true,
          text: "Oh yeah, did Michael Jordan tell you that?",
          timespan: null
        },
        {
          id: 4,
          isFrom: false,
          text: "No, I told him that.",
          timespan: null
        },
        {
          id: 5,
          isFrom: false,
          text: "What are your choices when someone puts a gun to your head?",
          timespan: null
        },
        {
          id: 6,
          isFrom: true,
          text:
            "What are you talking about? You do what they say or they shoot you.",
          timespan: null
        },
        {
          id: 7,
          isFrom: false,
          text:
            "Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.",
          timespan: null
        }
      ]
    };
  }
};
</script>

<style>
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
  /* padding: 25px; */
  padding-right: 25px;
  /* padding-top: 25px; */
  float: right;
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
.content .messages ul li:nth-last-child(1) {
  margin-bottom: 20px;
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

.content .message-input {
  position: absolute;
  bottom: 0;
  width: 100%;
  z-index: 99;
  display: block;
  overflow: auto;
  background-color: #959fa8;
  padding-top: 16px;
  padding-bottom: 16px;
}
.content .message-input .wrap {
  position: relative;
}

[contenteditable="true"]:empty:before {
  content: attr(placeholder);
  display: block; /* For Firefox */
}

.content .message-input .wrap div {
  font-family: "proxima-nova", "Source Sans Pro", sans-serif;
  float: left;
  border: none;
  width: 100%;
  padding: 11px 32px 10px 8px;
  font-size: 0.8em;
  color: #32465a;
  resize: none;
  border-radius: 20px;
  background-color: white;
  overflow-wrap: break-word;
  max-height: 100px;
  overflow: auto;
  outline: none;
}

@media screen and (max-width: 735px) {
  .content .message-input .wrap input {
    padding: 15px 32px 16px 8px;
  }
}
.content .message-input .wrap input:focus {
  outline: none;
}
.content .message-input .wrap .attachment {
  position: absolute;
  right: 60px;
  z-index: 4;
  margin-top: 10px;
  font-size: 1.1em;
  color: #435f7a;
  opacity: 0.5;
  cursor: pointer;
}
@media screen and (max-width: 735px) {
  .content .message-input .wrap .attachment {
    margin-top: 17px;
    right: 65px;
  }
}
.content .message-input .wrap .attachment:hover {
  opacity: 1;
}
.content .message-input .wrap button {
  float: right;
  border: none;
  /* width: 50px; */
  /* padding: 12px 0; */
  cursor: pointer;
  color: #32465a;
  background: transparent;
  /* background: #32465a; */
  /* color: #f5f5f5; */
}

.content .message-input .wrap {
  display: flex;
  flex-flow: row;
  align-items: center;
}

@media screen and (max-width: 735px) {
  .content .message-input .wrap button {
    /* padding: 16px 0; */
  }
}
.content .message-input .wrap button:hover {
  color: #435f7a;
}
.content .message-input .wrap button:focus {
  outline: none;
}
</style>
