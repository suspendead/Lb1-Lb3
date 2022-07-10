<? 
    define("ROOT", dirname(__FILE__));
    require_once(ROOT.'/model.php');

    $model = new Model();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Medical Center</title>
</head>
<body>
    <span>
        <label for="select-nurses">Медсестра: </label>
        <select name="nurses" id="select-nurses">
            <option value="" disabled selected>Не выбрано</option>
        <? foreach($model->getAllNurses() as $nurse) { ?>
            <option value="<?= $nurse['id_nurse'] ?>"><?= $nurse['name'] ?></option>
        <? } ?>
        </select>
        <ul id="list-wards"></ul>
    </span>
    <span class="container">
        <label for="select-department">Отделение: </label>
        <select name="department" id="select-department">
            <option value="" disabled selected>Не выбрано</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <ul id="list-nurse"></ul>
    </span>
    <span>
        <label for="select-shift">Смена: </label>
        <select name="shift" id="select-shift">
            <option value="" disabled selected>Не выбрано</option>
            <option value="First">Первая</option>
            <option value="Second">Вторая</option>
            <option value="Third">Третья</option>
        </select>
        <ul id="list-duty"></ul>
    </span>
    <div>
        <input type="text" id="name-ward" placeholder="Название палаты">
        <button id="add-ward">Добавить палату</button>
    </div><br>
    <form id="new-nurse">
        <input type="text" name="name">
        <input type="date" name="date">
        <select name="department">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <select name="shift">
            <option value="First">Первая</option>
            <option value="Second">Вторая</option>
            <option value="Third">Третья</option>
        </select>
        <button name="add">Добавить</button>
    </form>
    <br>
    <form id="nurse-ward">
        <select name="nurses">
            <option value="" disabled selected>Не выбрано</option>
        <? foreach($model->getAllNurses() as $nurse) { ?>
            <option value="<?= $nurse['id_nurse'] ?>"><?= $nurse['name'] ?></option>
        <? } ?>
        </select>
        <select name="wards">
            <option value="" disabled selected>Не выбрано</option>
        <? foreach($model->getWards() as $ward) { ?>
            <option value="<?= $ward['id_ward'] ?>"><?= $ward['name'] ?></option>
        <? } ?>
        </select>
        <button name="set">Присвоить</button>
    </form>

    <script src="script.js" defer></script>
</body>
</html>