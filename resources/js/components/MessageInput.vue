<template>
  <div class="message-input">
    <div class="wrap">
      <i
        class="far fa-grin-wink fa-2x emojis"
        style="float: left; color:white; margin-right: 5px; margin-left: 5px"
      ></i>
      
      <div id="input-message" contenteditable="true" class="input-message" placeholder="Type a message..." @keyup.enter.exact="newMessage" @input="text=$event.target.innerText"></div>
      <button class="submit" @click="newMessage">
        <i
          class="fas fa-paper-plane fa-2x"
          style="float: left; color:white; margin-right: 5px; margin-left: 5px"
        ></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
    name: "messageInput",
    data() {
        return {
            text: ''
        };
    },
    methods: {
        newMessage() {
            this.text = this.text.trim().replace(/\n+/g, '\n');
            if(this.text) {
                this.$emit('newMessage', this.text);
                this.text = '';
                document.getElementById('input-message').innerHTML= '\0';
            }
        }
    }
};
</script>

<style scoped>
.message-input {
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
.message-input .wrap {
  position: relative;
}

[contenteditable="true"]:empty:before {
  content: attr(placeholder);
  display: block; /* For Firefox */
}

.message-input .wrap div {
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
  .message-input .wrap input {
    padding: 15px 32px 16px 8px;
  }
}
.message-input .wrap input:focus {
  outline: none;
}
.message-input .wrap .attachment {
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
  .message-input .wrap .attachment {
    margin-top: 17px;
    right: 65px;
  }
}
.message-input .wrap .attachment:hover {
  opacity: 1;
}
.message-input .wrap button {
  float: right;
  border: none;
  cursor: pointer;
  color: #32465a;
  background: transparent;
}

.message-input .wrap {
  display: flex;
  flex-flow: row;
  align-items: center;
}

@media screen and (max-width: 735px) {
  .message-input .wrap button {
    /* padding: 16px 0; */
  }
}
.message-input .wrap button i:hover {
  color: #435f7a!important;
}
/* .message-input .wrap button i:focus {
  outline: none;
} */

.emojis:hover {
  color: #435f7a!important;
}
</style>
