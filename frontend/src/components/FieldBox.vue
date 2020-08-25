<template>
    <div class="field-box">
        <button class="zoom field" v-on:click="showPlants = !showPlants">
            <i v-bind:class="icon" aria-hidden="true"></i>
        </button>
        <field-plant
                v-on:close-plants="showPlants = false"
                v-for="plant in plants"
                v-bind:key="plant.name"
                v-bind:in-plant="plant"
                v-show="showPlants"
        ></field-plant>
    </div>
</template>

<script>
    import FieldPlant from './FieldPlant.vue'

    Vue.component('field-plant', FieldPlant);

    export default {
        name: 'field-box',
        data: function() {
            return {
                plants: [],
                showPlants: false
            }
        },
        mounted() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
            axios.post('/schema/area')
                .then(res => {
                    this.getPlants(res.data);
                })
                .catch(function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Сервер не доступен!',
                    });
                });
        },
        computed : {
            icon: function () {
                return  (this.showPlants) ?  "fa fa-times fa-lg" : "fa fa-bars fa-lg";
            },
        },
        methods: {
            getPlants: function(rawPlants) {
                for (let rawPlant of rawPlants) {
                    let plant = {};
                    let areas = rawPlant.area.split(' ');
                    plant.name = rawPlant.name;
                    plant.areaX = areas[0];
                    plant.areaY = areas[1];
                    plant.areaWidth = areas[2];
                    plant.areaHeight = areas[3];
                    this.plants.push(plant);
                }
            },
        },
    };
</script>

<style>
    .field-box {
        display: flex;
        flex-direction: column;
        justify-content: start;

        min-width: 100px;
        background: #222222;
        position: fixed;  z-index: 2000;
        margin: 10px 0 0 550px;
    }
    .field {
        width: 55px;
        height: 32px;
    }
</style>