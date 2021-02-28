<?php

    include_once '../src/models/create_tables.php';

    isset($_POST["is_submited"]) ? $is_submited = $_POST["is_submited"] : $is_submited = null;

    if($is_submited === 'true') {
        isset($_POST["price"]) && $_POST["price"] !== '' ? $price = $_POST["price"] : exit('Price should be defined...');
        isset($_POST["area"]) && $_POST["area"] !== '' ? $area = $_POST["area"] : exit('Area should be defined...');
        isset($_POST["description"]) && $_POST["description"] !== '' ? $description = $_POST["description"] : exit('Description should be defined...');
        isset($_POST["city_id"]) && $_POST["city_id"] !== '' ? $city_id = $_POST["city_id"] : exit('City should be defined...');
        isset($_POST["ad_type_id"]) && $_POST["ad_type_id"] !== '' ? $ad_type_id = $_POST["ad_type_id"] : exit('Ad type should be defined...');
        isset($_POST["immovable_type_id"]) && $_POST["immovable_type_id"] !== '' ? $immovable_type_id = $_POST["immovable_type_id"] : exit('immovable type should be defined...');
        isset($_POST["construction_date"]) && $_POST["construction_date"] !== '' ? $construction_date = $_POST["construction_date"] : $construction_date = null;

        include "../src/controllers/immovable_controller.php";

        $photos = $_FILES["photos"];

        $upload_photo = false;

        if($photos["name"][0]) {
            $upload_photo = $photos;
        }

        addImmovable($price, $area, $description, $city_id, $ad_type_id, $immovable_type_id, $upload_photo, $construction_date, $pdo);

    }

    include "../src/controllers/cities_controller.php";
    include "../src/controllers/immovable_type_controller.php";
    include "../src/controllers/ad_type_controller.php";
?>


<link href="./css/immovable_create.css" rel="stylesheet" type="text/css" />

<div class="container_create_immovable">
    <form action="/Domaci-6/?page=createv2" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="is_submited" value="true" />
        <input required type="number" name="price" placeholder="Enter price" />
        <input required type="number" name="area" placeholder="Enter area" />
        <input required type="text" name="description" placeholder="Enter description" />
        <label for="construction_date" >Construction date</label>
        <input type="date" id="construction_date" name="construction_date" />

        <select required name="city_id">
            <option value=''>Choose city</option>
            <?php
                // Get all cities
                $cities = readCities($pdo);

                foreach($cities as $city) {
                    $city_id = $city['id'];
                    $city_name = $city['city'];
                    echo "<option value='$city_id'>
                            $city_name
                        </option>";
                }
            ?>
        </select>
        <select required name="ad_type_id">
            <option value=''>Choose ad type</option>
            <?php
                // Get all ad types
                $types = readAdTypes($pdo);

                foreach($types as $type) {
                    $type_id = $type['id'];
                    $type_name = $type['type'];
                    echo "<option value='$type_id'>
                            $type_name
                        </option>";
                }
            ?>
        </select>
        <select required name="immovable_type_id">
            <option value=''>Choose immovable type</option>
            <?php
                // Get all immovable types
                $types = readImmovableTypes($pdo);

                foreach($types as $type) {
                    $type_id = $type['id'];
                    $type_name = $type['type'];
                    echo "<option value='$type_id'>
                            $type_name
                        </option>";
                }
            ?>
        </select>
        <input type="file" name="photos[]" multiple />
        <button type="submit">Add city</button>
    </form>

</div>
