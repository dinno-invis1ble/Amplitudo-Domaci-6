<?php

    $pdo->query("CREATE TABLE IF NOT EXISTS `immovables` (
        `id` int NOT NULL auto_increment,
        `price` float NOT NULL,
        `area` float NOT NULL,
        `description` varchar(255) NOT NULL,
        `construction_date` date NULL,
        `status` boolean default false,
        `sale_date` date NULL,
        `city_id` int NOT NULL,
        `ad_type_id` int NOT NULL,
        `immovable_type_id` int NOT NULL,
         PRIMARY KEY  (`id`),
         CONSTRAINT fk_immovables_cities FOREIGN KEY (city_id) REFERENCES cities(id),
         CONSTRAINT fk_immovables_ad_types FOREIGN KEY (ad_type_id) REFERENCES ad_types(id),
         CONSTRAINT fk_immovables_immovable_type FOREIGN KEY (immovable_type_id) REFERENCES immovable_types(id)
    )");

?>