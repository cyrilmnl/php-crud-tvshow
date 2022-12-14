<?php

namespace Entity;

class Episode
{
    protected int $seasonId;
    protected int $episodeNumber;
    private int $id;
    private string $name;
    private string $overview;

    /** Assesseur de l'id de la classe Episode
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Assesseur de l'id de la saison dans la classe Episode
     *
     * @return int
     */
    public function getSeasonId(): int
    {
        return $this->seasonId;
    }

    /** Assesseur du nom de la classe Episode
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Assesseur de l'aperçu de la classe Episode
     *
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /** Assesseur du numéro de l'épisode de la classe Episode
     *
     * @return int
     */
    public function getEpisodeNumber(): int
    {
        return $this->episodeNumber;
    }
}
