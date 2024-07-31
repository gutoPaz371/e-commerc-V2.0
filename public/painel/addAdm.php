<?php
    require_once "../../config/Database.php";
    require_once "../../config/Crud.php";
    $data = new Database();
    $db = $data->getConnection();
    $adm = new Adm($db);
    $adm->user=$_GET['user'];
    $adm->pass=password_hash($_GET['pass'],PASSWORD_DEFAULT);
    $adm->insert();
?>