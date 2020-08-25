/**
 * шина событий
 * sendDeviceToControlBox - направление данных Device -> Controlbox
 * sendControlBoxToDevice - направление данных Controlbox -> Device
 * placardControlBoxToDevice - направление данных Controlbox -> Device
 */
export const eventBus = new Vue();