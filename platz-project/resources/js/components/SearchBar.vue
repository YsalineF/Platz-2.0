<template>
    <div>
        <form>
            <input @keyup="search" v-model="searchValue" type="text" name="searchValue" id="tip_search_input" list="search" autocomplete=off required>
        </form>
        <div class="searchResults" v-click-outside="close">
            <!-- Si une recherche a été effectuée -->
            <ul v-if="search">
                <li v-for="result in results" :key="result.id" @click="close">
                    <router-link :to="`/ressources/${result.id}`">{{result.nom}}</router-link>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                searchValue: '',
                results: null
            }
        },
        methods: {
            /**
             * Fonction qui permet d'effectuer une recherche
             *
             * @return  {[type]}  [return description]
             */
            search() {
                if(this.searchValue.trim()) {
                    axios.get('api/search', {params: {searchValue: this.searchValue}})
                        .then(response => {
                            this.results = response.data
                        })
                }
            },
            /**
             * Fonction qui permet de remettre à zéro les différents éléments, à savoir le champ de la recherche (searchValue)  ainsi que le(s) résultat(s) de la recherche (results)
             *
             * @return  {[type]}  [return description]
             */
            close() {
                this.searchValue = ""
                this.results = null
            }
        },
        /**
         * Permet de fermer la fenêtre de résultats de la recherche lorsqu'on appuie en dehors de cette fenêtre
         * Code trouvé sur : https://stackoverflow.com/questions/36170425/detect-click-outside-element et légèrement modifié
         */
        directives: {
            "click-outside": {
                bind: function (el, binding) {
                    el.clickOutsideEvent = function (event) {
                    // here I check that click was outside the el and his children
                    if (!(el == event.target || el.contains(event.target))) {
                        // and if it did, call method provided in attribute value
                        binding.value(event)
                    }
                    };
                    document.body.addEventListener('click', el.clickOutsideEvent)
                },
                unbind: function (el) {
                    document.body.removeEventListener('click', el.clickOutsideEvent)
                },
            }
        } 
    }
</script>
<style lang="css" scoped>
    .searchResults{
        background: white;
        border: 1px black solid;
        z-index: 9999;
        /* Pour aligner et match la barre de recherche */
        position: relative;
        width: 13.9em;
        right: 2.5em;
        border-radius: 5px;

    }
</style>
