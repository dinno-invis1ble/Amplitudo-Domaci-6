<?php

    isset($_GET['id']) && is_numeric($_GET['id']) ? $id = $_GET['id'] : exit('You need to provide an id...');

    include_once '../src/models/create_tables.php';
    include "../src/controllers/immovable_controller.php";

    $data = readSingleImmovable($id, $pdo);
    $immovable = $data[0][0];
    $photos = $data[1];
?>

<link href="./css/immovable_single.css" type="text/css" rel="stylesheet" />
<div class="container_immovable_single">
    <input type="hidden" value=<?=$immovable['id']?> />


    <p>Immovable Type: <?=$immovable['immovable_type']?></p>
    <p>Description: <?=$immovable['description']?></p>
    <p>Price: <?=$immovable['price']?></p>
    <p>Area: <?= $immovable['area']?></p>
    <p>Construction date: <?=$immovable['construction_date']?></p>
    <p>Status: <?= $immovable['status'] || $immovable['sale_date'] ? 'Sold' : 'Available' ?></p>
    <?= $immovable['sale_date'] || $immovable['status'] ? "<p>Sale date: ".$immovable['sale_date']."</p>" : ''?>
    <p>City: <?=$immovable['city']?></p>
    <p>AD Type: <?=$immovable['ad_type']?></p>
    <a href=<?="/Domaci-6/?page=delete&id=".$immovable['id']?> class="button_immovable_delete">DELETE</a>
    <a href=<?="/Domaci-6/?page=updatev2&id=".$immovable['id']?> class="button_immovable_edit">EDIT</a>
    <h2>PHOTOS:</h2>
    <div>    
        <?php
            foreach($photos as $photo) {
                $src = $photo['imageUrl'];
                echo "<img src='$src' alt='Photo' style='width: 400px; margin: 15px;' />";
            }
        ?>
    </div>
</div>