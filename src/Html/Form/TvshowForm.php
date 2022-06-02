<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Exception\ParameterException;
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

    /** Méthode produisant le code HTML du formulaire
     *
     * @param string $action
     * @return string
     */
    public function getHtmlForm(string $action, bool $empty): string
    {
        $action = self::escapeString($action);
        $nom = self::escapeString($this->getTvshow()?->getName());
        $nomOrig = self::escapeString($this->getTvshow()?->getOriginalName());
        $homepage = self::escapeString($this->getTvshow()?->getHomepage());
        $overview = self::escapeString($this->getTvshow()?->getOverview());

        if ($empty) {
            $content = <<<HTML
                    <form class="formulaire" method="post" action="{$action}">
                        <h1>Formulaire</h1>
                    
                        <label>
                            <p>Nom</p>
                            <input type="text" name="name" required>
                        </label>
                        
                        <label>
                            <p>Nom original</p>
                            <input type="text" name="nomoriginal" required>
                        </label>
                        
                        <label>
                            <p>Page d'accueil</p>
                            <input type="text" name="homepage"" required>
                        </label>
                        
                        <label>
                            <p>Aperçu</p>
                            <input type="text" name="overview"" required>
                        </label>
                        
                        <input type="hidden" name="id">
                        
                        <div class="buttons__form">
                            <button type="submit" class="button">Enregistrer</button>
                            <button type="reset" class="button">Effacer</button>
                        </div>
                    </form>
        HTML;
        } else {
            $content = <<<HTML
                    <form class="formulaire" method="post" action="{$action}">
                        <h1>Formulaire</h1>
                    
                        <label>
                            <p>Nom</p>
                            <input type="text" name="name" value="{$nom}" required>
                        </label>
                        
                        <label>
                            <p>Nom original</p>
                            <input type="text" name="nomoriginal" value="{$nomOrig}" required>
                        </label>
                        
                        <label>
                            <p>Page d'accueil</p>
                            <input type="text" name="homepage" value="{$homepage}" required>
                        </label>
                        
                        <label>
                            <p>Aperçu</p>
                            <input type="text" name="overview" value="{$overview}" required>
                        </label>
                        
                        <input type="hidden" name="id" value="{$this->getTvshow()?->getId()}">
                        
                        <div class="buttons__form">
                            <button type="submit" class="button">Enregistrer</button>
                        </div>
                    </form>
        HTML;
        }
        return $content;
    }

    /** Assesseur d'une série dans la classe TvshowForm
     *
     * @return Tvshow|null
     */
    public function getTvshow(): ?Tvshow
    {
        return $this->tvshow;
    }

    /** Méthode qui créé une série avec les données extraites et nettoyées
     *
     */
    public function setEntityFromQueryString(): void
    {
        if (isset($_POST["id"]) && ctype_digit($_POST["id"])) {
            $id = (int)$_POST["id"];
        } else {
            $id = null;
        }
        if (isset($_POST["posterId"]) && ctype_digit($_POST["posterId"])) {
            $posterId = (int)$_POST["posterId"];
        } else {
            $posterId = null;
        }
        if (isset($_POST["name"]) && isset($_POST["originalName"]) && isset($_POST["homepage"]) && isset($_POST["overview"])) {
            $name = $_POST["name"];
            $name = self::stripTagsAndTrim();
            $originalName = $_POST["originalName"];
            $originalName = self::stripTagsAndTrim();
            $homepage = $_POST["homepage"];
            $homepage = self::stripTagsAndTrim();
            $overview = $_POST["overview"];
            $overview = self::stripTagsAndTrim();
            if ($name == "" && $originalName == "" && $homepage == "" && $overview == "") {
                throw new ParameterException("Paramètre vide");
            }
        } else {
            throw new ParameterException("Artist name not found");
        }
        $tvs = Tvshow::create($id, $name, $originalName, $homepage, $overview, $posterId);
        $this->tvshow = $tvs;
    }
}
