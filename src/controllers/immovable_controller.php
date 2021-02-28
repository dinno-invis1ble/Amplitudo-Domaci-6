<?php

    function addImmovable($price, $area, $description, $city_id, $ad_type_id, $immovable_type_id, $upload_photo, $construction_date, $pdo) {
        $stmt = $pdo->prepare("INSERT INTO immovables 
                (price, area, description, city_id, ad_type_id, immovable_type_id, construction_date) 
                VALUES 
                (:price, :area, :description, :city_id, :ad_type_id, :immovable_type_id, :construction_date)");
        
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':area', $area, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':city_id', $city_id, PDO::PARAM_STR);
        $stmt->bindParam(':ad_type_id', $ad_type_id, PDO::PARAM_STR);
        $stmt->bindParam(':immovable_type_id', $immovable_type_id, PDO::PARAM_STR);
        $stmt->bindParam(':construction_date', $construction_date, PDO::PARAM_STR);

        $stmt->execute();

        $immovable_id = $pdo->lastInsertId();
        
        if($upload_photo) {
            for($i = 0; $i < count($upload_photo["name"]); $i++) {
                $photo_name = $upload_photo["name"][$i];

                if(!$upload_photo["error"][$i]) {
                    $tmp_name = $upload_photo["tmp_name"][$i];
   
                    $original_name = $upload_photo['name'][$i];

                    $file_type = explode(".", $original_name );

                    $ext = $file_type[ count($file_type) - 1 ];
                    
                    $new_file_name = "./img/".uniqid().".".$ext;
                    
                    copy($tmp_name, $new_file_name);
                    
                    $stmt5 = $pdo->prepare("INSERT INTO photos (imageUrl, immovable_id) VALUES (:imageUrl, :immovable_id)");
                    $stmt5->bindParam(':imageUrl', $new_file_name);
                    $stmt5->bindParam(':immovable_id', $immovable_id);

                    $stmt5->execute();
                } else {
                    echo "Error occured while uploading $photo_name";
                }
            }
        }

        if($stmt->errorCode() === "00000") {
            header('location: index.php?msg=success');
        } else {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>Something went wrong...</p>");
        }
    }


    function readImmovables($pdo) {
        $stmt = $pdo->prepare("SELECT immovables.id, immovables.status, immovables.price, immovables.area, immovables.description, immovables.construction_date,
        ad_types.type AS ad_type, immovable_types.type AS immovable_type, cities.city AS city FROM immovables 
            JOIN cities ON immovables.city_id = cities.id 
            JOIN ad_types ON immovables.ad_type_id = ad_types.id
            JOIN immovable_types ON immovables.immovable_type_id = immovable_types.id     
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function readFilteredImmovables($price_down, $price_up, $area_down, $area_up, $description, $construction_date_down, $construction_date_up, $city_id, $ad_type_id, $immovable_type_id, $pdo) {
        
        $city_id !== '\'null\'' ? $city = 'city_id' : $city = '\'null\'';
        $ad_type_id !== '\'null\'' ? $ad_type = 'ad_type_id' : $ad_type = '\'null\'';
        $immovable_type_id !== '\'null\'' ? $immovable_type = 'immovable_type_id' : $immovable_type = '\'null\'';
        $description !== '\'null\'' ? $description_filter = 'description' : $description_filter = '\'null\'';

        $description = deleteAllApostrophes($description);

        $query = "SELECT immovables.id, immovables.status, immovables.sale_date, immovables.price, immovables.area, immovables.description, immovables.construction_date,
                         ad_types.type AS ad_type, immovable_types.type AS immovable_type, cities.city AS city 
                         FROM immovables 
            JOIN cities ON immovables.city_id = cities.id 
            JOIN ad_types ON immovables.ad_type_id = ad_types.id
            JOIN immovable_types ON immovables.immovable_type_id = immovable_types.id
            
            WHERE 
                (price BETWEEN $price_down AND $price_up) AND 
                (area BETWEEN $area_down AND $area_up) AND 
                (construction_date BETWEEN $construction_date_down AND $construction_date_up) AND 
                ($description_filter LIKE '$description') AND 
                ($city = $city_id) AND 
                ($ad_type = $ad_type_id) AND 
                ($immovable_type = $immovable_type_id)
        ";


        $results = $pdo->query($query);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }


    function getImmovableById($id, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM immovables WHERE id = :id");
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!count($data)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");
        }

        return $data;
    }


    function updateImmovable($id, $price, $area, $description, $city_id, $ad_type_id, $immovable_type_id, $construction_date, $status, $sale_date, $pdo) {
        $stmt2 = $pdo->prepare("SELECT * FROM immovables WHERE id = :id");
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();

        $exists = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if(!count($exists)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");
        }


        $stmt = $pdo->prepare("UPDATE immovables 
            SET price = :price,
                area = :area,
                description = :description,
                city_id = :city_id,
                ad_type_id = :ad_type_id,
                immovable_type_id = :immovable_type_id,
                construction_date = :construction_date,
                status = :status,
                sale_date = :sale_date
            WHERE id = :id");
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':area', $area);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':city_id', $city_id);
        $stmt->bindParam(':ad_type_id', $ad_type_id);
        $stmt->bindParam(':immovable_type_id', $immovable_type_id);
        $stmt->bindParam(':construction_date', $construction_date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':sale_date', $sale_date);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        if($stmt->errorCode() === "00000") {
            header('location: index.php?msg=success');
        } else {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>Something went wrong...</p>");
        }
    }


    function deleteImmovable($id, $pdo) {
        $stmt2 = $pdo->prepare("SELECT * FROM immovables WHERE id = :id");
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();

        $exists = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if(!count($exists)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");
        }

        try {
            // Get all photos of immovable
            $stmt_photos = $pdo->prepare("SELECT * FROM photos WHERE immovable_id = :id");
            $stmt_photos->bindParam(":id", $id);
            $stmt_photos->execute();
            $all_photos = $stmt_photos->fetchAll(PDO::FETCH_ASSOC);

            // Deleting photos from server (From db we delete it cascade)
            foreach($all_photos as $photo_data) {
                file_exists($photo_data['imageUrl']) && unlink($photo_data['imageUrl']);
            }

        } catch(Exception $e) {
            echo "Something went wrong while deleting photos from server...";
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM immovables WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch(Exception $e) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>Something went wrong...</p>");
        }

        if($stmt->errorCode() === "00000") {
            
            header('location: index.php?msg=success');
        } else {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>Something went wrong...</p>");
        }
    }


    function readSingleImmovable($id, $pdo) {
        $stmt2 = $pdo->prepare("SELECT * FROM immovables WHERE id = :id");
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();

        $exists = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if(!count($exists)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");
        }


        $stmt = $pdo->prepare("SELECT immovables.id, immovables.status, immovables.sale_date, immovables.price, immovables.area, immovables.description, immovables.construction_date,
        ad_types.type AS ad_type, immovable_types.type AS immovable_type, cities.city AS city FROM immovables 
            JOIN cities ON immovables.city_id = cities.id 
            JOIN ad_types ON immovables.ad_type_id = ad_types.id
            JOIN immovable_types ON immovables.immovable_type_id = immovable_types.id
            WHERE immovables.id = :id
        ");

        $stmt1 = $pdo->prepare("SELECT imageUrl FROM photos WHERE immovable_id = :id");
        
        $stmt1->bindParam(':id', $id);
        $stmt->bindParam(':id', $id);


        $stmt->execute();
        $stmt1->execute();

        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $photos = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        return [$details, $photos];

    }


    function deleteAllApostrophes($str) {
        $q = str_replace("'", "", $str);
        $p = str_replace('"', '', $q);
        $g = str_replace('`', '', $p);
        return $g;
    }

?>