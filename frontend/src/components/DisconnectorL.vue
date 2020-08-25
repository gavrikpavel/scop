<template>
    <g v-bind:transform="position" v-on:click="showBox()" cursor="pointer">
        <rect x="279.87" y="63.899" width="4.8382" height="7.1" fill="#fff"/>
        <g v-bind:stroke="color" stroke-linecap="round" stroke-width=".4">
            <path d="m283.12 63.47v0.36926" fill="none"/>
            <circle cx="283.12" cy="64.825" r=".75023" fill="#fff" stroke-linejoin="round" stroke-opacity="1" style="paint-order:fill markers stroke"/>
            <g fill="none">
                <path d="m280.12 64.825 3.0009 6.0795"/>
                <path d="m283.12 70.904v3.0009"/>
                <path d="m284.37 63.839h-2.5008"/>
                <path d="m283.12 64.825h-3.0009" v-bind:visibility="state"/>
            </g>
        </g>
        <circle cx="285.55" cy="65.136" r="1.5005" fill="#ef5350" style="paint-order:stroke fill markers" v-bind:visibility="notification"/>
    </g>
</template>

<script>
    /**
     * Выключатель нагрузки
     */
    import {eventBus} from '../eventbus.js'

    export default {
        name: 'l-disconnector-el',
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
                visible_0: 'hidden',
                visible_1: 'visible',
            };
        },
        computed: {
            position: function() {
                return 'translate(' + this.posX + ' ' + this.posY + ')';
            },
            state: function() {
                if (this.value === 1) {
                    return this.visible_1;
                }
                else {
                    return this.visible_0;
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