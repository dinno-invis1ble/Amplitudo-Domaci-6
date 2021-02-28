<?php

    include_once '../src/models/create_tables.php';
    include "../src/controllers/immovable_type_controller.php";

    $types = readImmovableTypes($pdo);

?>

<link href="./css/city_read.css" type="text/css" rel="stylesheet" />
<a href="/Domaci-6/immovable_types.php?page=create" class="create_new_city">Create immovable type</a>
<div class="city_read_container">
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($types as $type) {
                    $type_id = $type['id'];
                    $type_name = $type['type'];
                    echo "
                        <tr>
                            <td>$type_id</td>
                            <td>$type_name</td>
                            <td><a style='color: orange;' href='/Domaci-6/immovable_types.php?page=update&id=$type_id'>EDIT</a></td>
                            <td><a style='color: red;' href='/Domaci-6/immovable_types.php?page=delete&id=$type_id'>DELETE</a></td>
                        </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
</div>