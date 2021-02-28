<?php

    include_once '../src/models/create_tables.php';
    include "../src/controllers/cities_controller.php";

    $data = array();

    if(isset($_POST['id']) && isset($_POST['city'])) {
        $id = $_POST['id'];
        $city = $_POST['city'];

        updateCity($id, $city, $pdo);
    } else {
        isset($_GET['id']) ? $id = $_GET['id'] : exit('You need to provide valid id');
    
        $data = getCityById($id, $pdo);
    }


?>

<link href="./css/city.css" type="text/css" rel="stylesheet" />
<div class="city_add_update">
    <form action="cities.php?page=update" method="POST">
        <input type="hidden" name="id" value=<?=$data[0]['id']?> />
        <input type="text" name="city" value="<?=$data[0]['city']?>" />
        <button type="submit">Update</button>
    </form>
</div>