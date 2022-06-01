<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Season
{
    protected int $tvShowId;
    protected int $seasonNumber;
    protected ?int $posterId;
    private int $id;
    private string $name;

    /** Assesseur de l'id de la classe Season
     *
     * @return int
     */

    /** Méthode permettant d'accéder à une saison par son id
     *
     * @param int $id
     * @return Season
     */
    public static function findById(int $id): Season
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM season
            WHERE id = :id
        SQL
        );

        $stmt->execute([":id" => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Season::class);

        $fetch = $stmt->fetch();
        if ($fetch == false) {
            throw new EntityNotFoundException("No data found");
        }
        return $fetch;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Assesseur du Tvshow dans la classe Season
     *
     * @return int
     */
    public function getTvShowId(): int
    {
        return $this->tvShowId;
    }

    /** Assesseur du nom de la classe Season
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Assesseur de l'id du poster dans la classe Season
     *
     * @return int
     */

    /** Assesseur du numéro de saison de la classe Season
     *
     * @return int
     */
    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }

    /**
     * @return int|null
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }
}
