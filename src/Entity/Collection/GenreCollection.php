<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use PDO;

class GenreCollection
{
    /** Méthode permettant de retourner un tableau contenant toutes les saisons d'un tvShow
     *
     * @return array
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM genre
            ORDER BY name
        SQL
        );

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Genre::class);
        return $stmt->fetchAll();
    }
}