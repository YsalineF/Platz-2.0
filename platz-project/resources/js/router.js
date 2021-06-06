// ./router.js

import Vue from 'vue'
import Router from 'vue-router'

// Chargement des composants des différentes routes
import RessourcesIndex from './components/ressources/Index'
import RessourceShow from './components/ressources/Show'
import Login from './components/Login'
import Register from './components/Register'
import AddRessources from './components/AddRessources'
import EditRessources from './components/EditRessources'
import Profile from './components/Profile'
import EditProfile from './components/EditProfile'
import UserShow from './components/users/Show'
import Conversations from './components/Conversations'
import Conversation from './components/Conversation'

// Création du routing
Vue.use(Router)
export default new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: RessourcesIndex
    },
    {
      path: '/ressources/:id',
      name: 'ressourceShow',
      component: RessourceShow
    },
    {
      path: '/ressources/categories/:id',
      name: 'categories.show',
      component: RessourcesIndex
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/register',
      name: 'register',
      component: Register
    },
    {
      path: '/add',
      name: 'add',
      component: AddRessources
    },
    {
      path: '/edit/:id',
      name: 'edit',
      component: EditRessources
    },
    {
      path: '/my-profile',
      name: 'profile',
      component: Profile
    },
    {
      path: '/my-profile/edit',
      name: 'profile.edit',
      component: EditProfile
    },
    {
      path: '/users/:id',
      name: 'userShow',
      component: UserShow
    },
    {
      path: '/conversations',
      name: 'Conversations',
      component: Conversations,
      children: [
        {
          path: ':id',
          name: 'Conversation',
          props: true,
          component: Conversation
        }
      ]
    }
  ]
})
