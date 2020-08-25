<template>
    <g v-bind:transform="position" v-on:click="showBox()" cursor="pointer">
        <rect transform="rotate(-90)" x="-615.62" y="719.07" width="11.13" height="6.4918" fill="#fff"/>
        <g fill="none" v-bind:stroke="color" stroke-linecap="round" stroke-width=".4">
            <path d="m724.39 605.05-2.122-2.122"/>
            <path d="m722.27 602.93-2.122 2.122"/>
            <path d="m722.27 616.84v-13.918" v-bind:visibility="state"/>
            <path d="m720.15 614.72 2.122 2.122"/>
            <path d="m722.27 616.84 2.122-2.122"/>
        </g>
        <circle cx="723.96" cy="606.7" r="1.5005" fill="#ef5350" style="paint-order:stroke fill markers" v-bind:visibility="notification"/>
    </g>
</template>

<script>
    /**
     * Секционный разъединитель
     */
    import {eventBus} from '../eventbus.js'

    export default {
        name: 'sec-disconnector-el',
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