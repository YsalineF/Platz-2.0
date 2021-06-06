<template lang="html">
  <div>
      <h1>Platz - Edit Profile Information</h1>
      <form action='#' @submit.prevent="editProfile">
          <div>
              <label for="pseudo">Pseudo</label>
              <input type="text" name="name" v-model="editForm.name">
          </div>
          <div>
              <label for="email">Email</label>
              <input type="mail" name="email" v-model="editForm.email">
          </div>           
          <div>
              <label for="description">Description</label>
              <textarea name="description" rows="8" cols="80" placeholder="description" v-model="editForm.description"></textarea>
          </div>        
          <div>
              <label for="facebook">Facebook</label>
              <input type="text" name="facebook" v-model="editForm.facebook">
          </div>           
          <div>
              <label for="linkedin">Linkedin</label>
              <input type="text" name="linkedin" v-model="editForm.linkedin">
          </div>    
          <div class="form-element">
            <label for="image">Profil picture</label>
            <input type="file" @change="imageChange" name="image" value="">
            <img :src="`assets/img/${user.image}`" v-if="!imagePreview" />
            <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview"/>
          </div>  
          <button>Save changes</button>
          <router-link :to="{name: 'profile'}">
              <button>Return</button>
          </router-link>          
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
            editForm: {
                id: null,
                name: "",
                email: "",
                description: "",
                facebook: '',
                linkedin: '',
                image: ''
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
         * Retourne le user connecté
         *
         * @return  {[type]}  [retourne un user]
         */
        user() {
            let id = this.$store.state.connectedUser.id
            return this.$store.getters.getUserById(id)
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
         * Permet d'éditer les informations du profil d'un user
         *
         * @return  {[type]}  [return description]
         */
        /**
         * Permet d'éditer les informations d'un user
         * On instancie un objet FormData qu'on rempli avec les éléments actuels du user (voir "created()")
         * Lorsque le nouveau tableau a été rempli avec les informations, on utilise la route axios "api/my-profile/edit"
         * et on est redirigé vers la page profile
         * @return  {[type]}  [return description]
        */
        editProfile() {
            let editForm = new FormData();
            editForm.append("id", this.editForm.id)
            editForm.append("name", this.editForm.name)
            editForm.append("email", this.editForm.email)
            editForm.append("description", this.editForm.description)
            if(this.editForm.facebook === "null") {
                editForm.append("facebook", "")
            }
            else {
                editForm.append("facebook", this.editForm.facebook)
            }
            
            if(this.editForm.linkedin === "null") {
                editForm.append("linkedin", "")
            }
            else {
                editForm.append("linkedin", this.editForm.linkedin)
            }
            editForm.append("image", this.editForm.image)
            console.log(editForm.image)
            axios.post('api/my-profile/edit', editForm)
            this.$router.push("/my-profile")
        }
    },
    /**
     * Remplit le tableau "editForm" (instancier à vide dans les data) avec les éléments actuels du user au chargement de la page
     *
     * @return  {[type]}  [return description]
     */
    created() {
        this.editForm.id = this.$store.state.connectedUser.id
        this.editForm.name = this.user.name
        this.editForm.email = this.user.email
        this.editForm.description = this.user.description
        this.editForm.facebook = this.user.facebook
        this.editForm.linkedin = this.user.linkedin
        this.editForm.image = this.user.image
    }
}
</script>