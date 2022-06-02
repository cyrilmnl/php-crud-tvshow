<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Genre
{
    private int $id;
    private string $name;

    public static function getGenreById(int $id): Genre
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM genre
            WHERE id = :id
        SQL
        );

        $stmt->execute([":id" => $id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Genre::class);

        $fetch = $stmt->fetch();

        if ($fetch == false) {
            throw new EntityNotFoundException("No data found");
        }

        return $fetch;
    }

    /** Assesseur de l'id du genre
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Assesseur de du nom du genre
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
