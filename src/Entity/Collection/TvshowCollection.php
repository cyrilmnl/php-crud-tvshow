<?php

namespace Entity\Collection;

use Database\MyPdo;
use PDO;

class TvshowCollection
{
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM tvshow
            ORDER BY name
        SQL
        );

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Artist::class);
        return $stmt->fetchAll();
    }
}