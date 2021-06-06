<template>
  <div class="container object">

    <div id="main-container-image">

      <div class="title-item">
        <div>
          <!-- <img class="title-icone" :src="`assets/img/${categorie(ressource).icone}`" :alt="categorie(ressource).nom"> -->
        </div>
        <div class="title-text">My profile</div>
      </div>


      <div class="work">
        <figure class="white">
          <img v-if="user.image" :src="`assets/img/${user.image}`" :alt="user.name" />
          <img v-else src="assets/img/avatar.png" :alt="user.name" />

        </figure>

        <div class="wrapper-text-description">

          <div class="wrapper-file">
            <div class="icon-file"></div>
            <div class="text-file" >{{ user.name }}</div>
          </div>

          <div class="wrapper-file">
            <div class="icon-file"></div>
            <div class="text-file" >{{ user.email }}</div>
          </div>

          <div class="wrapper-file">
            <div class="icon-file"><i class="fab fa-facebook"></i></div>
            <div class="text-file" v-if="user.facebook"><a :href="user.facebook">Facebook</a></div>
            <div class="text-file" v-else><div>None</div></div>
          </div>

          <div class="wrapper-file">
            <div class="icon-file"><i class="fab fa-linkedin"></i></div>
            <div class="text-file" v-if="user.linkedin"><a :href="user.linkedin">Linkedin</a></div>
            <div class="text-file" v-else><div>None</div></div>
          </div>

          <div class="wrapper-desc">
            <div class="icon-desc"><img src="assets/img/icon-desc.svg" alt="" width="24" height="24"/></div>
            <div class="text-desc">{{ user.description }}</div>
          </div>

          <div class="wrapper-desc">
            <div class="icon-desc"><img src="assets/img/icon-desc.svg" alt="" width="24" height="24"/></div>
            <div class="text-desc">Account creation date : {{ dateFormat(user.created_at) }}</div>
          </div>

          <router-link :to="{name: 'profile.edit'}">
            <button class="edit-button" type="button">Edit profile</button>
          </router-link>

        </div>
        
      </div>
    </div>
  </div>
</template>




<script>
import moment from 'moment'
export default {
  data() {
    return {
      // edited: false
      isEditing: false,
      editPseudoForm: {
        id: null,
        name: ""
      }
    }
  },
  computed: {
    /**
     * Retourne le user connecté
     * Récupère l'id du user connecté via le session storage
     *
     * @return  {[type]}  [return le user connecté]
     */
   user() {
      let id = this.$store.state.connectedUser.id
      return this.$store.getters.getUserById(id)
   }
  },
  methods: {
    /**
       * Permet de formater une date
       *
       * @param   {[type]}  value  [la date]
       *
       * @return  {[type]}         [renvoie la date sous le nouveau format]
       */
    dateFormat(value) {
      if(value) {
        return moment(String(value)).format('MMM DD, YYYY')
      }
    }
  },
}
</script>

<style lang="css" scoped>

.title-icone{
	float:left;
	width:68px;
	height:68px;
	margin-right:20px;
}
  /*----------------------------*/
  /* MAIN DIV WITH IMAGE */
  /*----------------------------*/

  #main-container-image {
    float:left;
    width:100%;
    height:auto;
  	background-color:#F4F4F4;
  	margin-top:25px;
  	opacity:1;

  }

  .work figure-single {
    float:left;
  	width:60%;
  	margin-left:7.5%;
    height:auto;
    padding: 0 !important;
    transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
  	-webkit-box-shadow: 1px 1px 2px 0px rgba(0,0,0,0.2);
  	-moz-box-shadow: 1px 1px 2px 0px rgba(0,0,0,0.2);
  	box-shadow: 1px 1px 2px 0px rgba(0,0,0,0.2);
  	background-color:#FFF;
  }

  .work figure-single img {
      height: 95%;
      width: 95%;
  	margin-left:2.5%;
  	margin-top:2.5%;
  }

  #wrapper-part-info{
  	position:relative;
  	width:100%;
  	height:auto;
  	background-color:#FFFFFF;
  }

  .white {
      float: left;
  		width: 52.5%;
  }
  .white img {
  	width: 100%;
  }

  .part-info-image-single{
  	float:left;
  	margin-bottom:17.5px;
  }
  #wrapper-part-info .part-info-image img{height:20%;width:20%;}

  .wrapper-text-description{
  	position:absolute;
  	width:35%;
  	right:5.5%;
  	height:auto;
  	margin-top:85px;
  }

  .wrapper-view,.wrapper-file,.wrapper-weight,.wrapper-desc,.wrapper-download{
  	float:left;
  	width:100%;
  	border-bottom:solid #E0E0E0 1px;
  }
  .wrapper-file,.wrapper-weight,.wrapper-desc,.wrapper-download{
  	border-top:solid #FFF 1px;
  }
  .wrapper-morefrom{
  	float:left;
  	width:100%;
  	border-top:solid #FFF 1px;
  }
  .wrapper-view,.wrapper-file,.wrapper-weigh,.wrapper-download,.wrapper-morefrom{height:40px;}
  .wrapper-desc,.wrapper-morefrom{height:auto;}

  .icon-view,.icon-file,.icon-weight,.icon-desc,.icon-download{
  	float:left;
  	left:0;
  	margin-right:25px;
  }
  .icon-view{margin-top:10px;}
  .icon-file{margin-top:9px;margin-left:2px;}
  .icon-weight{margin-top:8px;margin-left:2px;}
  .icon-desc{margin-top:7px;}
  .icon-download{margin-top:6px;margin-left:3px;}

  .icon-view img,.icon-file img,.icon-weight img,.icon-desc img,.icon-download img{height:100%;width:100%;}

  .text-view,.text-file,.text-weight,.text-desc,.text-download{
  	float:left;
  	text-align:left;
  	font-family: Helvetica, sans-serif;
      font-size: 15px;
  	font-weight:400;
  	-webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
  	color:#A1A1A1;
  }
  .text-view,.text-file,.text-weight,.text-download{
  	height:40px;
  	line-height:40px;
  }
  .text-desc{
  	width:calc(100% - 49px);
  	line-height:130%;
  	height:auto;
  	margin-bottom:25px;
  	margin-top:10px;
  }

  .text-morefrom{
  	float:left;
  	text-align:left;
  	font-family: Helvetica, sans-serif;
  	-webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-size: 16px;
  	font-weight:600;
  	color:#686868;
  	width:100%;
  	margin-left:0;
  	line-height:130%;
  	height:auto;
  	margin-bottom:0;
  	margin-top:20px;
  }

  .image-morefrom{
  	float:left;
  	width:100%;
  	margin-top:20px;
  	height:auto;
  	margin-bottom:35px;
  }

  .image-morefrom-1,.image-morefrom-2,.image-morefrom-3,.image-morefrom-4{
  	float:left;
  	width:47.5%;
  	height:auto;
  	-webkit-box-shadow: 1px 1px 2px 0px rgba(0,0,0,0.2);
  	-moz-box-shadow: 1px 1px 2px 0px rgba(0,0,0,0.2);
  	box-shadow: 1px 1px 2px 0px rgba(0,0,0,0.2);
  	background-color:#FFF;
  	transition: all 0.2s ease-in-out;
  	-webkit-transition: all 0.2s ease-in-out;
  	-moz-transition: all 0.2s ease-in-out;
  	-o-transition: all 0.2s ease-in-out;
  	cursor:pointer;
  }

  .image-morefrom-1,.image-morefrom-3{margin-right:5%;}
  .image-morefrom-1,.image-morefrom-2{margin-bottom:12.5px;}

  .image-morefrom-1 img,.image-morefrom-2 img,.image-morefrom-3 img,.image-morefrom-4 img{
  	width:85%;
  	height:auto;
  	margin-left:7.5%;
  	padding-bottom:7.5%;
  	padding-top:7.5%;
  }
  .image-morefrom-1:hover,.image-morefrom-2:hover,.image-morefrom-3:hover,.image-morefrom-4:hover{opacity:0.5;}

  .post-reply,.post-reply-2{
  	float:left;
  	width:53%;
  	margin-left:4%;
      height:auto;
  }

  .post-reply{margin-top:50px;}

  /* .image-reply-post{background: url(../img/avatar.png) no-repeat;} */

  .name-reply-post,.name-reply-post-2{
  	float:left;
  	width:calc(100% - 95px);
  	font-family: Helvetica, sans-serif;
  	-webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-size: 16px;
  	font-weight:600;
  	color:#686868;
  	line-height:65px;
  	height:65px;
  	padding-left:30px;
  }

  .text-reply-post,.text-reply-post-2{
  	float:left;
  	text-align:left;
  	height:auto;
  	line-height:140%;
  	margin-left:95px;
  	width:calc(90% - 95px);
  	font-family: Helvetica, sans-serif;
  	-webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-size: 16px;
  	font-weight:400;
  	color:#999;
  	margin-top:-10px;
  	border-bottom:solid #E9E9E9 1px;
  	padding:20px;
  	margin-top:-20px;
  }

  textarea {
      font-family: Helvetica, sans-serif;
  	-webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-size: 16px;
  	font-weight:400;
  	color:#999;
  	width: 320px;
  	height: 150px;
  	background:#FFF;
  	outline:none;
  	border:solid 1px #DDDDDD;
  	border-radius:4px;
  	padding-left:10px;
  	padding-top:10px;
  	float:left;
  	margin-left:-15px;
  	margin-top:-25px;
  }

  input[type=submit] {
  	font-family: Helvetica, sans-serif;
  	-webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-size: 16px;
  	font-weight:600;
  	color:#FFF;
  	cursor: pointer;
  	width: 150px;
  	height: 40px;
  	padding: 5px 10px;
  	border-radius:4px;
  	transition: all 0.5s ease-in-out;
  	-webkit-transition: all 0.5s ease-in-out; /** Chrome & Safari **/
  	-moz-transition: all 0.5s ease-in-out; /** Firefox **/
  	-o-transition: all 0.5s ease-in-out; /** Opera **/
  	background-color:#74BDEC;
  	float:left;
  	border:none;
  }

  fieldset {
  	border:none;
  }

  textarea {
  	resize: vertical;
      max-height:100px;
      min-height:100px;
  }

  textarea {
      color: #999;
  }

  textarea:-moz-placeholder {
      color: #999;
  }

  textarea::-webkit-input-placeholder {
      color: #999;
  }

  textarea.placeholder {
      color: #999;
  }

  .title-item{
  	float:left;
  	width:92.5%;
  	margin-left:7.5%;
  	height:68px;
  	margin-bottom:10px;
  }

  .title-text{
  	font-family: Helvetica, sans-serif;
  	-webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-size: 22px;
  	font-weight:600;
  	color:#686868;
  	line-height:125%;
  	height:auto;
  	width:calc(100% - 88px);
  	margin-top:8px;
  }

  .title-text-2{
  	font-family: Helvetica, sans-serif;
  	-webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-size: 15px;
  	font-weight:400;
  	color:#A1A1A1;
  	line-height:125%;
  	height:auto;
  	width:calc(100% - 88px);
  	margin-top:8px;
  }
</style>
