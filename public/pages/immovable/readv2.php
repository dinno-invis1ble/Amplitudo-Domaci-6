<?php

    include_once '../src/models/create_tables.php';
    include "../src/controllers/immovable_controller.php";

    if(isset($_POST['filter']) && $_POST['filter'] === 'true') {
        isset($_POST['price_down']) && is_numeric($_POST['price_down']) ? $price_down = $pdo->quote($_POST['price_down']) : $price_down = '\'0\'';
        isset($_POST['price_up']) && is_numeric($_POST['price_up']) ? $price_up = $pdo->quote($_POST['price_up']) : $price_up = '\'99999999\'';
        isset($_POST['area_down']) && is_numeric($_POST['area_down']) ? $area_down = $pdo->quote($_POST['area_down']) : $area_down = '\'0\'';
        isset($_POST['area_up']) && is_numeric($_POST['area_up']) ? $area_up = $pdo->quote($_POST['area_up']) : $area_up = '\'99999999\'';
        isset($_POST['description']) && $_POST['description'] !== '' ? $description = '%'.$_POST['description'].'%' : $description = '\'null\'';
        isset($_POST['construction_date_down']) && strtotime($_POST['construction_date_down']) ? $construction_date_down = $pdo->quote($_POST['construction_date_down']) : $construction_date_down = '\'1500-01-01\'';
        isset($_POST['construction_date_up']) && strtotime($_POST['construction_date_up']) ? $construction_date_up = $pdo->quote($_POST['construction_date_up']) : $construction_date_up = '\''.date("Y-m-d").'\'';
        isset($_POST['city_id']) && is_numeric($_POST['city_id']) ? $city_id = $pdo->quote($_POST['city_id']) : $city_id = '\'null\'';
        isset($_POST['ad_type_id']) && is_numeric($_POST['ad_type_id']) ? $ad_type_id = $pdo->quote($_POST['ad_type_id']) : $ad_type_id = '\'null\'';
        isset($_POST['immovable_type_id']) && is_numeric($_POST['immovable_type_id']) ? $immovable_type_id = $pdo->quote($_POST['immovable_type_id']) : $immovable_type_id = '\'null\'';

        $immovables = readFilteredImmovables($price_down, $price_up, $area_down, $area_up, $description, $construction_date_down, $construction_date_up, $city_id, $ad_type_id, $immovable_type_id, $pdo);
    } else {
        $immovables = readImmovables($pdo);
    }


    include "../src/controllers/cities_controller.php";
    include "../src/controllers/immovable_type_controller.php";
    include "../src/controllers/ad_type_controller.php";

?>

<a class="create_immovable" href="/Domaci-6/?page=createv2">Create immovable</a>
<div class="container">

    <form class="search_form" action="?page=readv2" method="POST">
        <input type="hidden" name="filter" value="true" />
        <div>
            <input type="number" id="price_down" name="price_down" placeholder="From price" <?=isset($price_down) && $price_down !== '\'0\'' ? "value=$price_down" : ""?>>
            <input type="number" id="price_up" name="price_up" placeholder="To price" <?=isset($price_up) && $price_up !== '\'99999999\'' ? "value=$price_up" : ''?>>
        </div>
        <div>
            <input type="number" id="area_down" name="area_down" placeholder="From area" <?=isset($area_down) && $area_down !== '\'0\'' ? "value=$area_down" : ''?>>
            <input type="number" id="area_up" name="area_up" placeholder="To area" <?=isset($area_up) && $area_up !== '\'99999999\'' ? "value=$area_up" : ''?>>
        </div>
            <input type="text" id="description" name="description" placeholder="Description" <?=isset($description) && $description !== '\'null\'' ? "value=$description" : ''?>>
        <div>
            <label for="from_date">From date:</label>
            <input type="date" id="from_date" name="construction_date_down" <?=isset($construction_date_down) && $construction_date_down !== '\'1500-01-01\'' ? "value=$construction_date_down" : ''?>>
            <label for="to_date">To date:</label>
            <input type="date" id="to_date" name="construction_date_up" <?=isset($construction_date_up) ? "value=$construction_date_up" : ''?>>
        </div>
        <select aria-label="Select city" name="city_id">
            <option <?=isset($immovable_type_id) ? '' : 'selected="1"' ?> value="null">Select city</option>

            <?php
                $cities = readCities($pdo);

                foreach($cities as $city) {
                    $city_id2 = $city['id'];
                    $city_name = $city['city'];

                    isset($city_id) && $city_id === "'$city_id2'" ? $selected = 'selected="1"' : $selected = '';

                    echo "<option $selected value='$city_id2'>
                            $city_name
                        </option>";
                }
            ?>
        </select>
        <select name="immovable_type_id">
            <option <?=isset($immovable_type_id) ? '' : 'selected="1"' ?> value="null">Select immovable type</option>

            <?php
                $types = readImmovableTypes($pdo);

                foreach($types as $type) {
                    $type_id = $type['id'];
                    $type_name = $type['type'];

                    isset($immovable_type_id) && $immovable_type_id === "'$type_id'" ? $selected = 'selected="1"' : $selected = '';

                    echo "<option $selected value='$type_id'>
                            $type_name
                        </option>";
                }
            ?>
        </select>
        <select name="ad_type_id">
            <option <?=isset($immovable_type_id) ? '' : 'selected="1"' ?> value="null">Select ad type</option>

            <?php
                $types = readAdTypes($pdo);

                foreach($types as $type) {
                    $type_id = $type['id'];
                    $type_name = $type['type'];

                    isset($ad_type_id) && $ad_type_id === "'$type_id'" ? $selected = 'selected="1"' : $selected = '';

                    echo "<option $selected value='$type_id'>
                            $type_name
                        </option>";
                }
            ?>
        </select>
        <div>
            <button type="submit">Search</button>
        </div>
    </form>



    <div class="content">
        <?php
            foreach($immovables as $immovable) {
                $immovable_id = $immovable['id'];
                $immovable_price = $immovable['price'];
                $immovable_area = $immovable['area'];
                $immovable_description = $immovable['description'];
                $immovable_construction_date = $immovable['construction_date'];
                $immovable_city = $immovable['city'];
                $immovable_ad_type = $immovable['ad_type'];
                $immovable_immovable_type = $immovable['immovable_type'];
                $immovable_status = $immovable['status'] ? 'sold' : 'available';
                $status_color = $immovable['status'] ? 'red' : 'green';
                echo "
                    <div class='item'>
                        <input type='hidden' value='$immovable_id' />
                        <img src='./img/602afe03e7d15.png' alt='slika' class='thumbnail' />
                        <div class='info'>
                            <h2>$immovable_immovable_type <span class='location'> | $immovable_city</span></h2>
                            <p class='description'>$immovable_description</p>
                            <div class='price_info'>
                                <p>Price: $immovable_price $</p>
                                <p>Area: $immovable_area m2</p>
                                <p>Date: $immovable_construction_date</p>
                            </div>
                        </div>
                        <div style='border-left: 1px solid #ccc; padding-left: 10px;'>
                            <p style='padding: 10px; border: 1px solid #ccc; color: $status_color'>$immovable_status</p>
                            <br>
                            <p>
                                <a href=\"?page=singlev2&id=$immovable_id\">View</a>
                            </p>
                            <br>
                            <a href='/Domaci-6/?page=delete&id=$immovable_id' style='color: red;'>DELETE</a>
                            <br><br>
                            <a href='/Domaci-6/?page=updatev2&id=$immovable_id' style='color: orange;'>EDIT</a>
                        </div>
                    </div>
                ";
            }
        ?>
    </div>
</div>