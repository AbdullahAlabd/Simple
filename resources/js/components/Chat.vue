<template>
  <div id="frame">
    <side-panel
      v-bind:user="user"
      v-bind:curConversationID="curConversationID"
      v-bind:contactList="contactList"
      @filterContacts="filterContacts"
      @changeConversation="changeConversation"
    ></side-panel>
    <conversation
      v-bind:user="user"
      v-bind:curConversationID="curConversationID"
      v-bind:reciever="reciever"
      @convToTop="convToTop"
    ></conversation>
  </div>
</template>

<script>
import SidePanel from "./SidePanel";
import Axios from "axios";
export default {
  props: ["user"],
  mounted() {
    Axios.get("/conversations/showAll/" + this.user.id)
      .then(res => {
        this.originalContactList = res.data;
        this.contactList = res.data;
        this.curConversationID = this.contactList[0].conversation_id;
        this.changeConversation(this.contactList[0]);
      })
      .catch(e => {
        console.log(e);
      });
  },
  data() {
    return {
      curConversationID: null,
      contactList: [],
      originalContactList: [],
      reciever: null
    };
  },
  components: {
    SidePanel
  },
  methods: {
    changeConversation(data) {
      this.curConversationID = data.conversation_id;
      Axios.get("/profiles/info/" + data.target_id)
        .then(res => {
          this.reciever = res.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    convToTop(msg) {
      this.originalContactList.forEach((conv, index) => {
        if (conv.conversation_id === msg.conversation_id) {
          conv.created_at = msg.created_at;
          conv.sender_id = msg.sender_id;
          conv.content = msg.content;
          [this.originalContactList[index], this.originalContactList[0]] = [
            this.originalContactList[0],
            this.originalContactList[index]
          ];
        }
      });
      this.contactList = this.originalContactList;
    },
    filterContacts(filter = "") {
      this.contactList = this.originalContactList.filter(
        e =>
          filter.toLowerCase() ==
          e.name.substring(0, filter.length).toLowerCase()
      );
    }
  }
};
</script>

<style scoped>

@font-face {
  font-family: 'Twemoji Mozilla';
  src: url('../../fonts/Twemoji Mozilla v12.1.2.ttf');
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background: #27ae60;
  font-family: "proxima-nova", "Source Sans Pro", sans-serif, "Twemoji Mozilla";
  font-size: 1em;
  letter-spacing: 0.1px;
  color: #32465a;
  text-rendering: optimizeLegibility;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
  -webkit-font-smoothing: antialiased;
}

#frame {
  width: 100%;
  min-width: 360px;
  max-width: 100vw;
  height: 100vh;
  min-height: 300px;
  max-height: 720px;
  background: #e6eaea;
}
@media screen and (max-width: 360px) {
  #frame {
    width: 100%;
    height: 100vh;
  }
}
</style>
