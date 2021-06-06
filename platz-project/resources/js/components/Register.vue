<template lang="html">
  <div class="form">
    <h1>Platz - Register</h1>
    <form class="" action="#" @submit.prevent="login">
      <div class="form-input">
        Pseudo :
        <input type="text" name="name" placeholder="name" v-model="registerForm.name" required value="">
      </div>
      <div class="form-input">
        Email :
        <input type="text" name="email" placeholder="email" v-model="registerForm.email" required value="">
      </div>
      <div class="form-input">
        Password :
        <input type="password" name="password" placeholder="password" v-model="registerForm.password" required value="">
      </div>
      <button>Register</button>
    </form>
    <p>Already have an account ?</p>
    <router-link to="/login">Sign in</router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // Initialise a vide les elements du formulaire
      registerForm: {
        name: '',
        email: '',
        password: ''
      }
    }
  },
  methods: {
    // Permet au user de se register
    /**
     * Permet au user de se register
     * 1. Mise en place de cookie pour une certaine durée (1 heure) (ligne 50)
     * 2. Accède à la route pour s'enregistrer via les infos communiquées via le formulaire (ligne 52)
     * 3. Transforme les data du user connecté en un objet JSON (ligne 55)
     * 4. Afin de stocker le user connecté dans le session storage (voir inspecteur > application > session storage) (ligne 57)
     * 5. Renvoie vers la route "index" donc vers la page d'accueil (ligne 60)
     * 
     *
     * @return  {[type]}  [return description]
     */
    login() {
      axios.get('sanctum/csrf-cookie').then(response => {
        axios.post('api/auth/register', this.registerForm).then(response => {
          this.$store.dispatch('loginUser', response.data.user)
          let connected = JSON.stringify(response.data.user)
          sessionStorage.setItem('connected', connected)
          this.$router.push({name: "index"})
        })
      })
    }
  }
}
</script>

<style lang="css" scoped>
  .form {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    font-family: Helvetica, sans-serif;
  }
  .form-input {
    padding-bottom: 15px;
  }
</style>
