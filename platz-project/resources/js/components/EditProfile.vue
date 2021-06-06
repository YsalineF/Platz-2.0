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
            editForm: {
                id: null,
                name: "",
                email: "",
                description: "",
                facebook: '',
                linkedin: '',
                image: ''
            },
            imagePreview: null,
            showPreview: false,
        }
    },
    computed: {
        user() {
            // Retourne le user connecté
            let id = this.$store.state.connectedUser.id
            return this.$store.getters.getUserById(id)
        }
    },
    methods: {
        // Inspiration https://www.youtube.com/watch?v=VqnJwh6E9ak
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