<template>
    <button class="field-select" v-on:click="setAreaPlant(), $emit('close-plants')">{{plant.name}}</button>
</template>

<script>
    export default {
        name: 'field-plant',
        props: {
            inPlant: {
                areaX: '',
                areaY: '',
                areaWidth: '',
                areaHeight: '',
                name: '',
            }
        },
        data: function() {
            return {
                plant : this.inPlant,
            }
        },
        methods: {
            setAreaPlant: function () {
                this.$root.setViewbox(
                    this.plant.areaX,
                    this.plant.areaY,
                    this.plant.areaWidth,
                    this.plant.areaHeight,
                );
            }
        },
    };
</script>

<style>
    .field-select {
        background-color: #f4f4f4;
        border: none;
        color: #102027;
        padding: 10px 28px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 20px;
        margin-bottom: 2px;
        transition-duration: 0.4s;
    }
    .field-select:hover {
        background-color: #546e7a;
        color: #eceff1;
    }
</style>