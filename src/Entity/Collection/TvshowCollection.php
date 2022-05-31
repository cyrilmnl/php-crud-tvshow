<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Tvshow;
use PDO;

class TvshowCollection
{
    /** Méthode permettant de retourner un tableau contenant tous les tvShow
     *
     * @return array
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
}
