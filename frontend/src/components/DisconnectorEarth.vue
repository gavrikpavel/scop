<template>
    <g v-bind:transform="position" v-on:click="showBox()" cursor="pointer">
        <rect transform="rotate(-90)" x="-100.1" y="300.14" width="5.4464" height="6.4918" fill="#fff"/>
        <g fill="none" v-bind:stroke="color" stroke-linecap="round" stroke-width=".4">
            <path v-bind:d="rotate"/>
            <path d="m297.86 97.385h2.0006"/>
            <path d="m307.03 97.385h2.0006"/>
            <path d="m299.9 96.135v2.5"/>
            <path d="m306.97 96.135v2.5"/>
            <g v-bind:stroke="color" stroke-width=".4">
                <path d="m309.03 95.134v4.5014"/>
                <path d="m309.76 96.26v2.5008"/>
                <path d="m310.48 96.947v1.0003"/>
            </g>
        </g>
        <circle cx="297.86" cy="97.385" r=".75023" v-bind:fill="color" style="paint-order:fill markers stroke"/>
        <circle cx="310.72" cy="94.84" r="1.5005" fill="#ef5350" style="paint-order:stroke fill markers" v-bind:visibility="notification"/>
        <title>{{name}}</title>
    </g>
</template>

<script>
    /**
     * Заземляющий Разъединитель
     */
    import {eventBus} from '../eventbus.js'

    export default {
        name: 'earth-disconnector-el',
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
                rotate_0: 'm303.40239 99.882899v-5.0015',
                rotate_1: 'm305.90314 97.382149h-5.0015',
            };
        },
        computed: {
            position: function() {
                return 'translate(' + this.posX + ' ' + this.posY + ')';
            },
            rotate: function() {
                if (this.value === 1) {
                    return this.rotate_1;
                }
                else {
                    return this.rotate_0;
                }
            },
            notification: function() {
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