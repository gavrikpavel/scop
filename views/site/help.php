<?php

/* @var $this yii\web\View */

$this->title = 'Оперативный Журнал';
?>
<div class="site-help">
    <div class="row">
        <div class="content">
            <br>
            <div class="col-xs-2">
                <ul class="list-group" style="position:fixed;">
                    <li class="list-group-item"><a href="#auth">Авторизация</li>
                    <li class="list-group-item"><a href="#smena">Смена</li>
                    <li class="list-group-item"><a href="#schema">Схема</li>
                    <li class="list-group-item"><a href="#journal">Журнал</li>
                </ul>
            </div>
            <div class="col-xs-10">
                <div class="page-header">
                    <h1><a name="auth"></a>Авторизация</h1>
                </div>
                <p class="lead">
                    Для того, чтобы использовать все функции оперативного журнала необходимо авторизоваться. Не авторизованный
                    пользователь имеет доступ только к просмотру электрической схемы.
                </p>
                <img src="/image/help/help_auth.PNG" alt="" class="center-block">
                <div class="page-header">
                    <h3>Уровень доступа</h3>
                </div>
                <p class="lead">В системе имеется 3 уровня доступа:</p>
                <ul>
                    <li><p class="lead">Гость - просмотр электрической схемы</p></li>
                    <li><p class="lead">Инженер - разрешены все функции, кроме управления</p></li>
                    <li><p class="lead">Оператор - разрешены все функции</p></li>
                </ul>
                <div class="page-header">
                    <h1><a name="smena"></a>Смена</h1>
                </div>
                <p class="lead">
                    После авторизации в системе оперативному персоналу доступны функции приема/сдачи смены.</p>
                <img src="/image/help/help_smena.PNG" alt="" class="center-block">
                <br>
                <div class="page-header">
                    <h1><a name="schema"></a>Схема</h1>
                </div>
                <p class="lead">
                    Интерактивная электрическая схема предназначена для контроля за состоянием электрического оборудования.
                    На схеме представлены как ручное оборудование так и оборудование, входящее в состав АСУ ТП ГТУ-ТЭЦ.
                </p>
                <p class="lead">Для взаимодействия со схемой в верхней части сайта расположена панель управления:</p>
                <img src="/image/help/help_schema1.PNG" alt="" class="center-block">
                <br>
                <div class="page-header">
                    <h3>Описание панели управления</h3>
                </div>
                <ol>
                    <li><p class="lead">Плавное увеличение масштаба схемы</p></li>
                    <li><p class="lead">Плавное уменьшение масштаба схемы</p></li>
                    <li><p class="lead">Отобразить схему в полном размере </p></li>
                    <li><p class="lead">Отобразить схему в масштабе</p></li>
                    <li><p class="lead">Перейти в полноэкранный режим (рекомендуется)</p></li>
                    <li><p class="lead">Сброс масштаба схемы в первоначальное состояние</p></li>
                    <li><p class="lead">Выбор отображения схемы по РУ</p></li>
                </ol>
                <div class="page-header">
                    <h3>Переключение оборудования</h3>
                </div>
                <p class="lead">
                    Для выполнения переключений необходимо нажать левой кнопкой мыши по устройству,после чего
                    откроется окно управления оборудованием:
                </p>
                <img src="/image/help/help_schema2.PNG" alt="" class="center-block">
                <br>
                <p class="lead">Для изменения состояния оборудования необходимо нажать кнопку Вкл/Откл в нижней части окна.</p>
                <div class="alert alert-warning" role="alert">
                    Для оборудования, входящего в состав АСУ ТП ГТУ-ТЭЦ не предусмотрено изменение состояния в ручную.
                </div>
                <p class="lead">Для того чтобы повесить плакат необходимо выбрать его из выпадающего списка в верхней части окна и нажать "+"</p>
                <div class="page-header">
                    <h3>Время переключения</h3>
                </div>
                <p class="lead">
                    Обычно время переключения реального оборудования не совпадает с временем переключения на электрической схеме.
                    Для выставления корректного времени переключения необходимо нажать на кнопку с иконкой карандаша и выбрать требуемое время.
                    После этого нажать кнопку "Установить время" и только после этого включить или отключить оборудование на схеме.
                </p>
                <img src="/image/help/help_schema3.PNG" alt="" class="center-block">
                <div class="page-header">
                    <h1><a name="journal"></a>Журнал</h1>
                </div>
                <p class="lead">
                    Журнал содержит список событий, возникающих при переключении оборудования. Записи формируются автоматически.
                    Если возникла необходимость подкорректировать запись, то необходимо нажать на иконку карандаша и внести требуемые изменения.
                </p>
                <div class="alert alert-warning" role="alert">
                    При редактировании записи создается копия старой записи.
                </div>
                <img src="/image/help/help_journal.PNG" alt="" class="center-block" style="width: 90%">
                <br>
                <p class="lead">
                    Все записи можно фильтровать используя поля ввода в верхней части таблицы.
                </p>
                <div class="page-header">
                    <h3>Кнопки управления журналом</h3>
                </div>
                <ul>
                    <li><p class="lead">Сброс - отмена всех фильтров</p></li>
                    <li><p class="lead">Экспорт - конвертация таблицы в xls файл</p></li>
                    <li><p class="lead">Все - отображение всех записей журнала</p></li>
                </ul>
            </div>
        </div>
    </div>
</div>
