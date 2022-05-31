<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Season;
use PDO;

class SeasonCollection
{
    /** Méthode permettant de retourner un tableau contenant toutes les saisons d'un tvShow
     *
     * @param int $tvShowId
     * @return array
     */
    public static function findByTvShowId(int $tvShowId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM season
            WHERE tvShowId = :tvShow
            ORDER BY name
        SQL
        );

        $stmt->execute([":tvShow" => $tvShowId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Season::class);
        return $stmt->fetchAll();
    }
}
