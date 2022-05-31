<?php

namespace Entity\Collection;


use Database\MyPdo;
use Entity\Tvshow;
use PDO;

class TvshowCollection
{
    /**
     * @return Tvshow[]
     */
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
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Tvshow::class);

        return $stmt->fetchAll();
    }

    public static function test(): string
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT name
            FROM tvshow
            WHERE id = 2
            ORDER BY name
        SQL
        );

        $stmt->execute();

        return $stmt->fetchAll()[0];

    }
}
