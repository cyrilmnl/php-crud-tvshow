<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Episode;
use PDO;

class EpisodeCollection
{
    /** Méthode permettant de retourner un tableau contenant toutes les saisons d'un tvShow
     *
     * @param int $seasonId
     * @return array
     */
    public static function findBySeasonId(int $seasonId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM episode
            WHERE seasonId = :season
            ORDER BY name
        SQL
        );

        $stmt->execute([":season" => $seasonId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Episode::class);
        return $stmt->fetchAll();
    }
}
