<template>
    <g v-bind:transform="position" v-on:click="showBox()" cursor="pointer">
        <g transform="translate(.57409 2.7064)" v-bind:stroke="color" stroke-linecap="round" stroke-width=".4">
            <rect x="330.43" y="100.21" width="7.1" height="7.1" v-bind:fill="fill"/>
            <path v-bind:d="rotate" fill="none" v-bind:visibility="state"/>
        </g>
        <g transform="translate(104.89 8.4473)" fill="none" v-bind:stroke="color" stroke-linecap="round" stroke-width=".4" v-bind:visibility="stateTel">
            <path d="m229.66 91.017 2.122 2.122"/>
            <path d="m227.54 93.139 2.122-2.122"/>
            <path d="m229.66 104.56 2.122-2.122"/>
            <path d="m227.54 102.44 2.122 2.122"/>
            <path d="m229.66 91.376v3.0009"/>
            <path d="m229.66 101.56v3.0009"/>
        </g>
        <circle cx="338.1" cy="102.91" r="1.5005" fill="#ef5350" style="paint-order:stroke fill markers" v-bind:visibility="notification"/>
        <text transform="scale(1.0733 .93167)" x="309.2027" y="117.51874" fill="#102027"
              font-family="sans-serif" font-size="8.752px" letter-spacing="0px" stroke-width=".26466" word-spacing="0px"
              style="line-height:1.25" xml:space="preserve" v-bind:visibility="stateUns">
            <tspan x="309.2027" y="117.51874" fill="#102027" stroke-width=".26466">?</tspan>
        </text>
        <title>{{name}}</title>
    </g>
</template>

<script>
    /**
     * Выключатель АСУ ТП
     */
    import {eventBus} from '../eventbus.js'

    export default {
        name: 'dcs-switch-el',
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
                fill_0: '#00c853',
                fill_1: '#d50000',
                fill_uns: '#fa35ff',
                fill_tel: '#ffffffff',
                rotate_0: 'm336.24 103.76h-4.5',
                rotate_1: 'm333.9896 101.50886v4.5',
            };
        },
        computed: {
            position: function() {
                return 'translate(' + this.posX + ' ' + this.posY + ')';
            },
            fill: function() {
                switch (this.value) {
                    case 0:
                        return '#757575';
                        break;
                    case 1:
                        return this.fill_1;
                        break;
                    case 2:
                        return this.fill_0;
                        break;
                    case 3:
                        return this.fill_uns;
                        break;
                    default:
                        return this.fill_tel;
                }
            },
            rotate: function() {
                if (this.value === 1 || this.value === 10) {
                    return this.rotate_1;
                }
                if (this.value === 2 || this.value === 20) {
                    return this.rotate_0;
                }
            },
            state: function() {
                if (this.value === 1 || this.value === 2 || this.value === 10 || this.value === 20) {
                    return 'visible';
                }
                else {
                    return  'hidden';
                }
            },
            stateUns: function() {
                if (this.value === 3 || this.value === 30 || this.value === 99) {
                    return 'visible';
                }
                else {
                    return  'hidden';
                }
            },
            stateTel: function() {
                if (this.value === 10 || this.value === 20 || this.value === 30) {
                    return 'hidden';
                }
                else {
                    return  'visible';
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
            setInterval(() => {
                this.updateValue()
            }, 5000);
        },
        methods: {
            showBox: function () {
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
        }
    };
</script>