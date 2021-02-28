<?php

    include_once '../src/models/create_tables.php';
    include "../src/controllers/immovable_type_controller.php";

    $data = array();

    if(isset($_POST['id']) && isset($_POST['type'])) {
        $id = $_POST['id'];
        $type = $_POST['type'];

        updateImmovableType($id, $type, $pdo);
    } else {
        isset($_GET['id']) ? $id = $_GET['id'] : exit('You need to provide valid id');
    
        $data = getImmovableTypeById($id, $pdo);
    }


?>

<link href="./css/city.css" type="text/css" rel="stylesheet" />
<div class="city_add_update">
    <form action="immovable_types.php?page=update" method="POST">
        <input type="hidden" name="id" value=<?=$data[0]['id']?> />
        <input type="text" name="type" value="<?=$data[0]['type']?>" />
        <button type="submit">Update</button>
    </form>
</div>