<template>
    <g v-bind:transform="position" v-on:click="showBox()" cursor="pointer">
        <rect x="289.02" y="83.784" width="7.1" height="7.1" v-bind:fill="fill" stroke="#102027" stroke-linecap="round" stroke-width=".4"/>
        <g fill="none" v-bind:stroke="color" stroke-linecap="round" stroke-width=".4">
            <path v-bind:d="rotate"/>
            <path d="m292.57 80.693v3.0009"/>
            <path d="m292.57 90.876v3.0009"/>
        </g>
        <circle cx="296.12" cy="83.784" r="1.5005" fill="#ef5350" style="paint-order:stroke fill markers" v-bind:visibility="notification"/>
        <title>{{name}}</title>
    </g>
</template>

<script>
    /**
     * Выключатель
     */
    import {eventBus} from '../eventbus.js'

    export default {
        name: 'switch-el',
        props: {
            id: Number,
            name: String,
            shortName: String,
            kks: String,
            inValue: Number,
            color: String,
            inPlacards: String,
            posX: Number,
            posY: Number,
            enableControl: {
                type: Boolean,
                default: true,
            }
        },
        data: function() {
            return {
                value: this.inValue,
                placards: JSON.parse(this.inPlacards),
                fill_0: '#00c853',
                fill_1: '#d50000',
                rotate_0: 'm294.82 87.335h-4.5',
                rotate_1: 'm292.56565 85.085455v4.5',
            };
        },
        computed: {
            position: function() {
                return 'translate(' + this.posX + ' ' + this.posY + ')';
            },
            fill: function() {
                if (this.value === 1) {
                    return this.fill_1;
                }
                else {
                    return this.fill_0;
                }
            },
            rotate: function() {
                if (this.value === 1) {
                    return this.rotate_1;
                }
                else {
                    return  this.rotate_0;
                }
            },
            notification: function () {
                if (this.placards.length !== 0) {
                    return 'visible';
                }
                else {
                    return 'hidden';
                }
            }
        },
        created(){
            eventBus.$on('sendControlBoxToDevice', data => {
                if (this.id === data.id) {
                    this.value = data.value;
                }
            });
            eventBus.$on('placardControlBoxToDevice', data => {
                if (this.id === data.id) {
                    this.placards = data.placards;
                }
            });
        },
        methods: {
            showBox: function() {
                eventBus.$emit('sendDeviceToControlBox', {
                    id: this.id,
                    value: this.value,
                    kks: this.kks,
                    shortName: this.shortName,
                    name: this.name,
                    placards: this.placards,
                    enableControl: this.enableControl,
                    showControlBox: true
                });
            }
        },
    };
</script>