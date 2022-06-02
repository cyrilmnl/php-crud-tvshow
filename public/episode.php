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

    $saison = Season::findById($saisonId);
    $serie = Tvshow::findById($saison->getTvShowId());

    $serieName = WebPage::escapeString($serie->getName());
    $saisonName = WebPage::escapeString($saison->getName());

    /*
     * Initialisation de WebPage
     */
    $pageweb = new WebPage("Série - {$serieName}");

    /*
     * Ajout de la feuille de style
     */
    $pageweb->appendCssUrl("css/styles.css");


    $pageweb->appendContent(
        <<<HTML
<!-- OPEN HEADER -->
            <header>

HTML
    );

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

            <!-- CLOSE HEADER -->
            </header>
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

            <!-- CLOSE MAIN -->
            </main>
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

    $pageweb->appendContent(WebPage::getLastModification());

    /*
     * CLOSE FOOTER
     */
    $pageweb->appendContent(
        <<<HTML

            <!-- CLOSE FOOTER -->
            </footer>
HTML
    );

    echo $pageweb->toHtml();
} catch (EntityNotFoundException) {
    http_response_code(404);
}
