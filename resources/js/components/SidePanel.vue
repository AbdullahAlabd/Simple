<template>
  <div id="sidepanel">
    <div id="profile" v-bind:class="{expanded: profileToggle}">
      <div class="wrap">
        <img id="profile-img" v-bind:src="'storage/'+image" :class="{online: connected}" alt />
        <div class="d-flex flex-column name-handle">
          <strong style="height: 1em" >{{name}}</strong>
          <small style="height: 1em;" class="text-light">{{'@'+user.handle}}</small>
        </div>
        <i class="material-icons-round expand-button" @click="toggleProfile">expand_more</i>
        <div id="expanded">
          <!-- <hr class="bg-secondary"> -->
          <div class="img-container mb-2">
            <img v-bind:src="'storage/'+image" class="profile-img-side" alt />
            
              <div class="edit-cover mx-auto">
                <i class="material-icons-outlined">edit</i>
                <p class="text-light ">
                  <strong>Update Image</strong>
                </p>
                <input
                  type="file"
                  name="photo"
                  id="photo"
                  placeholder="Choose another photo"
                  accept="image/*"
                  title="click to choose another image"
                />
              </div>
              <div class="spinner-border loading" role="status" ref="loading">
                <span class="sr-only">Loading...</span>
              </div>
            
          </div>
          
          <input
            name="handle"
            type="text"
            v-bind:value="'@'+handle"
            disabled
            readonly
            title="Handle"
            style="border-top-left-radius: 15px;border-top-right-radius: 15px"
          />
          <input name="name" type="text" v-model="name" title="Name" maxlength="25" placeholder="Type your name"/>
          <textarea
            name="status"
            type="text"
            v-model="status"
            title="Status"
            maxlength="100"
            rows = '2'
            placeholder="Type your status"
            style="border-bottom-left-radius: 15px;border-bottom-right-radius: 15px;"  
          />
          <button
            name="editProfile"
            class="btn btn-primary"
            @click="saveChanges"
          >Save Changes</button>
          <div class="alert-container">

            <div class="alert alert-success alert-dismissible fade d-none" role="alert" id="imgSucAlert">
              Profile picture updated successfully.
              <button type="button" class="close" @click="clearAlert">&times;</button>
            </div>
            <div class="alert alert-danger alert-dismissible fade d-none" role="alert" id="imgFailAlert">
              Couldn't update the profile picture due to some error.
              <button type="button" class="close" @click="clearAlert">&times;</button>
            </div>
            <div class="alert alert-success alert-dismissible fade d-none" role="alert" id="infoSucAlert">
              Changes saved successfully.
              <button type="button" class="close" @click="clearAlert">&times;</button>
            </div>
            <div class="alert alert-danger alert-dismissible fade d-none" role="alert" id="infoFailAlert">
              Couldn't save the changes due to some error.
              <button type="button" class="close" @click="clearAlert">&times;</button>
            </div>
          </div>
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
    clearAlert() {
      $('.alert').removeClass('show');
      $('.alert').addClass('d-none');
    }
    ,saveChanges() {
      if (document.getElementById("photo").files[0]) {
        let data = new FormData();
        this.$refs.loading.style.display = 'block';
        data.append("image", document.getElementById("photo").files[0]);
        Axios.post("/api/profiles/" + this.user.id, data)
          .then(res => {
            $('#imgSucAlert').removeClass('d-none');
            $('#imgSucAlert').addClass('show');
            console.log(res);
            this.image = res.data.image;
            this.$refs.loading.style.display = 'none';
          })
          .catch(e => {
            $('#imgFailAlert').removeClass('d-none');;
            $('#imgFailAlert').addClass('show');
            this.$refs.loading.style.display = 'none';
            console.log(e);
          });
      }
      Axios.post("/api/profiles/" + this.user.id, {
        name: this.name,
        about: this.status
      }).then((res) => {
        $('#infoSucAlert').removeClass('d-none');
        $('#infoSucAlert').addClass('show');
      }).catch(e => {
        $('#infoFailAlert').removeClass('d-none');
        $('#infoFailAlert').addClass('show');
      });
    }
  },
  data() {
    return {
      profileToggle: false,
      name: this.user.name,
      handle: this.user.handle,
      status: this.user.status,
      image: this.user.image,
      connected: navigator.onLine
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

    window.addEventListener('online', () => {
      this.connected = true;
    });
    window.addEventListener('offline', () => {
      this.connected = false;
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
#sidepanel #profile.expanded{
  line-height: initial;
  min-height: 100vh;
  overflow-y: auto;
  height: auto;
  z-index: 99;
  
}
#sidepanel #profile.expanded .wrap {
  height:initial!important;
  line-height: 20px;
  padding-bottom: 10px;
}
#sidepanel #profile.expanded .wrap .name-handle {
  margin-top: 8px;
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

#sidepanel #profile .wrap img.offline {
  border: 2px solid #95a5a6;
}
#sidepanel #profile .wrap .name-handle{
  float: left;
  margin-left: 15px;
  margin-top: -12px;
}
@media screen and (max-width: 735px) {
  #sidepanel #profile .wrap .name-handle {
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
#sidepanel #profile .wrap #expanded {
  padding: 85px 0 0 0;
  display: block;
  line-height: initial !important;
  align-items: center!important;
  /* align-content: center!important; */
  text-align: center;

}

#sidepanel #profile .wrap #expanded input, #sidepanel #profile .wrap #expanded textarea{
  border: none;
  margin-bottom: 6px;
  background: #32465a;
  color: #f5f5f5;
  padding: 7px;
  width: 100%;
  /* border-radius: 10px; */
}
#sidepanel #profile .wrap #expanded input:focus, #sidepanel #profile .wrap #expanded textarea:focus {
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
  font-family: "proxima-nova", "Source Sans Pro", "Twemoji Mozilla";
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
.profile-img-side {
  width: calc(100% - 10px);
  border-radius: 60px;
  height: auto;
  -moz-transition: 0.3s border ease;
  -o-transition: 0.3s border ease;
  -webkit-transition: 0.3s border ease;
  transition: 0.3s border ease;
}

.alert-container {
  /* display: none; */
  position:absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding-right: 20px;
  padding-left: 20px;
  text-align: center;
}

.edit-cover{
  display: none;
  position:absolute;
  top: 75%;
  left: 50%;
  transform: translate(-50%, 0);
  background: black;
  opacity:0.5;
  width: calc(100% - 10px);
  height: 25%;
  border-bottom-left-radius: 60px;
  border-bottom-right-radius: 60px;
  cursor: pointer;
  overflow: hidden;
}
.edit-cover input[type=file]{
  opacity:0;
  font-size:300px;
  position:absolute;
  top:0;
  left:0;
  border-radius: 0px!important;
  padding: 0px!important;
}
.img-container{
  text-align: center;
  position: relative;
  width: auto;
  height: auto;
}

.img-container:hover .edit-cover{
  display: inline-block;
}

.loading{
  position: absolute;
  height: 60px;
  width: 60px;
  top: calc(50% - 30px);
  left: calc(50% - 30px);
  display:none;
}

.expanded textarea::placeholder, .expanded input::placeholder{
  color:darkgray;
}

button input[type=file], ::-webkit-file-upload-button{
    cursor:pointer;
}
</style>