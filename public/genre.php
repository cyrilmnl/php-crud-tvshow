<?php

declare(strict_types=1);

use Entity\Genre;
use Entity\Tvshow_genre;
use Html\WebPage;

require_once '../src/Html/WebPage.php';

if (isset($_GET["value"]) && ctype_digit($_GET["value"])) {
    $genreId = (int)$_GET["value"];
} else {
    header("Location: /index.php");
    exit();
}

$pageweb = new WebPage();

$genre = Genre::getGenreById($genreId);

/*
 * Définition du titre de la page
 */
$pageweb->setTitle("Série - {$genre->getName()}");

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
                <h2 class="filtrage__genre__title">Genre: {$genre->getName()}</h2>  

                <form action="index.php">
                    <button class="button" type="submit">
                        Enlever le filtrage
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
                    <button class="button" type="submit">
                        Ajouter une série
                    </button>
                </form>
            </div>
            
            <main>
HTML
);

$cpt = 0;

foreach (Tvshow_genre::findByGenreId($genreId) as $tv) {
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
