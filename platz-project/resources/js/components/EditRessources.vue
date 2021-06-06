<template>
  <div class="edit-page" v-if="$store.state.connectedUser">
    <h2>Platz</h2>
    <h3>Edit resource</h3>

    <form action="#" @submit.prevent="editRessource">
      <div class="form-element">
        Name
        <input type="text" name="nom" placeholder="name" v-model="editForm.nom">
      </div>
      <div class="form-element">
        Description
        <textarea name="description" rows="8" cols="80" placeholder="description" v-model="editForm.description"></textarea>
      </div>
      <div class="form-element">
        Image
        <input type="file" @change="imageChange" name="image" value="">
        <img :src="`assets/img/${ressource.image}`" v-if="!imagePreview" />
        <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview"/>
      </div>
      <div class="form-element">
        Categorie
        <select class="" v-model="editForm.categorie" name="">
          <option value="">Categorie</option>
          <option v-for="categorie in categories" :key="categorie.id" :value="categorie.id">{{ categorie.nom }}</option>
        </select>
      </div>
      <div class="form-element">
        Size
        <input type="number" name="Size" placeholder="size" v-model="ressource.size" value="">
      </div>
      <button>Save changes</button>
    </form>

  </div>
</template>

<script>
export default {
  data() {
    return {
      /**
       * Instancie le tableau "editForm" avec des éléments null
       */
      editForm: {
        id: null,
        nom: '',
        description: '',
        image: '',
        categorie: '',
        user: ''
      },
      /**
       * Instancie "imagePreview" à null et "showPreview" à false
       */
      imagePreview: null,
      showPreview: false,
    }
  },
  computed: {
    /**
     * Retourne toutes les catégories
     *
     * @return  {[type]}  [retourne toutes les catégories]
     */
    categories() {
      return this.$store.getters.getCategories
    },
    /**
     * Retourne la ressource dont l'id correspond à celle présente dans l'URL
     *
     * @return  {[type]}  [retourne une ressource]
     */
    ressource() {
      let id = this.$route.params.id
      return this.$store.getters.getRessourceById(id)
    },
    /**
     * Retourne la catégorie de la ressource actuelle
     *
     * @return  {[type]}  [retourne la catégorie de la ressource actuelle]
     */
    categorie() {
      return function(ressource) {
        return this.$store.getters.getCategoriesByRessourceId(ressource)
      }
    }
  },
  methods: {
    /**
     * Permet de preview l'image ajouté par le user et de l'ajouter au tableau
     * Inspiration https://www.youtube.com/watch?v=VqnJwh6E9ak & https://stackoverflow.com/questions/47650154/how-do-i-upload-image-in-vuejs/58231597
     * https://stackoverflow.com/questions/29732756/how-to-validate-image-file-extension-with-regular-expression-using-javascript/29732854
     * @param   {[type]}  event  [event description]
     *
     * @return  {[type]}         [return description]
     */
    imageChange(event){
      this.editForm.image = event.target.files[0];

      let reader  = new FileReader();
      reader.addEventListener("load", function () {
        this.showPreview = true;
        this.imagePreview = reader.result;
      }.bind(this), false);
      if( this.editForm.image ){
        if ( /\.(jpeg|png|gif)$/i.test( this.editForm.image.name ) ) {
          reader.readAsDataURL( this.editForm.image );
        }
      }
    },
    
    /**
     * Permet d'éditer la ressource choisie
     * On instancie un objet FormData qu'on rempli avec les éléments actuels de la ressource (voir "created()")
     * Lorsque le nouveau tableau a été rempli avec les informations, on utilise la route axios "api/edit"
     * et on est redirigé vers la page d'accueil
     * @return  {[type]}  [return description]
     */
    editRessource() {
      this.editForm.user = this.$store.state.connectedUser.id
      let editForm = new FormData();
      editForm.append("id", this.editForm.id);
      editForm.append("image", this.editForm.image);
      editForm.append("nom", this.editForm.nom);
      editForm.append("description", this.editForm.description);
      editForm.append("categorie", this.editForm.categorie);
      editForm.append("user", this.editForm.user);
      axios.post('api/edit', editForm)
      this.$router.push("/")
    }
  },

  /**
   * Remplit le tableau "editForm" (instancier à vide dans les data) avec les éléments actuels de la ressource au chargement de la page
   *
   * @return  {[type]}  [return description]
   */
  created() {
    this.editForm.nom = this.ressource.nom
    this.editForm.description = this.ressource.description
    this.editForm.categorie = this.ressource.categorie_id
    this.editForm.id = this.$route.params.id
    this.editForm.image = this.ressource.image
  }

}
</script>

<style lang="css" scoped>
.edit-page {
  display: block;
  justify-content: center;
  text-align: center;
  font-family: Helvetica, sans-serif;
}
.form-element {
  margin-bottom: 10px;
  vertical-align: center;
}
</style>
