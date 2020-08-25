<template>
    <g v-bind:transform="position" v-on:click="showBox()" cursor="pointer">
        <rect x="309.74" y="-25.602" width="5.4464" height="7.1" fill="#fff"/>
        <g fill="none" v-bind:stroke="color" stroke-linecap="round" stroke-width=".4">
            <path v-bind:d="rotate"/>
            <path d="m312.46-28.773v3.0009"/>
            <path d="m312.46-18.593v3.0009"/>
            <path d="m313.71-25.662h-2.5"/>
            <path d="m313.71-18.593h-2.5"/>
        </g>
        <circle cx="314.17" cy="-27.362" r="1.5005" fill="#ef5350" style="paint-order:stroke fill markers" v-bind:visibility="notification"/>
        <title>{{name}}</title>
    </g>
</template>

<script>
    /**
     * Разъединитель Вертикальный
     */
    import {eventBus} from '../eventbus.js'

    export default {
        name: 'v-disconnector-el',
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
                rotate_0: 'm314.95883 -22.162109h-5',
                rotate_1: 'm312.46-24.662v5',
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