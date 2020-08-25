import Switch from './components/Switch.vue'
import DcsSwitch from './components/SwitchDCS.vue'
import DcsSwitchSimple from './components/SwitchSimpleDCS.vue'
import VDisconnector from './components/DisconnectorV.vue'
import HDisconnector from './components/DisconnectorH.vue'
import LDisconnector from './components/DisconnectorL.vue'
import SDisconnector from './components/DisconnectorS.vue'
import EarthDisconnector from './components/DisconnectorEarth.vue'
import EarthSDisconnector from './components/DisconnectorEarthS.vue'
import DcsEarthSDisconnector from './components/DisconnectorEarthDCS.vue'

import ControlBox from './components/ControlBox.vue'
import ScaleBox from './components/ScaleBox.vue'
import FieldBox from './components/FieldBox.vue'

Vue.component('switch-el', Switch);
Vue.component('dcs-switch-el', DcsSwitch);
Vue.component('dcs-simple-switch-el', DcsSwitchSimple);
Vue.component('v-disconnector-el', VDisconnector);
Vue.component('h-disconnector-el', HDisconnector);
Vue.component('l-disconnector-el', LDisconnector);
Vue.component('sec-disconnector-el', SDisconnector);
Vue.component('earth-disconnector-el', EarthDisconnector);
Vue.component('sec-earth-disconnector-el', EarthSDisconnector);
Vue.component('dcs-earth-disconnector-el', DcsEarthSDisconnector);

Vue.component('control-box', ControlBox);
Vue.component('scale-box', ScaleBox);
Vue.component('field-box', FieldBox);


/**
 * App
 */
let app = new Vue({
    el: '#app',
    data: {
        token: $('meta[name=csrf-token]').attr("content"),
        window: {
            width: 0,
            height: 0
        },
        initSchema: {
            width: 6960.99194,
            height: 4383.34815,
            vbX: 0,      // viewBox params
            vbY: 0,
            vbWidth: 1841.7531,
            vbHeight: 1160.1152
        },
        schema: {
            width: 0,
            height: 0,
            vbX: 0,
            vbY: 0,
            vbWidth: 1841.7531,
            vbHeight: 1160.1152
        },
        dcsDevicesValue: [],
    },
    mounted() {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
        this.$nextTick(function () {
            window.addEventListener('resize', this.getWindowWidth);
            window.addEventListener('resize', this.getWindowHeight);
            //Init
            this.getWindowWidth();
            this.getWindowHeight();
            this.schema.width = this.window.width;
            this.schema.height = this.window.height;
        });

        this.updateValueDcsDevices();
    },
    created(){
        setInterval(() => {
            this.updateValueDcsDevices()
        }, 4000);
    },
    methods: {
        getWindowWidth(event) {
            this.window.width = document.documentElement.clientWidth;
        },
        getWindowHeight(event) {
            this.window.height = document.documentElement.clientHeight;
        },
        setViewbox(x, y, width, height) {
            this.schema.vbX = x;
            this.schema.vbY = y;
            this.schema.vbWidth = width;
            this.schema.vbHeight = height;

            let viewBox = this.schema.vbX
                + ' ' + this.schema.vbY
                + ' ' + this.schema.vbWidth
                + ' ' + this.schema.vbHeight;

            let svgSchema = document.getElementsByTagName("svg")[0];
            svgSchema.setAttribute("viewBox", viewBox);
            app.$forceUpdate();
        },
        updateValueDcsDevices() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
            axios.post('/schema/dcs-devices-value')
                .then(res => {
                    if (res.data) {
                        this.dcsDevicesValue = res.data;
                    }
                })
                .catch(error => this.value = 0); // сервер не доступен
        },
        getDcsDeviceValue(id) {
            return this.dcsDevicesValue.find(device => device.id === id).value;
        },
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.getWindowWidth);
        window.removeEventListener('resize', this.getWindowHeight);
    }
});