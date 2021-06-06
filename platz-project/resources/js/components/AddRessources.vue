<template>
  <div class="add-page" v-if="$store.state.connectedUser">
    <h2>Platz</h2>
    <h3>Add a resource</h3>

    <form class="form-add" action="#" @submit.prevent="addResource">
      <div class="form-element">
        Name
        <input type="text" name="nom" placeholder="name" v-model="addForm.nom" value="" required>
      </div>
      <div class="form-element">
        Description
        <textarea name="name" rows="8" cols="80" placeholder="description" v-model="addForm.description" required></textarea>
      </div>
      <div class="form-element">
        Image
        <input type="file" @change="imageChange" name="image" value="" required>
        <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview"/>
      </div>
      <div class="form-element">
        Categorie
        <select class="" v-model="addForm.categorie" name="" required>
          <option value="">Categorie</option>
          <option v-for="categorie in categories" :key="categorie.id" :value="categorie.id">{{ categorie.nom }}</option>
        </select>
      </div>
      <div class="form-element">
        Size
        <input type="number" name="Size" placeholder="size" v-model="addForm.size" value="">
      </div>
      <button>Add resource</button>
    </form>
  </div>
</template>

<script>

export default {
  data() {
    return {
      /**
       * Instancie un tableau avec ses éléments à null
      */
      addForm: {
        nom: '',
        description: '',
        image: '',
        categorie: '',
        user: '',
        size: 0
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
      this.addForm.image = event.target.files[0];

      let reader  = new FileReader();
      reader.addEventListener("load", function () {
        this.showPreview = true;
        this.imagePreview = reader.result;
      }.bind(this), false);
      if( this.addForm.image ){
        if ( /\.(jpeg|png|gif|jpg)$/i.test( this.addForm.image.name ) ) {
          reader.readAsDataURL( this.addForm.image );
          // console.log(reader.readAsDataURL( this.addForm.image ))
        }
      }
    },
    
    /**
     * Permet d'ajouter une ressource 
     * On instancie un objet FormData qu'on rempli avec les éléments du formulaire (qui a été rempli par le user)
     * Lorsque le nouveau tableau a été rempli avec les informations, on utilise la route axios "api/add"
     * et on est redirigé vers la page d'accueil
     * @return  {[type]}  [return description]
     */
    addResource(){
      this.addForm.user = this.$store.state.connectedUser.id;

      // Inspiration : https://stackoverflow.com/questions/49587831/how-to-append-files-and-data-to-formdata-in-vue-js
      let addForm = new FormData();
      addForm.append("nom", this.addForm.nom);
      addForm.append("description", this.addForm.description);
      addForm.append("image", this.addForm.image);
      addForm.append("categorie", this.addForm.categorie);
      addForm.append("user", this.addForm.user);
      addForm.append("size", this.addForm.size);

      axios.post('api/add', addForm)
      this.$router.push("/")
    },
  }
}

</script>

<style lang="css" scoped>
.add-page {
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
