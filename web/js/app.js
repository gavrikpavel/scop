(function ($) {
    function addNameDevice($id) {
        let param = $('meta[name=csrf-param]').attr("content");
        let token = $('meta[name=csrf-token]').attr("content");
        let $url = $('#w0').attr('action');
        $.ajax({
            url: $url,
            type: 'POST',
            data: {
                param: token,
                id: $id
            },
            success: function (data) {
                $('#record-text').append(data)
            }
        });
    }

    $selectorDevice = $('#record-device_id');
    $selectorDevice.change(function(){
        if($(this).val() === 0) return false;
        addNameDevice($selectorDevice.val());
    });
})(jQuery);


/**
 * шина событий
 * sendDataMonth - направление данных month -> bdm
 */
let eventMonthBus = new Vue();

/**
 * 12 месяцев
 */
Vue.component('months-el', {
    data: function() {
        return {
            months: [
                {id: 0, name: 'Январь'},
                {id: 1, name: 'Февраль'},
                {id: 2, name: 'Март'},
                {id: 3, name: 'Апрель'},
                {id: 4, name: 'Май'},
                {id: 5, name: 'Июнь'},
                {id: 6, name: 'Июль'},
                {id: 7, name: 'Август'},
                {id: 8, name: 'Сентябрь'},
                {id: 9, name: 'Октябрь'},
                {id: 10, name: 'Ноябрь'},
                {id: 11, name: 'Декабрь'},
            ],
            selectedMonth: 0,
            startDate: '',
            endDate: '',
        };
    },
    computed: {
    },
    created(){
        this.selectedMonth = new Date().getMonth();
    },
    template: `
        <div class="month-block">
                <month-button-el
                v-on:set-month="selectedMonth = $event"
                v-for="month in months"
                v-bind:key="month.id"
                v-bind:id="month.id"
                v-bind:name="month.name"
                v-bind:selectedMonth="selectedMonth"
        ></month-button-el>
        </div>
    `
});

/**
 * Выбор месяца
 */
Vue.component('month-button-el', {
    props: {
        id: Number,
        name: String,
        selectedMonth: {
            type: Number,
            default: 0,
        },
    },
    data: function() {
        return {
        };
    },
    computed: {
        currentMonth: function () {
            return  (this.id === this.selectedMonth) ? '#62ebff' : '#f8f8f8';
        },
    },
    methods: {
        // setMonth: function() {
        //     let data= {
        //         id: this.id,
        //         command: this.command,
        //         comment: this.comment,
        //         dateTimeEvent: dateTimeEvent
        //     };
        //
        //     axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
        //     axios.post('/schema/set-device', data)
        //         .then(res => {
        //             if (res.data) {
        //                 this.id = res.data.id;
        //                 this.value = res.data.value;
        //                 this.sendData();
        //             }
        //             else {
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Ошибка! Отказано в доступе!',
        //                 });
        //             }
        //         })
        //         .catch(function() {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Сервер не доступен!',
        //             });
        //         });
        // },
        // sendData: function() {
        //     eventMonthBus.$emit('sendDataMonth', {
        //         id: this.id,
        //         value: this.value
        //     });
        // },
    },
    template: `<div class="elem month" v-bind:style="{background: currentMonth}" v-on:click="$emit('set-month', id)">{{name}}</div>`
});

// /**
//  * БДМ Маяк
//  */
// Vue.component('bdm-m-el', {
//     data: function() {
//         return {
//             id: 1,
//             state: 1,
//             work: 764,
//             break: 72,
//             stop: 216,
//         };
//     },
//     computed: {
//         perWork: function() {
//             return 70;
//         },
//         perBreak: function() {
//             return 10;
//         },
//         perStop: function() {
//             return 20;
//         },
//     },
//     created(){
//         // eventBus.$on('sendControlBoxToDevice', data => {
//         //     if (this.id === data.id) {
//         //         this.value = data.value;
//         //     }
//         // });
//         this.initValue();
//     },
//     methods: {
//         initValue: function() {
//             let data= {
//                 id: this.id,
//                 month: this.month,
//             };
//             axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
//             axios.post('/site/state-bdm', data)
//                 .then(res => {
//                     if (res.data) {
//                         this.state = res.data.state;
//                         this.work = res.data.work;
//                         this.break = res.data.break;
//                         this.stop = res.data.stop;
//                     }
//                 })
//                 .catch(error); // сервер не доступен
//         }
//     },
//     template: '#bdm-m-el'
// });



/**
 * App
 */
    new Vue({
    el: '#site',
    data: {
        token: $('meta[name=csrf-token]').attr("content"),
    },
});
