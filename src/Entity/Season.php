<?php
declare(strict_types=1);

namespace Entity;

class Season
{
    private int $id;
    protected int $tvshow;
    private string $name;
    protected int $seasonNumber;
    protected int $posterId;

    /** Assesseur de l'id de la classe Season
     *
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
    public function getTvshow(): int
    {
        return $this->tvshow;
    }

    /** Assesseur du nom de la classe Season
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Assesseur du numéro de saison de la classe Season
     *
     * @return int
     */
    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }

    /** Assesseur de l'id du poster dans la classe Season
     *
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }
}