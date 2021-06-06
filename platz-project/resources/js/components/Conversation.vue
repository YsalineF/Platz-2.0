<template>
  <div>
    <!-- <input type="text" v-model="textInput"> -->
    <div class="conversation">
      <div class="user-info">
        <img class="user-avatar" v-if="user.image" :src="`assets/img/${user.image}`" :alt="user.name" />
        <img class="user-avatar" v-else src="assets/img/avatar.png" :alt="user.name" />
        <p class="username">{{ user.name }}</p>
      </div>
      <div>
        <ul class="conversation-window">
          <div v-for="message in conversations" :key="message.id">
            <li v-if="message.from_id === user.id" class="message">{{ message.content }}</li>
            <li v-else class="message message-from-connected-user">{{ message.content }}</li>
            <p v-if="message.from_id === user.id" class="message-date">{{ dateFormat(message.created_at) }}</p>
            <p v-else class="message-date message-from-connected-user-date">{{ dateFormat(message.created_at) }}</p>
          </div>
        </ul>
          <form action="" class="form-message" @submit.prevent="addMessage">
            <input class="input-message" type="text" name="text" v-model="messageForm.content" placeholder="Type your message here">
          </form>
      </div>
    </div>
    
  </div>
</template>

<script>
import moment from 'moment'

export default {
  props: ["id"],
  data() {
    return {
      messageForm: {
        'from_id': null,
        'to_id': null,
        'content': ""
      }
    }
  },
  computed: {
    user() {
      return this.$store.getters.getUserById(this.id)
    },
    conversations() {
    console.log(this.$store.getters.getConversationsById(this.id, this.$store.state.connectedUser.id))
      return this.$store.getters.getConversationsById(this.id, this.$store.state.connectedUser.id)
    }
  },
  methods: {
    dateFormat(value) {
      if(value) {
        return moment(String(value)).format('MMMM Do YYYY, h:mm a')
      }
    },
    addMessage() {
      this.messageForm.from_id = this.$store.state.connectedUser.id
      this.messageForm.to_id = this.id
      let messageForm = new FormData();
      messageForm.append("from_id", this.messageForm.from_id)
      messageForm.append("to_id", this.messageForm.to_id)
      messageForm.append("content", this.messageForm.content)

      axios.post('api/conversations/add', messageForm)

      this.messageForm.content = "";
    }
  }

}
</script>

<style lang="css" scoped>
.conversation {
  background: white;
  position: absolute;
  top: 22%;
  left: 35%;
  width: 500px;
  font-family: Helvetica, sans-serif;
  border: 1px solid black;
  z-index: 9999;
  
}
.user-info {
  position: relative;
}
.user-avatar {
  position: absolute;
  width: 9%;
  left: 30%;
}
.username {
  font-family: Helvetica, sans-serif;
  font-weight: bold;
  font-size: 1.5em;
  border-bottom: 1px solid black;
  margin-top: 0;
  margin-bottom: 5px;
  padding: 2% 0 2% 0;
  text-align: center;
  background: lightsteelblue;
}
.conversation-window {
  height: 350px;
  max-height: calc(100vh - 200px);
  /* Permet le scroll vers le haut et le bas pour voir le reste du contenu */
  overflow-x: hidden;
  overflow-y: scroll;
}
.message {
  font-family: Helvetica, sans-serif;
  border: 1px solid black;
  border-radius: 25%;
  width: 30%;
  margin: 5% 5% 0 5%;
  padding: 2% 3% 2% 3%;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
  border-bottom-left-radius: 15px;
  border-bottom-right-radius: 15px;
}
.message-from-connected-user {
  margin-left: auto; 
  margin-right: 5%;
}
.message-date {
  font-size: x-small;
  margin: 0 0 0 7%;
}
.message-from-connected-user-date {
  float: right;
  margin-right: 7%;
}
.form-message {
  background: lightgrey;
  margin-top: 2%;
  /* Permet de "coincer" la barre au bottom de la fenêtre de discussion */
  position: relative;
  bottom: 0px;
}
.input-message {
 padding: 1% 2% 1% 2%;
 margin: 1% 27% 1% 27%;
 width: 45%;
 height: 20px; 
 border-top-left-radius: 15px;
 border-top-right-radius: 15px;
 border-bottom-left-radius: 15px;
 border-bottom-right-radius: 15px;
}
</style>
