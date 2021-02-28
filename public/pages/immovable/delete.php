<?php

    include_once '../src/models/create_tables.php';
    include "../src/controllers/immovable_controller.php";

    isset($_GET['id']) ? $id = $_GET['id'] : exit('You need to provide an valid id');

    deleteImmovable($id, $pdo);

?>