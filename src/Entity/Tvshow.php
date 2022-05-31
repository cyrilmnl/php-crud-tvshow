<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Tvshow
{
    protected int $posterId;
    private int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;

    /** Assesseur de l'id de la classe Tvshow
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Assesseur du nom de la classe Tvshow
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Assesseur du nom original de la classe Tvshow
     *
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /** Assesseur de la page d'acceuil de la classe Tvshow
     *
     * @return string
     */
    public function getHomepage(): string
    {
        return $this->homepage;
    }

    /** Assesseur de l'aperçu de la classe Tvshow
     *
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /** Assesseur de l'id du poster dans la classe Tvshow
     *
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /** Méthode permettant d'accéder à un tvshow par son id
     *
     * @param int $id
     * @return Tvshow
     */
    public static function findById(int $id): Tvshow
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM tvshow
            WHERE id = :id
        SQL
        );

        $stmt->execute([":id" => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Tvshow::class);

        $fetch = $stmt->fetch();
        if ($fetch == false) {
            throw new EntityNotFoundException("No data found");
        }
        return $fetch;
    }
}
