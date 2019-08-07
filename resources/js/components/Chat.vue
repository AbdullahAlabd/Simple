<template>
  <div id="frame">
    <side-panel v-bind:user="user" v-bind:activeContact="activeContact" v-bind:contactList="contactList" @filterContacts="filterContacts" @changeConversation="changeConversation"></side-panel>
    <conversation></conversation>
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
      console.log(res);
      console.log(this.user.id);
      this.originalContactList = res.data;
      this.contactList = res.data;
      this.activeContact = res.data[0].conversation_id;
    })
    .catch(e => {
      console.log(e);
    });
    
  },
  data() {
    return {
      activeContact: 1,
      contactList: [
      ]
      ,originalContactList: [
      ]
    };
  },
  components: {
    SidePanel
  },
  methods: {
    changeConversation(to) {
      this.$data.activeContact = to;
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
