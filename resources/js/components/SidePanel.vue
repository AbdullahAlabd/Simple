<template>
  <div id="sidepanel">
    <div id="profile" v-bind:class="{expanded: profileToggle}">
      <div class="wrap">
        <img id="profile-img" v-bind:src="'storage/'+user.image" class="online" alt />
        <p>{{user.name}}</p>
        <i class="material-icons-round expand-button" @click="toggleProfile">expand_more</i>
        <div id="expanded">
          <img v-bind:src="'storage/'+user.image" class="profile-img-side mx-5 mb-2" alt />
          <input
            type="file"
            name="photo"
            id="photo"
            placeholder="Choose another photo"
            accept="image/*"
          />
          <input
            name="handle"
            type="text"
            v-bind:value="'@'+handle"
            disabled
            readonly
            class="mx-1"
            title="Handle"
          />
          <input name="name" type="text" v-model="name" title="Name" maxlength="50" class="mx-1" />
          <input
            name="status"
            type="text"
            v-model="status"
            title="Status"
            maxlength="200"
            class="mx-1"
          />
          <button
            name="editProfile"
            class="btn btn-primary"
            @click="saveChanges"
            style="margin-left:56px"
          >Save Changes</button>
        </div>
      </div>
    </div>
    <div id="search">
      <label for>
        <i class="material-icons-round">search</i>
      </label>
      <input type="text" placeholder="Search contacts..." @input="searchUser($event.target.value)" />
    </div>
    <div id="contacts" v-bind:class="{expanded: profileToggle}">
      <ul v-if="contactList.length">
        <li
          class="contact"
          v-bind:contactList="contactList"
          v-bind:curConversationID="curConversationID"
          v-for="contact in contactList"
          v-bind:key="contact.conversation_id"
          @click="$emit('changeConversation', contact)"
          :class="{active: curConversationID===contact.conversation_id}"
        >
          <div class="wrap">
            <span class="contact-status" v-bind:class="{online: true}"></span>
            <img :src="'storage/'+contact.image" alt />
            <p class="date">{{contact.created_at}}</p>
            <div class="meta">
              <p class="name">{{contact.name}}</p>
              <p class="preview">
                <span v-if="contact.sender_id===user.id">You:</span>
                {{contact.content}}
              </p>
            </div>
          </div>
        </li>
      </ul>
      <p v-else class="text-center pt-4 px-5">
        There are
        <strong>no such chats</strong> for users with this name.
        <br />
        <br />To
        <strong>add a new contact</strong> type the handle in search bar and hit enter.
        <br />
        <br />Handle should look like
        <strong>@username</strong>
      </p>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
export default {
  name: "SidePanel",

  props: ["user", "curConversationID", "contactList"],
  methods: {
    searchUser(text) {
      let s = "";
      if (text.charAt(0) !== "@") {
        this.$emit("filterContacts", text);
      }
    },
    toggleProfile() {
      this.profileToggle = !this.profileToggle;
    },
    saveChanges() {
      if (document.getElementById("photo").files) {
        let data = new FormData();
        data.append("image", document.getElementById("photo").files[0]);
        Axios.post("/api/profiles/" + this.user.id, data)
          .then(res => {})
          .catch(e => {
            console.log(e);
          });
      }
      Axios.post("/api/profiles/" + this.user.id, {
        name: this.name,
        about: this.status
      });
    }
  },
  data() {
    return {
      profileToggle: false,
      name: this.user.name,
      handle: this.user.handle,
      status: this.user.status
    };
  },
  mounted() {
    Axios.get("/profiles/info/" + this.user.id)
      .then(res => {
        this.name = res.data.name;
        this.status = res.data.about;
      })
      .catch(e => {
        console.log(e);
      });
  }
};
</script>

<style scoped>
#sidepanel {
  float: left;
  min-width: 280px;
  max-width: 340px;
  width: 40%;
  height: 100%;
  background: #2c3e50;
  color: #f5f5f5;
  overflow: hidden;
  position: relative;
}
@media screen and (max-width: 735px) {
  #sidepanel {
    width: 58px;
    min-width: 58px;
  }
}

@media screen and (min-width: 865px) and (max-width: 899px){
  #sidepanel {
    min-width: 40%;
  }
}

#sidepanel #profile {
  width: 80%;
  margin: 25px auto;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile {
    width: 100%;
    margin: 0 auto;
    padding: 5px 0 0 0;
    background: #32465a;
  }
}
#sidepanel #profile.expanded .wrap {
  min-height: 210px;
  height: auto;
  line-height: initial;
}
#sidepanel #profile.expanded .wrap p {
  margin-top: 20px;
}
#sidepanel #profile.expanded .wrap i.expand-button {
  -moz-transform: scaleY(-1);
  -o-transform: scaleY(-1);
  -webkit-transform: scaleY(-1);
  transform: scaleY(-1);
  filter: FlipH;
  -ms-filter: "FlipH";
}
#sidepanel #profile .wrap {
  height: 60px;
  line-height: 60px;
  overflow: hidden;
  -moz-transition: 0.3s height ease;
  -o-transition: 0.3s height ease;
  -webkit-transition: 0.3s height ease;
  transition: 0.3s height ease;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap {
    height: 55px;
  }
}
#sidepanel #profile .wrap #profile-img {
  width: 50px;
  border-radius: 50%;
  padding: 3px;
  border: 2px solid #e74c3c;
  height: auto;
  float: left;
  cursor: pointer;
  -moz-transition: 0.3s border ease;
  -o-transition: 0.3s border ease;
  -webkit-transition: 0.3s border ease;
  transition: 0.3s border ease;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap img {
    width: 40px;
    margin-left: 4px;
  }
}
#sidepanel #profile .wrap #profile-img.online {
  border: 2px solid #2ecc71;
}
#sidepanel #profile .wrap img.away {
  border: 2px solid #f1c40f;
}
#sidepanel #profile .wrap img.busy {
  border: 2px solid #e74c3c;
}
#sidepanel #profile .wrap img.offline {
  border: 2px solid #95a5a6;
}
#sidepanel #profile .wrap p {
  float: left;
  margin-left: 15px;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap p {
    display: none;
  }
}
#sidepanel #profile .wrap i.expand-button {
  float: right;
  margin-top: 16px;
  font-size: 2.0em;
  cursor: pointer;
  color: #435f7a;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap i.expand-button {
    display: none;
  }
}
#sidepanel #profile .wrap #status-options {
  position: absolute;
  opacity: 0;
  visibility: hidden;
  width: 150px;
  margin: 70px 0 0 0;
  border-radius: 6px;
  z-index: 99;
  line-height: initial;
  background: #435f7a;
  -moz-transition: 0.3s all ease;
  -o-transition: 0.3s all ease;
  -webkit-transition: 0.3s all ease;
  transition: 0.3s all ease;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap #status-options {
    width: 58px;
    margin-top: 57px;
  }
}
#sidepanel #profile .wrap #status-options.active {
  opacity: 1;
  visibility: visible;
  margin: 75px 0 0 0;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap #status-options.active {
    margin-top: 62px;
  }
}
#sidepanel #profile .wrap #status-options:before {
  content: "";
  position: absolute;
  width: 0;
  height: 0;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-bottom: 8px solid #435f7a;
  margin: -8px 0 0 24px;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap #status-options:before {
    margin-left: 23px;
  }
}
#sidepanel #profile .wrap #status-options ul {
  overflow: hidden;
  border-radius: 6px;
}
#sidepanel #profile .wrap #status-options ul li {
  padding: 15px 0 30px 18px;
  display: block;
  cursor: pointer;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap #status-options ul li {
    padding: 15px 0 35px 22px;
  }
}
#sidepanel #profile .wrap #status-options ul li:hover {
  background: #496886;
}
#sidepanel #profile .wrap #status-options ul li span.status-circle {
  position: absolute;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  margin: 5px 0 0 0;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap #status-options ul li span.status-circle {
    width: 14px;
    height: 14px;
  }
}

#sidepanel #profile .wrap #status-options ul li span.status-circle:before {
  content: "";
  position: absolute;
  width: 14px;
  height: 14px;
  margin: -3px 0 0 -3px;
  background: transparent;
  border-radius: 50%;
  z-index: 0;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap #status-options ul li span.status-circle:before {
    height: 18px;
    width: 18px;
  }
}
#sidepanel #profile .wrap #status-options ul li p {
  padding-left: 12px;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap #status-options ul li p {
    display: none;
  }
}

#sidepanel
  #profile
  .wrap
  #status-options
  ul
  li#status-online
  span.status-circle {
  background: #2ecc71;
}

#sidepanel
  #profile
  .wrap
  #status-options
  ul
  li#status-online.active
  span.status-circle:before {
  border: 1px solid #2ecc71;
}

#sidepanel #profile .wrap #status-options ul li#status-away span.status-circle {
  background: #f1c40f;
}

#sidepanel
  #profile
  .wrap
  #status-options
  ul
  li#status-away.active
  span.status-circle:before {
  border: 1px solid #f1c40f;
}

#sidepanel #profile .wrap #status-options ul li#status-busy span.status-circle {
  background: #e74c3c;
}

#sidepanel
  #profile
  .wrap
  #status-options
  ul
  li#status-busy.active
  span.status-circle:before {
  border: 1px solid #e74c3c;
}

#sidepanel
  #profile
  .wrap
  #status-options
  ul
  li#status-offline
  span.status-circle {
  background: #95a5a6;
}

#sidepanel
  #profile
  .wrap
  #status-options
  ul
  li#status-offline.active
  span.status-circle:before {
  border: 1px solid #95a5a6;
}
#sidepanel #profile .wrap #expanded {
  padding: 100px 0 0 0;
  display: block;
  line-height: initial !important;
}
#sidepanel #profile .wrap #expanded label {
  float: left;
  clear: both;
  margin: 0 8px 5px 0;
  padding: 5px 0;
}
#sidepanel #profile .wrap #expanded input {
  border: none;
  margin-bottom: 6px;
  background: #32465a;
  border-radius: 3px;
  color: #f5f5f5;
  padding: 7px;
  width: calc(100% - 43px);
}
#sidepanel #profile .wrap #expanded input:focus {
  outline: none;
  background: #435f7a;
}
#sidepanel #search {
  border-top: 1px solid #32465a;
  border-bottom: 1px solid #32465a;
  font-weight: 300;
}
@media screen and (max-width: 735px) {
  #sidepanel #search {
    display: none;
  }
}
#sidepanel #search label {
  position: absolute;
  margin: 10px 0 0 20px;
}
#sidepanel #search input {
  font-family: "proxima-nova", "Source Sans Pro", sans-serif;
  padding: 10px 0 10px 46px;
  /* width: calc(100% - 25px); */
  width: 100%;
  border: none;
  background: #32465a;
  color: #f5f5f5;
}
#sidepanel #search input:focus {
  outline: none;
  background: #435f7a;
}
#sidepanel #search input::-webkit-input-placeholder {
  color: #f5f5f5;
}
#sidepanel #search input::-moz-placeholder {
  color: #f5f5f5;
}
#sidepanel #search input:-ms-input-placeholder {
  color: #f5f5f5;
}
#sidepanel #search input:-moz-placeholder {
  color: #f5f5f5;
}
#sidepanel #contacts {
  /* height: calc(100% - 177px); */
  height: 100%;
  overflow-y: scroll;
  overflow-x: hidden;
}
@media screen and (max-width: 735px) {
  #sidepanel #contacts {
    /* height: calc(100% - 149px); */
    height: 100%;
    overflow-y: scroll;
    overflow-x: hidden;
  }
  #sidepanel #contacts::-webkit-scrollbar {
    display: none;
  }
}
#sidepanel #contacts.expanded {
  height: calc(100% - 334px);
}
#sidepanel #contacts::-webkit-scrollbar {
  width: 8px;
  background: #2c3e50;
}
#sidepanel #contacts::-webkit-scrollbar-thumb {
  background-color: #243140;
}
#sidepanel #contacts ul li.contact {
  position: relative;
  padding: 10px 0 15px 0;
  font-size: 0.9em;
  font-family: "proxima-nova", "Source Sans Pro", sans-serif, "Twemoji Mozilla";
  cursor: pointer;
}
@media screen and (max-width: 735px) {
  #sidepanel #contacts ul li.contact {
    padding: 6px 0 46px 8px;
  }
}
#sidepanel #contacts ul li.contact:hover {
  background: #32465a;
}
#sidepanel #contacts ul li.contact.active {
  background: #32465a;
  border-right: 5px solid #435f7a;
}
#sidepanel #contacts ul li.contact.active span.contact-status {
  border: 2px solid #32465a !important;
}
#sidepanel #contacts ul li.contact .wrap {
  width: 88%;
  margin: 0 auto;
  position: relative;
}
@media screen and (max-width: 735px) {
  #sidepanel #contacts ul li.contact .wrap {
    width: 100%;
  }
}
#sidepanel #contacts ul li.contact .wrap span {
  position: absolute;
  left: 0;
  margin: -2px 0 0 -2px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  border: 2px solid #2c3e50;
  background: #95a5a6;
}
#sidepanel #contacts ul li.contact .wrap span.online {
  background: #2ecc71;
}
#sidepanel #contacts ul li.contact .wrap span.away {
  background: #f1c40f;
}
#sidepanel #contacts ul li.contact .wrap span.busy {
  background: #e74c3c;
}
#sidepanel #contacts ul li.contact .wrap img {
  width: 40px;
  border-radius: 50%;
  float: left;
  margin-right: 10px;
}
@media screen and (max-width: 735px) {
  #sidepanel #contacts ul li.contact .wrap img {
    margin-right: 0px;
  }
}
#sidepanel #contacts ul li.contact .wrap .meta {
  padding: 5px 0 0 0;
  margin-bottom: 0px !important;
}
@media screen and (max-width: 735px) {
  #sidepanel #contacts ul li.contact .wrap .meta {
    display: none;
  }
}
#sidepanel #contacts ul li.contact .wrap .meta .name {
  left: 0;
  position: relative;
  font-weight: 600;
}
#sidepanel #contacts ul li.contact .wrap .meta .preview {
  margin: 5px 0 0 0;
  padding: 0 0 1px;
  font-weight: 400;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  -moz-transition: 1s all ease;
  -o-transition: 1s all ease;
  -webkit-transition: 1s all ease;
  transition: 1s all ease;
}
#sidepanel #contacts ul li.contact .wrap .meta p {
  margin-bottom: 0px !important;
}
#sidepanel #contacts ul li.contact .wrap .date {
  position: absolute !important;
  right: 0;
  top: 0;
  padding-top: 7px;
  font-size: 10px;
}

@media screen and (max-width: 735px) {
  #sidepanel #contacts ul li.contact .wrap .date {
    display: none;
  }
}
#sidepanel #contacts ul li.contact .wrap .meta .preview span {
  position: initial;
  border-radius: initial;
  background: none;
  border: none;
  padding: 0 2px 0 0;
  margin: 0 0 0 1px;
  opacity: 0.5;
}
#sidepanel #bottom-bar {
  position: absolute;
  width: 100%;
  bottom: 0;
}
#sidepanel #bottom-bar button {
  float: left;
  border: none;
  width: 50%;
  padding: 10px 0;
  background: #32465a;
  color: #f5f5f5;
  cursor: pointer;
  font-size: 0.85em;
  font-family: "proxima-nova", "Source Sans Pro", sans-serif;
}
@media screen and (max-width: 735px) {
  #sidepanel #bottom-bar button {
    float: none;
    width: 100%;
    padding: 15px 0;
  }
}
#sidepanel #bottom-bar button:focus {
  outline: none;
}
#sidepanel #bottom-bar button:nth-child(1) {
  border-right: 1px solid #2c3e50;
}
@media screen and (max-width: 735px) {
  #sidepanel #bottom-bar button:nth-child(1) {
    border-right: none;
    border-bottom: 1px solid #2c3e50;
  }
}
#sidepanel #bottom-bar button:hover {
  background: #435f7a;
}
#sidepanel #bottom-bar button i {
  margin-right: 3px;
  font-size: 1em;
}
@media screen and (max-width: 735px) {
  #sidepanel #bottom-bar button i {
    font-size: 1.3em;
  }
}
@media screen and (max-width: 735px) {
  #sidepanel #bottom-bar button span {
    display: none;
  }
}
.profile-img-side {
  width: 150px;
  margin-left: auto;
  margin-right: auto;
  border-radius: 30%;
  padding: 3px;
  border: 2px solid #4283c0;
  height: auto;
  cursor: pointer;
  -moz-transition: 0.3s border ease;
  -o-transition: 0.3s border ease;
  -webkit-transition: 0.3s border ease;
  transition: 0.3s border ease;
}
</style>