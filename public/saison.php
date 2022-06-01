<?php

declare(strict_types=1);

use Entity\Collection\SeasonCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Tvshow;
use Html\WebPage;

require_once '../src/Html/WebPage.php';

if (isset($_GET["serieId"]) && ctype_digit($_GET["serieId"])) {
    $serieId = $_GET["serieId"];
} else {
    header("Location: /index.php");
    exit();
}


try {
    $serieId = (int)$serieId;

    /*
     * Récupération du TvShow
     */
    $serie = Tvshow::findById($serieId);

    /*
     * Initialisation de WebPage
     */
    $pageweb = new WebPage("Série - {$serie->getName()}");

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

    $pageweb->appendContent(
        <<<HTML
                <h1>Séries TV : {$serie->getName()}</h1>
                <form action="index.php#{$serieId}">
                    <button class="button" type="submit">
                        Retour
                    </button>
                </form>    
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
                <div class="serie__header">
                    <div class="serie__header_poster">
                        <img src="poster.php?id={$serie->getPosterId()}">
                    </div>
                    <div class="serie__header_content">
                        <h2 class="serie__header__content__title">Nom: {$serie->getName()}</h2>
                        <h2 class="serie__header__content__originalname">Nom original: {$serie->getOriginalName()}</h2>
                        <h2>Description:</h2>
                        <h2 class="serie__header__content__description">{$serie->getOverview()}</h2>
                    </div>
                </div>
HTML;

    $pageweb->appendContent($html);


    foreach (SeasonCollection::findByTvShowId($serieId) as $saison) {
        $html = <<<HTML
                <div class="saison__item">
                    <a href="episode.php?saisonId={$saison->getId()}">
                        <div class="serie__img">
HTML;

        if ($saison->getPosterId() == null) {
            $html .= <<<HTML
                            <img src="img/defaultimg.png" alt="poster par défaut">
HTML;
        } else {
            $html .= <<<HTML
                            <img src="poster.php?id={$saison->getPosterId()}" alt="poster de la série">
HTML;
        }

        $html .= <<<HTML
                        </div>
                        <div class="serie__content">
                            <h2>{$saison->getName()}</h2>
                        </div>
                    </a>
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

    echo $pageweb->toHTML();

} catch (EntityNotFoundException) {
    http_response_code(404);
}
