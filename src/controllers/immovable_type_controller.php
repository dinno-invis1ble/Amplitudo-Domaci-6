<?php

    function addImmovableType($type, $pdo) {
        $stmt = $pdo->prepare("INSERT INTO immovable_types (type) VALUES (:type)");
        
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        
        $stmt->execute();
        
        if($stmt->errorCode() === "00000") {
            header('location: index.php?msg=success');
        } else {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>Something went wrong...</p>");
        }
    }


    function deleteImmovableType($id, $pdo) {
        $stmt2 = $pdo->prepare("SELECT * FROM immovable_types WHERE id = :id");
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();

        $exists = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if(!count($exists)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");
        }


        try {
            $stmt = $pdo->prepare("DELETE FROM immovable_types WHERE id = :id");
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


    function readImmovableTypes($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM immovable_types");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    function getImmovableTypeById($id, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM immovable_types WHERE id = :id");
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!count($data)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");
        }

        return $data;
    }

    function updateImmovableType($id, $type, $pdo) {
        $stmt2 = $pdo->prepare("SELECT * FROM immovable_types WHERE id = :id");
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();

        $exists = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if(!count($exists)) {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>You need to provide valid id</p>");
        }


        $stmt = $pdo->prepare("UPDATE immovable_types SET type = :type WHERE id = :id");
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        if($stmt->errorCode() === "00000") {
            header('location: index.php?msg=success');
        } else {
            exit("<p style='margin: 40px 0; text-align: center; width: 100%;'>Something went wrong...</p>");
        }
    }

?>