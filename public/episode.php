<?php

declare(strict_types=1);

use Entity\Collection\EpisodeCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Season;
use Entity\Tvshow;
use Html\WebPage;

require_once '../src/Html/WebPage.php';

if (isset($_GET["saisonId"]) && ctype_digit($_GET["saisonId"])) {
    $saisonId = $_GET["saisonId"];
} else {
    header("Location: /index.php");
    exit();
}

try {
    $saisonId = (int)$saisonId;

    /*
     * Initialisation de l'objet saison grâce à
     * l'ID précédemment récupéré
     */
    $saison = Season::findById($saisonId);

    /*
     * Initialisation de l'objet Tvshow grâce à
     * la méthode permettant de récuper l'Id d'un
     * Tvshow depuis une saison
     */
    $serie = Tvshow::findById($saison->getTvShowId());

    /*
     * Protection des variables
     */
    $serieName = WebPage::escapeString($serie->getName());
    $saisonName = WebPage::escapeString($saison->getName());

    /*
     * Initialisation de WebPage avec en titre
     * le nom de la série
     */
    $pageweb = new WebPage("Série - {$serieName}");

    /*
     * Ajout de la feuille de style
     */
    $pageweb->appendCssUrl("css/styles.css");

    /*
     * OPEN HEADER
     */
    $pageweb->appendContent(
        <<<HTML
<!-- OPEN HEADER -->
            <header>

HTML
    );

    /*
     * CONTENU AFFICHE EN HAUT DE PAGE
     */
    $pageweb->appendContent(
        <<<HTML
                <h1>Séries TV : {$serieName}</h1>
                <h1>{$saisonName}</h1>
HTML
    );

    /*
     * CLOSE HEADER
     */
    $pageweb->appendContent(
        <<<HTML

            </header>
            <!-- CLOSE HEADER -->
HTML
    );

    /*
* OPEN MAIN
*/
    $pageweb->appendContent(
        <<<HTML

            <!-- OPEN MAIN -->
            <main>

HTML
    );

    $html = <<<HTML
                <div class="episode__header">
                    <div class="episode__header__img">

HTML;

    if ($saison->getPosterId() == null) {
        $html .= <<<HTML
                        <img src="img/defaultimg.png">
HTML;
    } else {
        $html .= <<<HTML
                        <img src="poster.php?id={$saison->getPosterId()}">
HTML;
    }

    $html .= <<<HTML

                    </div>
                    <div class="episode__header__content">
                        <a href="saison.php?serieId={$serie->getId()}">
                            <h2 class="episode__header__content__serie">Série: {$serieName}</h2>
                        </a>
                        <h2 class="episode__header__content__saison">Saison: {$saisonName}</h2>
                    </div>
                </div>
HTML;

    $pageweb->appendContent($html);


    foreach (EpisodeCollection::findBySeasonId($saisonId) as $episode) {
        $episodeName = WebPage::escapeString($episode->getName());
        $episodeDesc = WebPage::escapeString($episode->getOverview());
        $html = <<<HTML

                <div class="episode__item">
                    <div class="episode__content">
                        <h2>{$episode->getEpisodeNumber()} - {$episodeName}</h2>

HTML;

        if ($episode->getOverview() == null) {
            $html .= <<<HTML
                        <h3>Aucune description...</h3>
HTML;
        } else {
            $html .= <<<HTML
                        <h3>{$episodeDesc}</h3>
HTML;
        }

        $html .= <<<HTML

                    </div>
                </div>
HTML;

        $pageweb->appendContent($html);
    }


    /*
     * CLOSE MAIN
     */
    $pageweb->appendContent(
        <<<HTML

            </main>
            <!-- CLOSE MAIN -->
HTML
    );

    /*
 * OPEN FOOTER
 */
    $pageweb->appendContent(
        <<<HTML

            <!-- OPEN FOOTER -->
            <footer>

HTML
    );

    $lastModif = WebPage::getLastModification();

    $pageweb->appendContent(
        <<<HTML
                {$lastModif}
HTML
    );

    /*
     * CLOSE FOOTER
     */
    $pageweb->appendContent(
        <<<HTML

            </footer>
            <!-- CLOSE FOOTER -->
HTML
    );

    /*
     * Génération du contenu de la page
     */
    echo $pageweb->toHtml();
} catch (EntityNotFoundException) {
    http_response_code(404);
}
