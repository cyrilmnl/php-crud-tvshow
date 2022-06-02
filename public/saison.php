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
    $serieName = WebPage::escapeString($serie->getName());

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

    $pageweb->appendContent(
        <<<HTML
                <h1>Séries TV : {$serieName}</h1>
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

    $pageweb->appendContent(
        <<<HTML
            <div class="menu">
                <form action="admin/tvshow-save.php">
                    <button class="button" type="submit" name="tvShowId" value="{$serieId}">
                        Modifier la série
                    </button>
                </form>

                <form action="admin/tvshow-delete.php">
                    <button class="button" type="submit" name="tvShowId" value="{$serieId}">
                        Supprimer la série
                    </button>
                </form>
            </div>
            
            <main>
HTML
    );

    $serieOriginalName = WebPage::escapeString($serie->getOriginalName());
    $serieDesc = WebPage::escapeString($serie->getOverview());

    $html = <<<HTML
                <div class="serie__header">
                    <div class="serie__header_poster">
HTML;

    if ($serie->getPosterId() == null) {
        $html .= <<<HTML
                        <img src="img/defaultimg.png">
HTML;
    } else {
        $html .= <<<HTML
                        <img src="poster.php?id={$serie->getPosterId()}">
HTML;
    }

    $html .= <<<HTML
                    </div>
                    <div class="serie__header_content">
                        <h2 class="serie__header__content__title">Nom: {$serieName}</h2>
                        <h2 class="serie__header__content__originalname">Nom original: {$serieOriginalName}</h2>
                        <h2>Description:</h2>
                        <h2 class="serie__header__content__description">{$serieDesc}</h2>
                    </div>
                </div>
HTML;

    $pageweb->appendContent($html);


    foreach (SeasonCollection::findByTvShowId($serieId) as $saison) {
        $saisonName = WebPage::escapeString($saison->getName());

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
                            <h2>{$saisonName}</h2>
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
