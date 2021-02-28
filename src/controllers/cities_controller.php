<?php

    function addCity($city, $pdo) {

        $stmt = $pdo->prepare("INSERT INTO cities (city) VALUES (:city)");
        
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        
        $stmt->execute();
        
        if($stmt->errorCode() === "00000") {
            header('location: index.php?msg=success');
        } else {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>Something went wrong...</p>");
        }
        
    }


    function readCities($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM cities");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function getCityById($id, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM cities WHERE id = :id");
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!count($data)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");

        }

        return $data;
    }

    function updateCity($id, $city, $pdo) {
        $stmt2 = $pdo->prepare("SELECT * FROM cities WHERE id = :id");
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();

        $exists = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if(!count($exists)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");

        }


        $stmt = $pdo->prepare("UPDATE cities SET city = :city WHERE id = :id");
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        if($stmt->errorCode() === "00000") {
            header('location: index.php?msg=success');
        } else {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>Something went wrong...</p>");
        }
    }


    function deleteCity($id, $pdo) {
        $stmt2 = $pdo->prepare("SELECT * FROM cities WHERE id = :id");
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();

        $exists = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if(!count($exists)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");
        }


        try {

            $stmt = $pdo->prepare("DELETE FROM cities WHERE id = :id");
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

?>