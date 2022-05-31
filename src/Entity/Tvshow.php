<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Tvshow
{
    protected int $posterId;
    private ?int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;

    /** Assesseur de l'id de la classe Tvshow
     *
     * @return ?int
     */
    public function getId(): ?int
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

    /** Mutateur de l'id de la classe Tvshow
     *
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): Tvshow
    {
        $this->id = $id;
        return $this;
    }

    /** Mutateur du nom de la classe Tvshow
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Tvshow
    {
        $this->name = $name;
        return $this;
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

    /** Méthode qui supprime une série de la base de données
     *
     * @return $this
     */
    public function delete(): Tvshow
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            DELETE FROM tvshow
            WHERE id = :id
        SQL
        );

        $stmt->execute([":id" => $this->id]);
        $this->id = null;
        return $this;
    }

    /** Méthode qui met à jour le nom d'une série
     *
     * @return $this
     */
    public function update(): Tvshow
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            UPDATE tvshow
            SET name = :nom
            WHERE id = :id
        SQL
        );

        $stmt->execute([":id" => $this->id, ":nom" => $this->name]);
        return $this;
    }

    /** Méthode qui créé une série dans la base de données
     *
     * @param string $name
     * @param int|null $id
     * @return Tvshow
     */
    public static function create(string $name, ?int $id=null): Tvshow
    {
        $serie = new Tvshow();
        $serie->setName($name);
        $serie->setId($id);
        return $serie;
    }
}
