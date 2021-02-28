<?php

    $pdo->query("CREATE TABLE IF NOT EXISTS `immovable_types` (
        `id` int(11) NOT NULL auto_increment,
        `type` varchar(255) NOT NULL,
         PRIMARY KEY  (`id`)
    )");


    // It generates inital types if table is empty
    $stmt = $pdo->prepare("SELECT * FROM immovable_types");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!count($data)) {
        $immovable_types2 = array('Apartment', 'House', 'Garage', 'Work Office');

        foreach($immovable_types2 as $type) {
            $stmt4 = $pdo->prepare("INSERT INTO immovable_types (type) VALUES (:type)");
            $stmt4->bindParam(':type', $type);
            $stmt4->execute();
        }
    }

?>