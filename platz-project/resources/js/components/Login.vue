<template lang="html">
  <div class="form">
    <h1>Platz - Login</h1>
    <form class="" action="#" @submit.prevent="login">
      <div class="form-input">
        Email :
        <input type="text" name="email" placeholder="email" v-model="loginForm.email" />
      </div>
      <div class="form-input">
        Password :
        <input type="password" name="password" placeholder="password" v-model="loginForm.password">
      </div>
      <button>Login</button>
    </form>
    <p>Don't have an account ?</p>
    <router-link to="/register">Register</router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      /**
       * Initialise a vide les elements du formulaire
       */
      loginForm: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    // Permet au user de se connecter
    /**
     * Permet au user de se connecter
     * 1. Mise en place de cookie pour une certaine durée (1 heure) (ligne 42)
     * 2. Accède à la route pour se connecter via les infos communiquées via le formulaire (ligne 44)
     * 3. Transforme les data du user connecté en un objet JSON (ligne 49)
     * 4. Afin de le stocker dans le session storage (voir inspecteur > application > session storage) (ligne 51)
     * 5. Renvoie vers la route "index" donc vers la page d'accueil (ligne 53)
     */
    login() {
      axios.get('sanctum/csrf-cookie').then(response => {
        axios.post('api/auth/login', this.loginForm).then(response => {
          this.$store.dispatch('loginUser', response.data.user)
          let connected = JSON.stringify(response.data.user)
          sessionStorage.setItem('connected', connected)
          this.$router.push({name: 'index'})
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
