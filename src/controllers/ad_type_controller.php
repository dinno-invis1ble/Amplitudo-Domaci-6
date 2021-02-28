<?php

    function readAdTypes($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM ad_types");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

?>