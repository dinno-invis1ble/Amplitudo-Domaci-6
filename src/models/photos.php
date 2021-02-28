<?php

    $pdo->query("CREATE TABLE IF NOT EXISTS `photos` (
        `id` int(11) NOT NULL auto_increment,
        `imageUrl` varchar(255) NOT NULL,
        `immovable_id` int NOT NULL,
         PRIMARY KEY  (`id`),
         CONSTRAINT fk_photos_immovables FOREIGN KEY (immovable_id) REFERENCES immovables(id) ON DELETE CASCADE
       ON UPDATE CASCADE
    )");

?>