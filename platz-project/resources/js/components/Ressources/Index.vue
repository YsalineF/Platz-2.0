<template>
  <div>
    <div class="container object">
      <div id="main-container-image">
        <button v-on:click="sendMessage('Hello')">Send message</button>
        <section class="work" v-for="ressource in ressources" :key="ressource.id">

          <figure class="white">
            <router-link :to="{name: 'ressourceShow', params: { id: ressource.id }}">
              <img :src="`assets/img/${ressource.image}`" :alt="ressource.nom" />
              <dl>
                <dt>{{ ressource.nom }}</dt>
                <dd>{{ ressource.description }}</dd>
              </dl>
            </router-link>
            <div id="wrapper-part-info">
              <div class="part-info-image">
                <img :src="`assets/img/${categories(ressource).icone}`" :alt="categories(ressource).nom" width="28" height="28"/>
              </div>
              <div id="part-info">{{ categories(ressource).nom }}</div>
            </div>
          </figure>

        </section>

      </div>
    </div>

    <div id="wrapper-oldnew">
      <div class="oldnew">
        <div class="wrapper-oldnew-prev">
          <div id="oldnew-prev" @click="previousRessources"></div>
        </div>
        <div class="wrapper-oldnew-next">
          <div id="oldnew-next" @click="moreRessources"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // ressouces,
      params: {
        start: 0,
        end: 20,
        more: 20
      },
      // connexion websocket
      connection: "null"
    }
  },
  /**
   * Mise en place d'un simple websocket.
   * A la création de la page, une connexion au serveur websocket est établie et un message dans le console s'affiche pour confirmer le début de la connexion
   * et le fait qu'on est bien connecté au serveur websocket
   *
   * @return  {[type]}  [return description]
   */
  created() {
      console.log("Starting connection to websocket server")
      this.connection = new WebSocket("wss://echo.websocket.org")

      this.connection.onmessage = function(event) {
        console.log(event)
      }

      this.connection.onopen = function(event) {
        console.log(event)
        console.log("successfully connected to echo websocket server !")
      }
    },
  computed: {
    /**
     * Retourne toutes les catégories 
     *
     * @return  {[type]}  [retourne des ressoures]
     */
    ressources() {
      // On récupère l'id de la catégorie de l'id dans l'URL (dans le cas où un filtre est appliqué)
      let idCat = this.$route.params.id;

      // Si l'id de la catégorie est différent à undefined, cela veut dire qu'un filtre est appliqué
      if (typeof idCat !== 'undefined'){
        // Retourne les ressources qui ont la catégorie concernée par le filtre
        return this.$store.getters.getRessourcesByCategorieId(this.$route.params.id);
      }

      // Si aucun filtre est appliqué, retourne un certain nombre de ressources (le nombre dépend des params)
      return this.$store.getters.getRessources(this.params)
    },
    /**
     * Retourne la catégorie de la ressource choisie
     *
     * @return  {[type]}  [retourne la catégorie de la ressource choisie]
     */
    categories() {
      return function(ressource) {
        return this.$store.getters.getCategoriesByRessourceId(ressource)
      }
    },
  },
  methods: {
    // Permet de charger plus de ressources (nombre defini via l'element "more" des params)
    moreRessources() {
      // On verifie si l'element "end" des params est plus grand/égal au nombre de ressources dans la db
      // si c'est le cas, on "réinitialise" le params "start" à 20 et le params "end" avec le nombre de ressources dans la db
      if(this.params.end >= this.$store.state.ressources.length) {
        this.params.start = 20
        this.params.end = this.$store.state.ressources.length
        // Appel de la methode scrollToTop().
        // Si on ne l'utilise pas, on reste en bas de la fenetre
        this.scrollToTop()
      }
      // Si l'element "end" des params est plus petit que le nombre de ressources dans la db
      // On ajoute aux params "start" et "end", le params "more"
      else {
        this.params.start += this.params.more
        this.params.end += this.params.more
        this.scrollToTop()
      }
    },
    // Permet de charger les ressources précédentes (ex: les 20 dernières) si on a chargé les 20 suivantes
    previousRessources() {
      // On verifie si l'element "start" des params est different de 0
      // si c'est le cas, on retire l'element "more" aux elements "start" et "end" des params
      if(this.params.start !== 0) {
        this.params.start -= this.params.more
        this.params.end -= this.params.more
        // Appel de la methode scrollToTop(), si on ne l'utilise pas, on reste en bas de la fenetre
        this.scrollToTop()
      }
    },
    // Permet de scroll au top de la fenetre quand on charge plus/moins de ressources
    scrollToTop() {
      // Inspiration https://stackoverflow.com/questions/50449123/vue-js-scroll-to-top-of-page-for-same-route
      window.scrollTo(0,0)
    },
    // Permet d'envoyer un message via le button "send message"
    sendMessage(message) {
      // affiche dans la console la data "connection"
      console.log(this.connection)
      // affiche dans la console l'événement "MessageEvent"
      this.connection.send(message)
      // ouvre une fenêtre popup avec le message "Successfully connected !"
      alert('Successfully connected to the Websocket server !')
    }
  }
}
</script>

<style lang="css" scoped>
</style>
