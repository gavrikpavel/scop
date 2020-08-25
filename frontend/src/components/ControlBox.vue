<template>
    <transition name="modal">
        <div class="modal-mask" v-show="showControlBox">
            <div class="modal-container">
                <i class="glyphicon glyphicon-remove" v-on:click="close()"></i>
                <div class="modal-header">
                    <h2>{{shortName}}</h2>
                </div>
                <div class="vmodal-body">
                    <span>{{name}}</span>
                    <br><br>
                    <div v-show="viewControl">
                        <span class="text-edit">Повесить плакат:</span>
                        <div class="cb-placards"  >
                            <select class="form-control" v-model="selectedPlacard">
                                <option v-for="placard in placards" v-bind:value="placard.id">
                                    {{ placard.name }}
                                </option>
                            </select>
                            <button class="btn btn-default" v-on:click="addPlacard()">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <placard-item
                            v-for="(placard, index) in devicePlacards"
                            v-bind:key="placard.id"
                            v-bind:id="placard.id"
                            v-bind:image="placard.image"
                            v-bind:view-control="viewControl"
                            v-on:delete-placard="deletePlacard"
                    ></placard-item>

                    <div class="oper-switch" v-show="viewControl & enableControl">
                        <span class="text-edit">Комментарий переключения:</span>
                        <textarea class="cb-comment form-control" rows="3" v-model="comment" placeholder="Введите комментарий к переключению..."></textarea>
                        <br>
                        <span class="text-edit">Дата переключения:</span>
                        <div class="cb-main-time">
                            <span class="time">{{dateTimeSite}}</span>
                            <button class="cb-show btn btn-default" v-on:click="showEdit = !showEdit"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></button>
                        </div>
                        <div class="cb-edit-time" v-show="showEdit">
                            <div class="col-sm-12 input-group">
                                <vue-timepicker v-model="inputTimeValue" format="HH:mm" close-on-complete auto-scroll hide-clear-button input-width="100%"></vue-timepicker>
                            </div>
                            <div class="col-sm-12 input-group">
                                <vuejs-datepicker v-model="inputDateValue" :language="ru"></vuejs-datepicker>
                            </div>
                        </div>
                        <div class="cb-fix">
                            <input class="form-check-input" type="checkbox" v-model="fixData">
                            <span class="cb-fix">Зафиксировать комментарий и дату для нескольких переключений</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-show="viewControl & enableControl">
                    <button class="btn btn-success" v-bind:disabled="onDisable" v-on:click="setTurnOn()">Вкл</button>
                    <button class="btn btn-success" v-bind:disabled="offDisable" v-on:click="setTurnOff()">Откл</button>
                    <button class="btn btn-primary" v-on:click="close()">Выйти</button>
                </div>
            </div>
        </div>
    </transition>
</template>


<script>
    /**
     * Окно управления
     */
    import {eventBus} from '../eventbus'
    import VueTimepicker from 'vue2-timepicker/src/vue-timepicker.vue'
    import Datepicker from 'vuejs-datepicker'
    import {ru} from 'vuejs-datepicker/dist/locale'
    import PlacardItem from './PlacardItem.vue'

    Vue.component('vue-timepicker', VueTimepicker);
    Vue.component('vuejs-datepicker', Datepicker);
    Vue.component('placard-item', PlacardItem);

    export default {
        name: 'control-box',
        props: {
            viewControl:  Boolean,
        },
        data: function() {
            return {
                id: '',
                shortName: '',
                name: '',
                kks: '',
                command: 0,
                value: 0,
                showControlBox: false,
                fixDataTmp: false, // заглушка для последнего переключения
                fixData: false,
                showEdit: false,
                comment: '',
                dateTime: {
                    'date': '',
                    'time': '',
                },
                changed: '',
                inputDateValue: '',
                ru: ru,
                inputTimeValue: '',
                placards: [],
                devicePlacards: [],
                selectedPlacard: '',
                enableControl: false,
                countSecond: 0,
            };
        },
        mounted() {
            // get all placards
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
            axios.post('/schema/placard')
                .then(res => {
                    this.placards = (res.data);
                })
                .catch(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Сервер не доступен!',
                    });
                });
            // set init DateTime
            this.dateTime = this.getCurrentDateTime();
        },
        computed: {
            dateTimeSite: function() {
                let changedDateTime = this.formatDateTime(new Date(this.inputDateValue));
                return this.siteViewDate(changedDateTime.date) + ' ' + this.inputTimeValue;
            },
            onDisable: function() {
                return this.value === 1;
            },
            offDisable: function() {
                return this.value === 0;
            },
        },
        created(){
            eventBus.$on('sendDeviceToControlBox', data => {
                this.id = data.id;
                this.value = data.value;
                this.kks = data.kks;
                this.shortName = data.shortName;
                this.name = data.name;
                this.devicePlacards = data.placards;
                this.selectedPlacard = '';
                this.enableControl = data.enableControl;
                this.showControlBox = data.showControlBox;
                this.showEdit = false;
                this.fixDataTmp = this.fixData;

                if (!this.fixData) {
                    this.comment = '';
                    this.dateTime = this.getCurrentDateTime();
                    this.inputTimeValue = this.dateTime.time;
                    this.inputDateValue = this.dateTime.date;
                    this.countSecond = 0; // Сброс счетчика секунд по-умолчанию
                }
            });
        },
        methods: {
            setTurnOn: function() {
                this.command  = 1;
                let dateTimeEvent = '';

                // При групповом переключении прибавляем секунду к каждому следующему переключению
                if (this.fixDataTmp || this.fixData) {
                    dateTimeEvent = this.getGroupDateTime(this.getChangedDateTime());
                }
                else {
                    dateTimeEvent = this.getChangedDateTime();
                }

                let data= {
                    id: this.id,
                    command: this.command,
                    comment: this.comment,
                    dateTimeEvent: dateTimeEvent
                };

                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
                axios.post('/schema/set-device', data)
                    .then(res => {
                        if (res.data) {
                            this.id = res.data.id;
                            this.value = res.data.value;
                            this.sendValue();
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ошибка! Отказано в доступе!',
                            });
                        }
                    })
                    .catch(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Сервер не доступен!',
                        });
                    });

                // Добавить выбранный плакат вместе с включением устройства
                if (this.selectedPlacard !== '') {
                    let dataPlacard= {
                        deviceId: this.id,
                        placardId: this.selectedPlacard,
                        dateTimeEvent: this.getChangedDateTime()
                    };
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
                    axios.post('/schema/add-placard', dataPlacard)
                        .then(res => {
                            if (res.data) {
                                this.devicePlacards.push(res.data);
                                this.sendPlacard();
                            }
                        });
                };
            },
            setTurnOff: function() {
                this.command  = 0;
                let dateTimeEvent = '';

                // При групповом переключении прибавляем секунду к каждому следующему переключению
                if (this.fixDataTmp || this.fixData) {
                    dateTimeEvent = this.getGroupDateTime(this.getChangedDateTime());
                }
                else {
                    dateTimeEvent = this.getChangedDateTime();
                }

                let data= {
                    id: this.id,
                    command: this.command,
                    comment: this.comment,
                    dateTimeEvent: dateTimeEvent
                };
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
                axios.post('/schema/set-device', data)
                    .then(res => {
                        if (res.data) {
                            this.id = res.data.id;
                            this.value = res.data.value;
                            this.sendValue();
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ошибка! Отказано в доступе!',
                            });
                        }
                    })
                    .catch(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Сервер не доступен!',
                        });
                    });

                // Добавить выбранный плакат вместе с включением устройства
                if (this.selectedPlacard !== '') {
                    let dataPlacard= {
                        deviceId: this.id,
                        placardId: this.selectedPlacard,
                        dateTimeEvent: this.getChangedDateTime()
                    };
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
                    axios.post('/schema/add-placard', dataPlacard)
                        .then(res => {
                            if (res.data) {
                                this.devicePlacards.push(res.data);
                                this.sendPlacard();
                            }
                        });
                };
            },
            addPlacard: function() {
                if (!this.selectedPlacard) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Выберите плакат!',
                    });
                }
                else {
                    let isAlreadyPlacard = this.devicePlacards.find(placard => placard.id == this.selectedPlacard);
                    if (isAlreadyPlacard) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Данный плакат уже установлен',
                        });
                    }
                    else {
                        let data= {
                            deviceId: this.id,
                            placardId: this.selectedPlacard,
                            dateTimeEvent: this.getChangedDateTime()
                        };
                        axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
                        axios.post('/schema/add-placard', data)
                            .then(res => {
                                if (res.data) {
                                    this.devicePlacards.push(res.data);
                                    this.sendPlacard();
                                }
                                else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Ошибка! Отказано в доступе!',
                                    });
                                }
                            })
                            .catch(function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Сервер не доступен!',
                                });
                            });
                    }
                }
            },
            deletePlacard: function (id) {
                let indexOffPlacard = this.devicePlacards.findIndex(item => item.id == id);
                let data= {
                    deviceId: this.id,
                    placardId: this.devicePlacards[indexOffPlacard].id,
                    dateTimeEvent: this.getChangedDateTime()
                };
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.$root.token;
                axios.post('/schema/delete-placard', data)
                    .then(res => {
                        if (res.data) {
                            if (indexOffPlacard !== -1) {
                                this.devicePlacards.splice(indexOffPlacard, 1);
                                this.sendPlacard();
                            }
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ошибка! Отказано в доступе!',
                            });
                        }
                    })
                    .catch(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Сервер не доступен!',
                        });
                    });
            },
            sendValue: function() {
                eventBus.$emit('sendControlBoxToDevice', {
                    id: this.id,
                    value: this.value
                });
                this.showControlBox = false;
            },
            sendPlacard: function() {
                eventBus.$emit('placardControlBoxToDevice', {
                    id: this.id,
                    placards: this.devicePlacards
                });
                this.selectedPlacard = null;
            },
            getCurrentDateTime: function(dateTime = new Date()) {
                dateTime.setSeconds(0);
                return this.formatDateTime(dateTime);
            },
            getChangedDateTime: function() {
                let dateTime = this.formatDateTime(new Date(this.inputDateValue));
                return dateTime.date + ' ' + this.inputTimeValue;
            },
            getGroupDateTime: function(strDateTime) {
                let dateTime = new Date(strDateTime);
                let seconds = dateTime.getSeconds();
                seconds = seconds + this.countSecond;
                this.countSecond++;
                dateTime.setSeconds(seconds);
                this.dateTime = this.formatDateTime(dateTime);

                return this.dateTime.date + ' ' + this.dateTime.time;
            },
            formatDateTime: function(dateTime) {
                let dt = {
                  'date': '',
                  'time': '',
                },
                months = ["01", "02", "03", "04", "05",
                        "06", "07", "08", "09", "10", "11", "12"],
                    zeroDay = '',
                    zeroHour = '',
                    zeroMinute = '',
                    zeroSecond = '',
                    year = '',
                    month = '',
                    day = '',
                    hour = '',
                    minute = '',
                    second = '';

                year = dateTime.getFullYear();
                month = dateTime.getMonth();
                day = dateTime.getDate();
                hour = dateTime.getHours();
                minute = dateTime.getMinutes();
                second = dateTime.getSeconds();

                // Форматирование даты и времени
                (day < 10) ? zeroDay = '0' : zeroDay = '';
                (hour < 10) ? zeroHour = '0' : zeroHour = '';
                (minute < 10) ? zeroMinute = '0' : zeroMinute = '';
                (second < 10) ? zeroSecond = '0' : zeroSecond = '';

                dt.date = year +  '-'
                    + months[month] + '-'
                    + zeroDay + day;

                dt.time = zeroHour + hour + ':'
                    + zeroMinute + minute + ':'
                    + zeroSecond + second;

                return dt
            },
            siteViewDate: function(strDate) {
                let arrDate = strDate.split("-");
                arrDate.reverse();
                return arrDate.join('-');
            },
            close: function() {
                this.showControlBox = false;
            },
        },
    };
</script>

<style>
    .modal-mask {
        position: fixed;
        top:0;
        right:0;
        z-index: 9000;
        width: 100%;
        height: 100%;
        background-color: rgba(79, 91, 98, 0.5);
        display: block;
        transition: opacity 0.3s ease;
        overflow-y: auto;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 20%;
        min-width: 300px;
        height: 100%;
        margin: auto 0 auto auto;
        background-color: #b0bec5;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
        transition: all 0.3s ease;
        font-family: Helvetica, Arial, sans-serif;
        padding: 0;

        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .modal-header {
        margin: 0;
        padding: 0 10px;
        background-color: #b0bec5;
    }

    .modal-header h2 {
        margin: 0;
        padding: 0;
    }

    .vmodal-body {
        margin: 0 0;
        flex-grow:1;
        padding: 0 15px;
        background-color: #fff;
    }

    .modal-footer {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        background-color: #fff;
    }

    i {
        font-size: 25px;
        cursor: pointer;
        color: #263238;
        align-self: flex-end;
    }

    .placard-image {
        max-width:80%;
        height:auto;
    }

    .cb-placards {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 3px;
    }

    .cb-comment {
        width: 100%;
        resize: vertical;
        height: 50px;
        max-height: 100px;
    }
    .cb-show {
        display: inline;
    }

    .text-edit {
        font-size:18px;
    }

    .cb-main-time {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cb-edit-time {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .cb-edit-time input {
        width: 100%;
        height: 30px;
        margin: 3px 0 3px 0;
        background-color: #eeeeee;
        text-align: center;
        border: 1px solid #d2d2d2;
        cursor: pointer;
    }

    .time {
        font-size:24px;
        font-weight: 500;
    }

    .cb-fix {
        margin-top: 20px;
    }

    .cb-fix input {
        transform:scale(1.5);
        opacity:0.9;
        cursor:pointer;
    }

    /*Vue animation*/
    .modal-enter {
        opacity: 0;

    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        transform: translate3d(100%, 0, 0);
        opacity: 0;
    }
</style>