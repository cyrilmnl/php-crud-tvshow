<?php

declare(strict_types=1);

namespace Entity;

class Genre
{
    private int $id;
    private string $name;

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
