package main

import (
	"bytes"
	"encoding/binary"
	"encoding/json"
	"fmt"
	"io/ioutil"
	"log"
	"math"
	"net/http"
	"os"
	"os/exec"
	"path/filepath"
	"strconv"
	"time"

	"github.com/tbrandon/mbserver"
)

/* Карта Modbus
i  adr
0 (1)	- не используется
1 (2)	- Статус соединения
10 (11) ... 199 (200)	- devices
200 (201) ... * (*)		- tags
*/

var ipAPI string = "http://196.90.201.181:8081/api/" // для PH
//var ipAPI string = "http://192.168.71.111/api/"      // для теста
var ipModbus string = "196.90.201.181:572" // для PH
//var ipModbus string = "196.90.201.254:572" // для теста
var urlGetReqDev string = ipAPI + "device/view"
var urlPutReqDev string = ipAPI + "device/" // + id Device
var urlGetReqTag string = ipAPI + "tag/view"
var urlPutReqTag string = ipAPI + "tag/" // + id Tag

// Device from DCS
type Device struct {
	ID    int
	Value uint16
}

// Tag from DCS
type Tag struct {
	ID    int
	Value float32
}

var devices = []Device{}
var tags = []Tag{}
var modbusDevices []uint16
var modbusTags []float32
var startHoldRegDevices = 10 // Начальный индекс в массиве serv.HoldingRegisters[] для Devices
var startHoldRegTags = 200   // Начальный индекс в массиве serv.HoldingRegisters[] для Tags
var statusModbus uint16      // 0 регистр в modbus

func main() {
	initDevices()
	initTags()
	go runModbus()

	fmt.Println("Init")
	doLog("Запуск программы")

	timerInit := time.NewTimer(time.Second * 10)
	<-timerInit.C
	fmt.Println("Run")

	//go checkModbusConnect(statusModbus)
	go updateDevice()
	go updateTag()

	select {}
}

// Инициализация массива devices и создание среза modbusDevices
func initDevices() {
	json.Unmarshal([]byte(getInfo(urlGetReqDev)), &devices)
	modbusDevices = make([]uint16, len(devices))
}

// Инициализация массива values и создание среза modbusValues
func initTags() {
	json.Unmarshal([]byte(getInfo(urlGetReqTag)), &tags)
	modbusTags = make([]float32, len(tags))
}

// Отправка нового значения в БД
func updateDevice() {
	for {
		time.Sleep(1 * time.Second)

		for i := 0; i < len(modbusDevices); i++ {
			if devices[i].Value != modbusDevices[i] {
				devices[i].Value = modbusDevices[i]
				setDevice(devices[i], urlPutReqDev)
			}
		}
	}
}

// Отправка нового значения в БД
func updateTag() {
	for {
		time.Sleep(1 * time.Second)

		for i, tag := range tags {
			if tag.Value != modbusTags[i] {
				tag.Value = modbusTags[i]
				setTag(tag, urlPutReqDev)
			}
		}
	}
}

// Запуск сервера модбас
func runModbus() {
	serv := mbserver.NewServer()
	err := serv.ListenTCP(ipModbus)
	if err != nil {
		log.Printf("%v\n", err)
		doLog(err.Error())
	}
	defer serv.Close()

	statusModbus = serv.HoldingRegisters[1]

	for {
		time.Sleep(2 * time.Second)

		// Заполнение Devices из Modbus
		for i := 0; i < len(devices); i++ {
			deviceValue := serv.HoldingRegisters[startHoldRegDevices+i]
			modbusDevices[i] = deviceValue
		}

		// Заполнение Tags из Modbus
		endReg := 0
		for j := 0; j < len(tags); j++ {
			startTagSlice := startHoldRegTags + j + endReg
			endTagSlice := startHoldRegTags + j + endReg + 2
			rawValue := serv.HoldingRegisters[startTagSlice:endTagSlice]
			modbusTags[j] = generateValue(rawValue, "CDAB")
			endReg++
		}
	}
}

// Проверка досутпности Modbus клиента
// В регистре 1 (uint16 BA) из клиента записываем число отличное от 0
func checkModbusConnect(value uint16) {
	if value == 0 {
		doLog("Ошибка связи с modbus клиентом")
		os.Exit(1)
	}
	for {
		time.Sleep(30 * time.Minute)

		if value == 0 {
			doLog("Ошибка связи с modbus клиентом")
			os.Exit(1)
		}
	}
}

//Generate float from raw register with order (default CD AB)
func generateValue(raw []uint16, order string) float32 {
	halfArrBytes := make([]byte, 2)
	fullArrBytes := make([]byte, 0)
	correctArrBytes := make([]byte, 0)
	byteOrder := [4]int{}

	switch order {
	case "ABCD":
		byteOrder = [4]int{0, 1, 2, 3}
	case "CDAB":
		byteOrder = [4]int{2, 3, 0, 1}
	case "BADC":
		byteOrder = [4]int{1, 0, 3, 2}
	case "DCBA":
		byteOrder = [4]int{3, 2, 1, 0}
	default:
		byteOrder = [4]int{2, 3, 0, 1}
	}

	for _, value := range raw {
		binary.BigEndian.PutUint16(halfArrBytes, value)
		fullArrBytes = append(fullArrBytes, halfArrBytes...)
	}
	for _, value := range byteOrder {
		correctArrBytes = append(correctArrBytes, fullArrBytes[value])
	}
	bits := binary.BigEndian.Uint32(correctArrBytes)

	return math.Float32frombits(bits)
}

// Получение значений из API
func getInfo(url string) []byte {
	resp, err := http.Get(url)
	if err != nil {
		log.Printf("%v\n", err)
		doLog(err.Error())
	}
	info, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		log.Printf("%v\n", err)
		doLog(err.Error())
	}

	return info
}

// Передача JSON устройства по API
func setDevice(device Device, url string) {
	b, _ := json.Marshal(device)
	url = url + strconv.Itoa(device.ID)

	client := &http.Client{}
	req, _ := http.NewRequest(http.MethodPut, url, bytes.NewBuffer(b))
	req.Header.Set("Content-Type", "application/json; charset=utf-8")

	resp, err := client.Do(req)
	if err != nil {
		log.Printf("%v\n", err)
		doLog(err.Error())
	}
	fmt.Println("Установка нового значения для device=", device)
	if resp.StatusCode == 200 {
		fmt.Println("Значение записано в БД, код ответа - ", resp.StatusCode)
	}

}

// Передача JSON тега по API
func setTag(tag Tag, url string) {
	b, _ := json.Marshal(tag)
	url = url + strconv.Itoa(tag.ID)

	client := &http.Client{}
	req, _ := http.NewRequest(http.MethodPut, url, bytes.NewBuffer(b))
	req.Header.Set("Content-Type", "application/json; charset=utf-8")

	resp, err := client.Do(req)
	if err != nil {
		log.Printf("%v\n", err)
		doLog(err.Error())
	}
	if resp.StatusCode == 200 {
		fmt.Println("Значение записано в БД, код ответа - ", resp.StatusCode)
	}
}

// Запись лога  в файл
func doLog(info string) {
	dir, _ := filepath.Abs(filepath.Dir(os.Args[0]))
	path := dir + "/servmango.log"
	fmt.Println(path)
	fileLog, err := os.OpenFile(path, os.O_APPEND|os.O_CREATE|os.O_WRONLY, 0644)
	fmt.Println(fileLog)

	if err != nil {
		fmt.Println("Unable to create file:", err)
		os.Exit(1)
	}
	defer fileLog.Close()

	logger := log.New(fileLog, "Дата: ", log.LstdFlags)
	logger.Println(info)

}

// Запуск очередей для консольных команд в Yii2
func runQue() {
	ticker := time.NewTicker(1 * time.Second)
	for range ticker.C {
		exec.Command("cmd", "/c", "php E:\\OSPanel\\domains\\scop\\yii queue/run").Output()
		log.Printf("%v\n", "Execute Queue")
	}
}
