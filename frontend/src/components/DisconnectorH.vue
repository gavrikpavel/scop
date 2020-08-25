<template>
    <g v-bind:transform="position" v-on:click="showBox()" cursor="pointer">
        <rect transform="rotate(-90)" x="-118.19" y="302.51" width="5.4464" height="7.1" fill="#fff"/>
        <g fill="none" v-bind:stroke="color" stroke-linecap="round" stroke-width=".4">
            <path v-bind:d="rotate"/>
            <path d="m299.34 115.47h3.0009"/>
            <path d="m309.52 115.47h3.0009"/>
            <path d="m302.45 114.22v2.5"/>
            <path d="m309.52 114.22v2.5"/>
        </g>
        <circle cx="311.22" cy="113.77" r="1.5005" fill="#ef5350" style="paint-order:stroke fill markers" v-bind:visibility="notification"/>
        <title>{{name}}</title>
    </g>
</template>

<script>
    /**
     * Разъединитель Горизонтальный
     */
    import {eventBus} from '../eventbus.js'

    export default {
        name: 'h-disconnector-el',
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
                rotate_0: 'm305.95 112.97v5',
                rotate_1: 'm303.45314 115.466h5',
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