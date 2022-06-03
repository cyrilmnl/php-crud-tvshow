<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Tvshow_genre
{
    protected int $genreId;
    protected int $tvShowId;
    private int $id;

    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT t.id, t.name, t.originalName, t.homepage, t.overview, t.posterId
            FROM (tvshow t INNER JOIN tvshow_genre tg ON (t.id = tg.tvShowId))
                INNER JOIN genre g ON (tg.genreId = g.id)
            WHERE g.id = :genreId
        SQL
        );

        $stmt->execute([":genreId" => $genreId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Tvshow::class);
        return $stmt->fetchAll();
    }

    /** Assesseur de l'id de la classe Tvshow_genre
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Assesseur du genreId de la classe Tvshow_genre
     *
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

    /** Assesseur du tvShowId de la classe Tvshow_genre
     *
     * @return int
     */
    public function getTvShowId(): int
    {
        return $this->tvShowId;
    }
}
