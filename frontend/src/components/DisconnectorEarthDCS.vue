<template>
    <g v-bind:transform="position" v-on:click="showBox()" cursor="pointer">
        <rect transform="rotate(-90)" x="-129.48" y="337.36" width="5.4464" height="6.4918" fill="#fff"/>
        <g transform="translate(37.223 29.375)" fill="none" v-bind:stroke="color" stroke-linecap="round" stroke-width=".4">
            <path v-bind:d="rotate" v-bind:visibility="state"/>
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
        <circle cx="335.08" cy="126.76" r=".75023" v-bind:fill="color" style="paint-order:fill markers stroke"/>
        <circle cx="347.94" cy="124.22" r="1.5005" fill="#ef5350" style="paint-order:stroke fill markers" v-bind:visibility="notification"/>
        <text transform="scale(1.0733 .93169)" x="315.20023" y="139.1971" fill="#102027"
              font-family="sans-serif" font-size="8.7518px" letter-spacing="0px" stroke-width=".26465" word-spacing="0px"
              style="line-height:1.25" xml:space="preserve" v-bind:visibility="stateUns">
            <tspan x="315.20023" y="139.1971" fill="#102027" stroke-width=".26465">?</tspan></text>
        <title>{{name}}</title>
    </g>
</template>

<script>
    /**
     * Заземляющий Разъединитель АСУ ТП
     */
    import {eventBus} from '../eventbus.js'

    export default {
        name: 'dcs-earth-disconnector-el',
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
                default: false,
            }
        },
        data: function() {
            return {
                value: this.inValue,
                placards: JSON.parse(this.inPlacards),
                rotate_0: 'm303.4 94.881v5.0015',
                rotate_1: 'm300.89925 97.38175h5.0015',
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
                if (this.value === 2) {
                    return this.rotate_0;
                }
            },
            state: function() {
                if (this.value === 1 || this.value === 2) {
                    return 'visible';
                }
                else {
                    return  'hidden';
                }
            },
            stateUns: function() {
                if (this.value === 4 || this.value === 99) {
                    return 'visible';
                }
                else {
                    return  'hidden';
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
            setInterval(() => {
                this.updateValue()
            }, 5000);
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
            },
            updateValue: function () {
                this.value = this.$root.getDcsDeviceValue(this.id);
            }
        },
    };
</script>