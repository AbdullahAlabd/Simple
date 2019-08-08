<template>
  <div id="frame">
    <side-panel v-if="contactList" v-bind:user="user" v-bind:activeContact="activeContact" v-bind:contactList="contactList" @filterContacts="filterContacts" @changeConversation="changeConversation"></side-panel>
    <conversation v-if="targetID" v-bind:conversationId="activeContact" v-bind:user="user" v-bind:messages="messages" v-bind:targetID="targetID"></conversation>
  </div>
</template>

<script>
import SidePanel from './SidePanel';
import Axios from 'axios';
export default {
  props: ['user'],
  mounted(){
    Axios.get('/conversations/showAll/'+this.user.id)
    .then(res => {
      this.originalContactList = res.data;
      this.contactList = res.data;
      this.targetID = this.contactList[0].target_id;
      this.changeConversation(res.data[0]);
    })
    .catch(e => {
      console.log(e);
    });
    
  },
  data() {
    return {
      activeContact: null,
      contactList: [],
      originalContactList: [],
      messages: [],
      targetID: null
    };
  },
  components: {
    SidePanel
  },
  methods: {
    changeConversation(data) {
      Axios.get('/messages/showAll/'+data.conversation_id)
      .then(res => {
        this.messages = res.data;
        this.$data.activeContact = data.conversation_id;
        this.targetID = data.target_id;
      })
      .catch(e => {
        console.log(e);
      })
    },
    
    filterContacts(filter = '') {
      this.contactList = this.originalContactList.filter(e => (filter).toLowerCase() == e.name.substring(0, filter.length).toLowerCase());
    }
  },
};
</script>

<style scoped>
body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background: #27ae60;
  font-family: "proxima-nova", "Source Sans Pro", sans-serif;
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
  /* max-width: 1000px; */
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
