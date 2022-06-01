<?php

namespace Html\Form;

use Entity\Tvshow;
use Html\StringEscaper;

class TvshowForm
{
    use StringEscaper;
    private ?Tvshow $tvshow;

    /** Constructeur de la classe TvshowForm
     *
     * @param Tvshow|null $tvshow
     */
    public function __construct(?Tvshow $tvshow)
    {
        $this->tvshow = $tvshow;
    }

    /** Assesseur d'une série dans la classe TvshowForm
     *
     * @return Tvshow|null
     */
    public function getTvshow(): ?Tvshow
    {
        return $this->tvshow;
    }

    /** Méthode produisant le code HTML du formulaire
     *
     * @param string $action
     * @return string
     */
    public function getHtmlForm(string $action): string
    {
        $action = self::escapeString($action);
        $nom = self::escapeString($this->getTvshow()?->getName());
        $content = <<<HTML
                    <form method="post" action="{$action}">
                        <label>
                            Nom
                            <input type="text" name="name" value="{$nom}" required>
                        </label>
                        
                        <input type="hidden" name="id" value="{$this->getArtist()?->getId()}">
                        
                        <button type="submit">Enregistrer</button>
                    </form>
        HTML;

        return $content;
    }
}
