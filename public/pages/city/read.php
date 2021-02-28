<?php

    include_once '../src/models/create_tables.php';
    include "../src/controllers/cities_controller.php";

    $cities = readCities($pdo);

?>


<link href="./css/city_read.css" type="text/css" rel="stylesheet" />
<a href="/Domaci-6/cities.php?page=create" class="create_new_city">Create city</a>
<div class="city_read_container">
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>City</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($cities as $city) {
                    $city_id = $city['id'];
                    $city_name = $city['city'];
                    echo "
                        <tr>
                            <td>$city_id</td>
                            <td>$city_name</td>
                            <td><a style='color: orange;' href='/Domaci-6/cities.php?page=update&id=$city_id'>EDIT</a></td>
                            <td><a style='color: red;' href='/Domaci-6/cities.php?page=delete&id=$city_id'>DELETE</a></td>
                        </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
</div>