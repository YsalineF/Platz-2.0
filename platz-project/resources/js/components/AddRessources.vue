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
      addForm: {
        nom: '',
        description: '',
        image: '',
        categorie: '',
        user: '',
        size: 0
      },
      imagePreview: null,
      showPreview: false,
    }
  },
  computed: {
    categories() {
      // Retourne les categories 
      return this.$store.getters.getCategories
    }
  },
  methods: {
    // Inspiration https://www.youtube.com/watch?v=VqnJwh6E9ak & https://stackoverflow.com/questions/47650154/how-do-i-upload-image-in-vuejs/58231597
    // https://stackoverflow.com/questions/29732756/how-to-validate-image-file-extension-with-regular-expression-using-javascript/29732854
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
