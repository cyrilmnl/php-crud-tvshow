<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Tvshow
{
    protected ?int $posterId;
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
     * @return int|null
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /** Mutateur du posterId de la classe Tvshow
     *
     * @param int|null $posterId
     * @return Tvshow
     */
    public function setPosterId(?int $posterId): Tvshow
    {
        $this->posterId = $posterId;
        return $this;
    }

    /** Mutateur du nom original de la classe Tvshow
     *
     * @param string $originalName
     * @return Tvshow
     */
    public function setOriginalName(string $originalName): Tvshow
    {
        $this->originalName = $originalName;
        return $this;
    }

    /** Mutateur de la page d'accueil de la classe Tvshow
     *
     * @param string $homepage
     * @return Tvshow
     */
    public function setHomepage(string $homepage): Tvshow
    {
        $this->homepage = $homepage;
        return $this;
    }

    /** Mutateur de l'aperçu de la classe Tvshow
     *
     * @param string $overview
     * @return Tvshow
     */
    public function setOverview(string $overview): Tvshow
    {
        $this->overview = $overview;
        return $this;
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

    /** Méthode qui met à jour une série
     *
     * @return $this
     */
    public function update(): Tvshow
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            UPDATE tvshow
            SET name = :nom, originalName = :orinom, homepage = :hpage, overview = :ov
            WHERE id = :id
        SQL
        );

        $stmt->execute([":id" => $this->id, ":nom" => $this->name, ":orinom" => $this->originalName, ":hpage" => $this->homepage, ":ov" => $this->overview]);
        return $this;
    }

    /** Méthode qui créé une série dans la base de données
     *
     * @param int|null $posterId
     * @param string $name
     * @param int|null $id
     * @param string $originalName
     * @param string $homepage
     * @param string $overview
     * @return Tvshow
     */
    public static function create(?int $id=null, string $name, string $originalName, string $homepage, string $overview, ?int $posterId=null): Tvshow
    {
        $serie = new Tvshow();
        $serie->setId($id);
        $serie->setName($name);
        $serie->setOriginalName($originalName);
        $serie->setHomepage($homepage);
        $serie->setOverview($overview);
        $serie->setPosterId($posterId);
        return $serie;
    }

    /** Méthode qui créé une série dans la base de données à partir de données entrées manuellement
     *
     * @param string $name
     * @param string $originalName
     * @param string $homepage
     * @param string $overview
     * @param int|null $posterId
     * @return $this
     */
    public function insert(string $name, string $originalName, string $homepage, string $overview, ?int $posterId=null): Tvshow
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            INSERT INTO tvshow (name, originalName, homepage, overview, posterId)
            VALUES(:nom, :orinom, :hpage, :ov, :pi)
        SQL
        );

        $stmt->execute([":nom" => $name, ":orinom" => $originalName, ":hpage" => $homepage, ":ov" => $overview, ":pi" => $posterId]);
        $this->setId((int)MYPDO::getInstance()->lastInsertId());
        return $this;
    }

    /** Méthode qui déclenche insert() ou update() selon que "id" est null ou non
     *
     * @return $this
     */
    public function save(): Tvshow
    {
        if ($this->getId() == null) {
            $this->insert($this->name, $this->originalName, $this->homepage, $this->overview, $this->posterId);
        } else {
            $this->update();
        }
        return $this;
    }

    /** Constructeur de la classe Tvshow
     *
     */
    private function __construct()
    {

    }
}
