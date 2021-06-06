<!-- NAVBAR -->
<template>

<div id="wrapper-navbar">
  <div class="navbar object">

    <div id="wrapper-bouton-icon" v-for="categorie in categories" :key="categorie.id">
      <router-link :to="{name: 'categories.show', params: { id: categorie.id }}">
        <div id="bouton-theme">
          <img :src="'assets/img/' + categorie.icone" alt="" title="" height="28" width="28">
        </div>
      </router-link>
    </div>
    <router-link id="wrapper-bouton-icon" :to="{name: 'index'}">
      <div id="bouton-premium">
          <img :src="'assets/img/icon-premium.svg'" alt="no filter" title="No Filter" height="38" width="90">
      </div>
    </router-link>

    <router-link v-if="$store.state.connectedUser" to="/add">
      <button class="button-add" type="button" name="button">Add a resource</button>
    </router-link>
    <router-link v-if="$store.state.connectedUser && $route.name === 'show'" :to="`/edit/${ressourceId}`">
      <button class="button-edit" type="button" name="button">Edit resource</button>
    </router-link>
    <!-- Utilisation de <a> car router-link ne fonctionne pas sans le "to" -->
    <a v-if="$store.state.connectedUser && $route.name === 'show'">
      <button class="button-delete" v-on:click="deleteRessource()" type="button" name="button">Delete resource</button>
    </a>
  </div>
</div>

</template>

<script>
export default {
  data() {
    return {
      /**
       * Initialise à null id
       */
      params: {
        id: ''
      }
    }
  },
  computed: {
    /**
     * Retourne toutes les catégories
     *
     * @return  {[type]}  [return les catégories]
     */
    categories() {
      return this.$store.getters.getCategories;
    },
    /**
     * Retourne l'id de la ressource actuelle, trouvée via l'url, et permet d'avoir accès au bouton pour accèder au formulaire d'édition de la ressource
     *
     * @return  {[type]}  [return l'id de la ressource actuelle]
     */
    ressourceId() {
      let ressourceId = this.$route.params.id
      return ressourceId
    }
  },
  methods: {
    /**
     * Permet de supprimer la ressource actuelle
     * La suppression se fait via l'id de la ressource, transmise via la data ressourceId
     * On utilise la route axios "api/delete" et on est redirigé sur la page d'accueil
     *
     * @return  {[type]}  [return description]
     */
    deleteRessource() {
      this.params.id = this.ressourceId
      axios.post('api/delete', this.params)
      this.$router.push("/")
    }
  }
}

</script>
<style lang="css" scoped>
.button-add, .button-edit, .button-delete {
  display: block;
  float: left;
  font-family: Helvetica, sans-serif;
  width: auto;
  height: auto;
  margin-top: 20px;
  border-radius: 5px;
}
.button-edit, .button-delete {
  margin-left: 10px;
}
</style>
