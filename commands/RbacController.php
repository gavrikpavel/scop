<?php
namespace app\commands;

use app\rbac\AuthorRecordRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        // Применить RBAC - php yii rbac/init
        $auth = Yii::$app->authManager;

        // Создание ролей
        $guest  = $auth->createRole('guest');
        $operator  = $auth->createRole('operator');
        $engineer = $auth->createRole('engineer');
        $admin  = $auth->createRole('admin');


        // Создание разрешений для сайта
        $adminPanel = $auth->createPermission('adminPanel');
        $index = $auth->createPermission('index');
        $error = $auth->createPermission('error');
        $login = $auth->createPermission('login');
        $logout = $auth->createPermission('logout');
        $schema = $auth->createPermission('schema');
        $smena = $auth->createPermission('smena');
        $takeSmena = $auth->createPermission('takeSmena');
        $giveSmena = $auth->createPermission('giveSmena');
        $switch = $auth->createPermission('switch'); // выполнение переключений

        // Создание разрешений для журнала
        $indexRecord = $auth->createPermission('indexRecord');
        $createRecord = $auth->createPermission('createRecord');
        $updateRecord = $auth->createPermission('updateRecord');
        $viewRecord = $auth->createPermission('viewRecord');


        // Добавление правила для редактирования записи
        $rule = new AuthorRecordRule();
        $auth->add($rule);
        $updateRecord->ruleName = $rule->name;



        // Добавление разрешений в auth
        $auth->add($adminPanel);
        $auth->add($index);
        $auth->add($error);
        $auth->add($login);
        $auth->add($logout);
        $auth->add($schema);
        $auth->add($smena);
        $auth->add($takeSmena);
        $auth->add($giveSmena);
        $auth->add($switch);
        $auth->add($indexRecord);
        $auth->add($createRecord);
        $auth->add($updateRecord);
        $auth->add($viewRecord);


        // Добавление ролей в auth
        $auth->add($guest);
        $auth->add($operator);
        $auth->add($engineer);
        $auth->add($admin);


        // Привязка разрешений к роли Guest
        $auth->addChild($guest, $index);
        $auth->addChild($guest, $error);
        $auth->addChild($guest, $login);
        $auth->addChild($guest, $logout);
        $auth->addChild($guest, $schema);
        $auth->addChild($engineer, $smena);
        $auth->addChild($guest, $indexRecord);

        // Привязка разрешений к роли Operator
        $auth->addChild($operator, $smena);
        $auth->addChild($operator, $takeSmena);
        $auth->addChild($operator, $giveSmena);
        $auth->addChild($operator, $switch);
        $auth->addChild($operator, $createRecord);
        $auth->addChild($operator, $updateRecord);
        $auth->addChild($operator, $viewRecord);
        $auth->addChild($operator, $guest);

        // Привязка разрешений к роли Engineer
        $auth->addChild($engineer, $guest);

        // Привязка разрешений к роли Admin
        $auth->addChild($admin, $adminPanel);
        $auth->addChild($admin, $operator);
        $auth->addChild($admin, $engineer);


        // Назначение ролей пользователям. userId = id в таблице User
        $auth->assign($engineer, 1); // оператор АСУ ТП
        $auth->assign($engineer, 2); // инженер
        $auth->assign($admin, 3);   // админ

        $auth->assign($operator, 4); // КИП

    }
}
