<?php
require_once "./Database.php";
require_once "./Crud.php";
$data = new Database();
$db = $data->getConnection();
$car = new Carrinho($db);
