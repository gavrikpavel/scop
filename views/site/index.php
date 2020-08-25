<?php

/* @var $this yii\web\View */

$this->title = 'Оперативный Журнал';
?>
<?= $this->render('@app/views/site/template/template_site.html') ?>

<div class="site-index">
    <div class="row">
        <div class="content">
            <div id="site">
                <months-el>
                </months-el>



<!--                <div class="index-block">-->
<!--                    <div class="elem month">Январь</div>-->
<!--                    <div class="elem month">Февраль</div>-->
<!--                    <div class="elem month">Март</div>-->
<!--                    <div class="elem month">Апрель</div>-->
<!--                    <div class="elem month">Май</div>-->
<!--                    <div class="elem month">Июнь</div>-->
<!--                    <div class="elem month tetet">Июль</div>-->
<!--                    <div class="elem month">Август</div>-->
<!--                    <div class="elem month">Сентябрь</div>-->
<!--                    <div class="elem month">Октябрь</div>-->
<!--                    <div class="elem month">Ноябрь</div>-->
<!--                    <div class="elem month">Декабрь</div>-->
<!--                </div>-->

                <div class="bdm-block">
                    <div class="elem bdm rr">
                        <div class="bdm-title">
                            <p>БДМ-1</p>
                            <p>РАБОТА</p>
                        </div>
                        <div class="bar-field ">
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
                            </div>
                            <p>В работе - 764 ч</p>

                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 10%"></div>
                            </div>
                            <p>В обрыве - 72 ч</p>

                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 30%"></div>
                            </div>
                            <p>В останове - 216 ч</p>
                        </div>
                    </div>

                    <div class="elem bdm rr ">
                        <div class="bdm-title">
                            <p>БДМ-2</p>
                            <p>РАБОТА</p>
                        </div>
                        <div class="bar-field">
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
                            </div>
                            <p>В работе - 764 ч</p>

                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 10%"></div>
                            </div>
                            <p>В обрыве - 72 ч</p>

                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 30%"></div>
                            </div>
                            <p>В останове - 216 ч</p>
                        </div>
                    </div>

                    <div class="elem bdm oo ">
                        <div class="bdm-title">
                            <p>БДМ-3</p>
                            <p>ОСТАНОВ</p>
                        </div>
                        <div class="bar-field">
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
                            </div>
                            <p>В работе - 764 ч</p>

                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 10%"></div>
                            </div>
                            <p>В обрыве - 72 ч</p>

                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 30%"></div>
                            </div>
                            <p>В останове - 216 ч</p>
                        </div>
                    </div>

                    <div class="elem bdm ob ">
                        <div class="bdm-title">
                            <p>БДМ-5</p>
                            <p>ОБРЫВ</p>
                        </div>
                        <div class="bar-field">
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 10%"></div>
                            </div>
                            <p>В обрыве - 72 ч</p>
                        </div>
                    </div>

                    <div class="elem bdm ">
                        <div class="bdm-title">
                            <p>БДМ-6</p>
                            <p></p>
                        </div>
                        <div class="bar-field">
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 10%"></div>
                            </div>
                            <p>В обрыве - 72 ч</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
