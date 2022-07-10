<?php

define("ROOT", dirname(__FILE__));
require_once(ROOT.'/model.php');

$model = new Model();
$_POST = json_decode(file_get_contents('php://input'), true);
$res = '';

switch($_POST['controller']) {
    case 'nurse':
        foreach ($model->getWardByNurse($_POST['id']) as $el) {
            $res .= "<li>". $el['name'] . "</li>";
        }
        echo json_encode($res);
        break;
    case 'dep':
        foreach ($model->getNurseDepatment(intval($_POST['dep'])) as $el) {
            $res .= "<li>" . $el['name'] . "</li>";
        }
        $res = '<?xml version="1.0" encoding="UTF-8" ?>
        <document>' .
            $res
        . '</document>';
        echo $res;
        break;
    case 'shift':
        foreach ($model->getDutyByShift($_POST['shift']) as $el) {
            $res .= "<li>Медсестра: $el[0]; Палата: $el[1]</li>";
        }
        echo $res;
        break;
    case 'newWard':
        echo $model->insertWard($_POST['name']) ? json_encode($model->getWards()) : 'false';
        break;
    case 'newNurse':
        echo $model->insertNurse($_POST['name'], $_POST['date'], $_POST['department'], $_POST['shift']) ? json_encode($model->getAllNurses()) : 'false';
        break;
    case 'set':
        echo $model->insertNurseWard($_POST['idNurse'], $_POST['idWard']) ? 'true' : 'false';
        break;
}

?>