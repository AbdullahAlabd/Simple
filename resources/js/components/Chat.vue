<template>
  <div id="frame">
    <side-panel v-bind:user="user" v-bind:activeContact="activeContact" v-bind:contactList="contactList" @filterContacts="filterContacts" @changeConversation="changeConversation"></side-panel>
    <conversation></conversation>
  </div>
</template>

<script>
import SidePanel from './SidePanel';
export default {
  props: ['user'],
  mounted(){
  },
  data() {
    return {
      activeContact: 1,
      contactList: [
        {
          id: 0,
          onlineStatus: true,
          imgUrl: "http://emilcarlsson.se/assets/louislitt.png",
          name: "Louis Litt",
          preview: {
            sendByCur: true,
            text: "You just got LITT up, Mike."
          }
        },
        {
          id: 1,
          onlineStatus: true,
          imgUrl: "http://emilcarlsson.se/assets/harveyspecter.png",
          name: "Harvey Specter",
          preview: {
            sendByCur: false,
            text:
              "Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things."
          }
        },
        {
          id: 2,
          onlineStatus: false,
          imgUrl: "http://emilcarlsson.se/assets/rachelzane.png",
          name: "Rachel Zane",
          preview: {
            sendByCur: false,
            text:
              "I was thinking that we could have chicken tonight, sounds good?"
          }
        },
        {
          id: 3,
          onlineStatus: true,
          imgUrl: "http://emilcarlsson.se/assets/donnapaulsen.png",
          name: "onna Paulsen",
          preview: {
            sendByCur: false,
            text: "Mike, I know everything! I'm Donna.."
          }
        },
        {
          id: 4,
          onlineStatus: false,
          imgUrl: "http://emilcarlsson.se/assets/jessicapearson.png",
          name: "Jessica Pearson",
          preview: {
            sendByCur: false,
            text: "Have you finished the draft on the Hinsenburg deal?"
          }
        },
        {
          id: 5,
          onlineStatus: false,
          imgUrl: "http://emilcarlsson.se/assets/haroldgunderson.png",
          name: "Harold Gunderson",
          preview: {
            sendByCur: false,
            text: "Thanks Mike! :)"
          }
        }
      ]
      ,originalContactList: [
        {
          id: 0,
          onlineStatus: true,
          imgUrl: "http://emilcarlsson.se/assets/louislitt.png",
          name: "Louis Litt",
          preview: {
            sendByCur: true,
            text: "You just got LITT up, Mike."
          }
        },
        {
          id: 1,
          onlineStatus: true,
          imgUrl: "http://emilcarlsson.se/assets/harveyspecter.png",
          name: "Harvey Specter",
          preview: {
            sendByCur: false,
            text:
              "Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things."
          }
        },
        {
          id: 2,
          onlineStatus: false,
          imgUrl: "http://emilcarlsson.se/assets/rachelzane.png",
          name: "Rachel Zane",
          preview: {
            sendByCur: false,
            text:
              "I was thinking that we could have chicken tonight, sounds good?"
          }
        },
        {
          id: 3,
          onlineStatus: true,
          imgUrl: "http://emilcarlsson.se/assets/donnapaulsen.png",
          name: "onna Paulsen",
          preview: {
            sendByCur: false,
            text: "Mike, I know everything! I'm Donna.."
          }
        },
        {
          id: 4,
          onlineStatus: false,
          imgUrl: "http://emilcarlsson.se/assets/jessicapearson.png",
          name: "Jessica Pearson",
          preview: {
            sendByCur: false,
            text: "Have you finished the draft on the Hinsenburg deal?"
          }
        },
        {
          id: 5,
          onlineStatus: false,
          imgUrl: "http://emilcarlsson.se/assets/haroldgunderson.png",
          name: "Harold Gunderson",
          preview: {
            sendByCur: false,
            text: "Thanks Mike! :)"
          }
        }
      ]
    };
  },
  components: {
    SidePanel
  },
  methods: {
    ld() {
      
      console.log(user);
    },

    changeConversation(to) {
      this.$data.activeContact = to;
    },
    
    filterContacts(filter = '') {
      console.log(filter);
      let s = ''
      s.toLowerCase()
      console.log(this.originalContactList);
      this.contactList = this.originalContactList.filter(e => (filter).toLowerCase() == e.name.substring(0, filter.length).toLowerCase());
    }
  
  },
  c() {
    this.originalContactList = contactList;
  }
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
