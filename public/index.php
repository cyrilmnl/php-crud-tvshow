<?php

declare(strict_types=1);


use Entity\Collection\TvshowCollection;
use Html\WebPage;

require_once '../src/Html/WebPage.php';

$pageweb = new WebPage();

/*
 * Définition du titre de la page
 */
$pageweb->setTitle("Liste des show TV");

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
                <h1>Séries TV</h1>
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

$cpt = 0;

foreach (TvshowCollection::findAll() as $tv) {

    $cote = "";

    if ($cpt == 0) {
        $cpt = 1;
        $cote = "left";
    } else {
        $cpt = 0;
        $cote = "right";
    }

    $name = WebPage::escapeString($tv->getName());
    $desc = WebPage::escapeString($tv->getOverview());

    $html = <<<HTML
                <div class="serie__item" id="{$tv->getId()}">
                    <a href="saison.php?serieId={$tv->getId()}" class="{$cote}">
                        <div class="serie__img">
HTML;

    if ($tv->getPosterId() == null) {

        $html .= <<<HTML
                            <img src="img/defaultimg.png" alt="poster de la série">
HTML;

    } else {

        $html .= <<<HTML
                            <img src="poster.php?id={$tv->getPosterId()}" alt="poster de la série">
HTML;


    }

    $html .= <<<HTML
                        </div>
                        <div class="serie__content">
                            <h2>{$name}</h2>
                            <h3>{$desc}</h3>
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
