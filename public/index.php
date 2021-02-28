<?php 

    // Creating database and tables if they doesn't exists
    include '../src/models/create_tables.php'; 
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styles.css" type="text/css" rel="stylesheet" />
    <title>Welcome to...</title>
</head>
<body>

    <header>
        <span>
            <a href="/Domaci-6">Home</a>
        </span>
        <div class="items">
            <a href="/Domaci-6/">Immovables</a>
            <a href="/Domaci-6/cities.php">Cities</a>
            <a href="/Domaci-6/immovable_types.php">Immovable types</a>
        </div>
    </header>

    
    <?php

        isset($_GET["page"]) ? $page = $_GET["page"] : $page = "default";

        $arr = array('updatev2', 'delete', 'singlev2', 'createv2');
                
        if(in_array($page, $arr, true)) {
            include "./pages/immovable/$page.php";
        } else {
            include './pages/immovable/readv2.php';
        }

    ?>
</body>
</html>