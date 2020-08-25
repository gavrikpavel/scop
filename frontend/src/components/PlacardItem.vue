<template>
    <div class="cb-placards">
        <img class="placard-image" v-bind:src="image">
        <button class="btn btn-default" v-on:click="$emit('delete-placard', id)" v-show="viewControl">
            <i class="fa fa-minus" aria-hidden="true"></i>
        </button>
    </div>
</template>

<script>
    /**
     * Плакат прибора
     */
    export default {
        name: "placard-item",
        props: ['image', 'id', 'viewControl'],
    };
</script>