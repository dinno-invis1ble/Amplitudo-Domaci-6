<?php
    isset($_POST["immovable_type"]) ? $immovable_type = $_POST["immovable_type"] : $immovable_type = null;
    
    if($immovable_type !== '' && $immovable_type !== null) {
        include_once '../src/models/create_tables.php';
        include "../src/controllers/immovable_type_controller.php";
        
        addImmovableType($immovable_type, $pdo);
    }
?>

<link href="./css/city.css" type="text/css" rel="stylesheet" />
<div class="city_add_update">
    <form action="immovable_types.php?page=create" method="POST">
        <input type="text" name="immovable_type" placeholder="Enter immovable type name" />

        <button type="submit">Add immovable type</button>
    </form>
</div>