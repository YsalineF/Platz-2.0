<template>
  <div>
    <h1 class="title">Platz - Conversations</h1>
    <ul class="users-list">
      <li class="user" v-for="user in filteredUsers" :key="user.id">
        <img class="user-avatar" v-if="user.image" :src="`assets/img/${user.image}`" :alt="user.name" />
        <img class="user-avatar" v-else src="assets/img/avatar.png" :alt="user.name" />
        <router-link :to="{ name: 'Conversation', params: {id: user.id, name: user.name}}" class="username">{{user.name}}</router-link>
      </li>
    </ul>
    <router-view></router-view>
  </div>
</template>


<script>
export default {
  data() {
    return {
      
    }
  },
  computed: {
    /**
     * Retourne la liste des users enregistrés sur le site
     *
     * @return  {[type]}  [retourne tous les users]
     */
    users() {
      return this.$store.getters.getUsers
    },
    /**
     * Retourne la liste des users filtrée, c'est-à-dire sans le user connecté
     *
     * @return  {[type]}  [retourne la liste des users sans le user connecté]
     */
    filteredUsers() {
      return this.users.filter(user => user.id != this.$store.state.connectedUser.id)
    }
  }
}
</script>

<style lang="css" scoped>
.title {
  text-align: center;
  font-family: Helvetica, sans-serif;
}
.users-list {
  width: 10%;
  margin: 40px 0px 0px 100px;
}
.user {
  position: relative;
  border: solid 1px black;
  border-bottom: none;
  font-family: Helvetica, sans-serif;
  padding: 7px 0 7px 10px;
}
.user:nth-last-child(1) {
  border-bottom: solid 1px black;
}
.user-avatar {
  width: 30%;
}
.username {
  position: absolute;
  margin: 0;
  top: 50%;
  transform: translateY(-50%);
  left: 40%;
}
</style>
