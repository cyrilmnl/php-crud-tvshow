<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    private string $head = "";
    private string $title = "";
    private string $body = "";

    /**
     * Constructeur de la classe
     *
     * @param string $title
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /**
     * Permet de protéger une chaîne de caractère
     *
     * @param string $string
     * @return string
     */
    public static function escapeString(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * Permet d'ajouter du contenu dans à l'entête du site
     *
     * @param string $content
     */
    public function appendToHead(string $content): void
    {
        $this->head = $this->head . $content;
    }

    /**
     * Permet d'ajouter du css (code)
     *
     * @param string $css
     */
    public function appendCss(string $css): void
    {
        $this->head = $this->head . "<style>" . $css . "</style>";
    }

    /**
     * Permet d'ajouter du css (url)
     *
     * @param string $url
     */
    public function appendCssUrl(string $url): void
    {
        $this->head = $this->head . '<link href="' . $url . '" rel="stylesheet">';
    }

    /**
     * Permet d'ajouter du javascript (code)
     *
     * @param string $js
     */
    public function appendJs(string $js): void
    {
        $this->head = $this->head . "<script>" . $js . "</script>";
    }

    /**
     * Permet d'ajouter du javascript (url)
     *
     * @param string $url
     */
    public function appendJsUrl(string $url): void
    {
        $this->head = $this->head . '<script src="' . $url . '"></script>';
    }

    /**
     * Permet d'ajouter du content dans le corps du site (body)
     *
     * @param string $content
     */
    public function appendContent(string $content): void
    {
        $this->body = $this->body . $content;
    }

    /**
     * Permet de produire la page HTML
     * @param bool $modif
     * @return string
     */
    public function toHTML(bool $modif): string
    {
        $html = <<<HTML
<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>{$this->getTitle()}</title>
            {$this->getHead()}
        </head>
        <body>
            {$this->getBody()}
HTML;

        if ($modif) {
            $html .= <<<HTML
            <p style="text-align: right">Dernière modification <i>{$this->getLastModification()}</i></p>
HTML;
        }

        $html .= <<<HTML
        </body>
    </html>
HTML;

        return $html;
    }

    /**
     * Permet de récupérer le titre du site
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    // <p style="text-align: right">Dernière modification <i>{$this->getLastModification()}</i></p>

    /**
     * Permet de définir le titre du site
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Permet de récupérer l'entête du site
     *
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Permet de récupérer le corps du site
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Permet de récupérer la date de la dernière modification de la page
     *
     * @return string
     */
    public static function getLastModification(): string
    {
        return date("d F Y H:i:s.", getlastmod());
    }
}
