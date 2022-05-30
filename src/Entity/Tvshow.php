<?php

namespace Entity;

class Tvshow
{
    private int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;
    protected int $posterId;

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

    /** Assesseur de l'id du poster de la classe Tvshow
     *
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }
}
