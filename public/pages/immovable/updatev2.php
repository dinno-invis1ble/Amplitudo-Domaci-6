<?php


    include_once '../src/models/create_tables.php';
    include "../src/controllers/immovable_controller.php";

    isset($_POST["is_submited"]) ? $is_submited = $_POST["is_submited"] : $is_submited = null;
    
    $data = array();

    if($is_submited === 'true') {
        isset($_POST["price"]) && $_POST["price"] !== '' ? $price = $_POST["price"] : exit('Price should be defined...');
        isset($_POST["area"]) && $_POST["area"] !== '' ? $area = $_POST["area"] : exit('Area should be defined...');
        isset($_POST["description"]) && $_POST["description"] !== '' ? $description = $_POST["description"] : exit('Description should be defined...');
        isset($_POST["city_id"]) && $_POST["city_id"] !== '' ? $city_id = $_POST["city_id"] : exit('City should be defined...');
        isset($_POST["ad_type_id"]) && $_POST["ad_type_id"] !== '' ? $ad_type_id = $_POST["ad_type_id"] : exit('Ad type should be defined...');
        isset($_POST["immovable_type_id"]) && $_POST["immovable_type_id"] !== '' ? $immovable_type_id = $_POST["immovable_type_id"] : exit('immovable type should be defined...');
        isset($_POST["construction_date"]) && $_POST["construction_date"] !== '' ? $construction_date = $_POST["construction_date"] : $construction_date = null;
        isset($_POST['id']) && $_POST['id'] !== '' ? $id = $_POST['id'] : exit('You need to provide valid id');
        isset($_POST['status']) && $_POST['status'] !== '' ? $status = 1 : $status = 0;
        isset($_POST['sale_date']) && $_POST['sale_date'] !== '' ? $sale_date = $_POST['sale_date'] : $sale_date = null;

        updateImmovable($id, $price, $area, $description, $city_id, $ad_type_id, $immovable_type_id, $construction_date, $status, $sale_date, $pdo);
        
    } else {
        isset($_GET['id']) && $_GET['id'] !== '' ? $id = $_GET['id'] : exit('You need to provide valid id...');

        $data = getImmovableById($id, $pdo);
    }


    

    include "../src/controllers/cities_controller.php";
    include "../src/controllers/immovable_type_controller.php";
    include "../src/controllers/ad_type_controller.php";
?>


<link href="./css/immovable_update.css" rel="stylesheet" type="text/css" />
<div class="container_immovable_update">
    <form action="/Domaci-6/?page=updatev2" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="is_submited" value="true" />
        <input type="hidden" name="id" value=<?=$id?> />
        <input required type="number" name="price" placeholder="Enter price" value=<?=$data[0]['price']?> />
        <input required type="number" name="area" placeholder="Enter area" value=<?=$data[0]['area']?> />
        <input required type="text" name="description" placeholder="Enter description" value="<?=$data[0]['description']?>" />
        <label for="construction_date" >Construction date</label>
        <input type="date" id="construction_date" name="construction_date" value=<?=$data[0]['construction_date']?> />
        <label for="status">Sold</label>
        <input type="checkbox" name="status" value='1' id="status" <?=$data[0]['status'] ? 'checked' : ''?> />
        <label for="sale_date">Sale date</label>
        <input type="date" id="sale_date" name="sale_date" value=<?=$data[0]['sale_date']?> />
        <select required name="city_id">
            <option value=''>Choose city</option>
            <?php
                // Get all cities
                $cities = readCities($pdo);

                foreach($cities as $city) {
                    $selected = '';
                    $city_id = $city['id'];
                    $city_name = $city['city'];
    
                    if($city_id === $data[0]['city_id']) {
                        $selected = 'selected="true"';
                    }
    
                    echo "<option $selected value='$city_id'>
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
                    $selected = '';
                    $type_id = $type['id'];
                    $type_name = $type['type'];
    
                    if($type_id === $data[0]['ad_type_id']) {
                        $selected = 'selected="true"';
                    }
    
                    echo "<option $selected value='$type_id'>
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
                    $selected = '';
                    $type_id = $type['id'];
                    $type_name = $type['type'];
    
                    if($type_id === $data[0]['immovable_type_id']) {
                        $selected = 'selected="true"';
                    }
    
                    echo "<option $selected value='$type_id'>
                            $type_name
                        </option>";
                }
            ?>
        </select>
        
        <!-- <input type="file" name="photos[]" multiple /> -->
        <!-- <br><br> -->
        <button type="submit">Update immovable</button>
    </form>
</div>