<template>
  <div class="message-input">
    <div class="wrap">
      <i class="material-icons-round mx-1">insert_emoticon</i>
      <div id="input-message" contenteditable="true" class="input-message" placeholder="Type a message..." @keyup.enter.exact="newMessage" @input="inputChanged($event.target.innerText)" ref="input"></div>
      <i class="material-icons-round mx-1" @click="newMessage">send</i>
    </div>
  </div>
</template>

<script>
const shortcuts = require('./emoji-shortcut.json');
let shrtMap = new Map();
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
              
              this.text = this.replaceShortcuts(this.text);
              this.$emit('newMessage', this.text);
              this.text = '';
              document.getElementById('input-message').innerHTML= '\0';
            }
        },
        inputChanged(input) {
          this.text = input;
          // this.text = this.replaceShortcuts(this.text);
        },
        replaceShortcuts(msg = '') {
          let res = ''
          for(let i = 0; i < msg.length;) {
            let b = 0;
            for(let l = Math.min(6, msg.length-i); l >= 2; l--) {
              if(shrtMap.has(msg.substring(i, i+l))) {
                res += shrtMap.get(msg.substring(i, i+l));
                b = l-1;
                break;
              }
            }
            if(!b) {
              res += msg[i];
            }
            i = i + b + 1;
          }
          return res;
        }
    },
    mounted() {
      shortcuts.forEach(e => {
        shrtMap.set(e["shortcut"], e["emoji"]);
      });
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
  background-color: #AEBBC2;
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
  font-family: "proxima-nova", "Source Sans Pro", sans-serif, "Twemoji Mozilla";
  float: left;
  border: none;
  width: 100%;
  padding: 9px 32px 8px 8px;
  font-size: 1.0em;
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

.message-input .wrap i:hover {
  color: #597590!important;
  cursor: pointer;
}

.message-input .wrap i {
  font-size: 2.55em;
  margin-bottom: 1px;
  color:white;
}

.emojis:hover {
  color: #597590!important;
}

</style>