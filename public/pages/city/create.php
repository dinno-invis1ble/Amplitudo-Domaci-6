<?php
    isset($_POST["city"]) ? $city = $_POST["city"] : $city = null;
    
    if($city !== '' && $city !== null) {
        include_once '../src/models/create_tables.php';
        include "../src/controllers/cities_controller.php";
        
        addCity($city, $pdo);
    }
?>

<link href="./css/city.css" type="text/css" rel="stylesheet" />
<div class="city_add_update">
    <form action="cities.php?page=create" method="POST">
        <input type="text" name="city" placeholder="Enter city name" />
    
        <button type="submit">Add city</button>
    </form>
</div>