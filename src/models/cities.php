<?php

    $pdo->query("CREATE TABLE IF NOT EXISTS `cities` (
        `id` int(11) NOT NULL auto_increment,
        `city` varchar(255) NOT NULL,
         PRIMARY KEY  (`id`)
    )");


    // It generates Montenegro cities if table is empty
    $stmt = $pdo->prepare("SELECT * FROM cities");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!count($data)) {
        $montenegro_cities = array('Andrijevica','Bar','Berane','Bijelo Polje','Budva', 'Cetinje','Danilovgrad','Herceg Novi','Kolasin','Kotor','Mojkoviac','Niksic','Plav','Pljevlja','Pluzine','Podgorica','Rozaje','Savnik','Tivat','Ulcinj','Zabljak');

        foreach($montenegro_cities as $city) {
            $stmt4 = $pdo->prepare("INSERT INTO cities (city) VALUES (:city)");
            $stmt4->bindParam(':city', $city);
            $stmt4->execute();
        }
    }
?>