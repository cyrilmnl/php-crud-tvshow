<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Poster
{
    private int $id;
    private string $jpeg;

    public static function findById(int $id): Poster
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM poster
            WHERE id = :id
        SQL
        );

        $stmt->execute([":id" => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Poster::class);

        $fetch = $stmt->fetch();
        if ($fetch == false) {
            throw new EntityNotFoundException("No data found");
        }
        return $fetch;
    }

    /** Assesseur de l'id de la classe Poster
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Assesseur du Jpeg de la classe Poster
     *
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }
}
