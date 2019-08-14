<template>
  <div class="content" v-if="reciever">
    <div class="contact-profile" id="contact" v-bind="reciever">
      <img :src="'storage/'+reciever.image" id="contimg" alt />
      <div id="tag">
        <p style="position:absolute;top:-10;left:70px;">{{reciever.name}}</p>
        <small
          class="form-text text-muted"
          style="position: absolute;top:15px;left:70px; color: rgb(167, 167, 167)"
        >@{{reciever.handle}}</small>
      </div>
      <div class="top-bar-btns p-3">
        <i class="material-icons-round d-block mr-3" aria-hidden="true">group_add</i>
        <i class="material-icons-round d-block" aria-hidden="true">account_circle</i>
      </div>
    </div>

    <div class="messages" id="messages">
      <ul>
        <li
          v-for="message in messages"
          v-bind:key="message.id"
          :class="(message.sender_id===user.id?'sent':'replies')"
          @mouseover="massageHover"
        >
          <img :src="(message.sender_id===user.id?'storage/'+user.image:'storage/'+reciever.image)" />

          <div class="d-flex cont">
            <div
              class="d-block remove-btn"
              :id="'msg'+message.id"
              @mouseenter="showCancel('msg'+message.id)"
              @mouseleave="hideCancel('msg'+message.id)"
            >
              <i class="material-icons-round remove-icon" aria-hidden="true">cancel</i>
            </div>
            <p
              @mouseenter="showCancel('msg'+message.id)"
              @mouseleave="hideCancel('msg'+message.id)"
              data-toggle="tooltip"
              :data-placement="(message.sender_id===user.id?'right':'right')"
              :title="message.created_at"
              style="white-space: pre-line"
            >{{message.content}}</p>
          </div>
        </li>
      </ul>
    </div>
    <message-input v-on:newMessage="addMessage"></message-input>
  </div>
</template>

<script>
import Axios from "axios";
export default {
  name: "mainContent",
  props: ["curConversationID", "user", "reciever"],
  data() {
    return {
      messages: []
    };
  },
  watch: {
    curConversationID: function(newConvID, oldConvID) {
      Axios.get("/messages/showAll/" + newConvID)
        .then(res => {
          this.messages = Object.values(res.data);
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  methods: {
    addMessage(message = "") {
      let msgObj;
      Axios.post(
        "/messages",
        (msgObj = {
          conversation_id: this.curConversationID,
          sender_id: this.user.id,
          content: message
        })
      )
        .then(res => {
          this.$data.messages.push(res.data);
          this.$emit("convToTop", res.data);
        })
        .catch(e => {
          console.log(e);
        });
    },
    massageHover() {
      $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({
          // placement: "auto",
          trigger: "hover",
          delay: { show: 500, hide: 100 }
        });
      });
    },
    showCancel(parentID) {
      document
        .getElementById(parentID)
        .style.setProperty("display", "block", "important");
    },
    hideCancel(parentID) {
      document
        .getElementById(parentID)
        .style.setProperty("display", "none", "important");
    }
  },
  updated() {
    let messagesComponent = document.getElementById("messages");
    messagesComponent.scrollTop = messagesComponent.scrollHeight;
  },
  mounted() {}
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

.top-bar-btns i {
}

.top-bar-btns i:hover {
  color: #8fbeee !important;
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
  margin: 15px 15px 0px 15px !important;
  width: calc(100% - 25px);
  font-size: 1em;
  font-family: "proxima-nova", "Source Sans Pro", sans-serif, "Twemoji Mozilla";
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
.content .messages ul li.replies .cont {
  justify-content: flex-start !important;
  flex-direction: row-reverse !important;
  margin: 2px 0 0 8px;
}
.content .messages ul li.sent .cont {
  justify-content: flex-start !important;
  flex-direction: row !important;
  margin: 2px 0 0 8px;
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
  margin-bottom: 40px !important;
}

.remove-btn {
  display: none !important;
  opacity: 0.5;
  vertical-align: top;
  max-height: 100%;
}

.remove-icon {
  align-items: stretch;
  font-size: 20px !important;
  color: black;
  border-radius: 50%;
  border: 0px solid black;
  height: 100%;
}

.sent .remove-btn {
  float: left;
  margin-top: -4px;
  margin-right: -8px;
}

.replies .remove-btn {
  float: right;
  margin-left: -8px;
  margin-top: -4px;
}

.content .messages ul li .remove-btn:hover {
  cursor: pointer;
}
</style>