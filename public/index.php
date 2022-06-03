<?php

declare(strict_types=1);


use Entity\Collection\GenreCollection;
use Entity\Collection\TvshowCollection;
use Html\WebPage;

require_once '../src/Html/WebPage.php';

/*
 * Initialisation de la classe WebPage
 */
$pageweb = new WebPage();

/*
 * Définition du titre de la page
 */
$pageweb->setTitle("Liste des show TV");

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
                <h1>Séries TV</h1>   
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

$pageweb->appendContent(
    <<<HTML

                <div class="menu">
                    <form action="admin/tvshow-save.php">
                        <button class="button" type="submit">
                            Ajouter une série
                        </button>
                    </form>
                    <!-- FILTRAGE -->
                    <form class="liste__der" action="genre.php" method="get">
                        <select class="liste" name="value">

HTML
);

foreach (GenreCollection::findAll() as $genre) {
    $pageweb->appendContent(<<<HTML
                            <option value='{$genre->getId()}'>{$genre->getName()}</option>

HTML
    );
}

$pageweb->appendContent(
    <<<HTML
                        </select>
                        <button class="button" type="submit">
                            Filtrer
                        </button>
                    </form>
                <!-- CLOSE FLITRAGE -->
                </div>
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

$pageweb->appendContent(<<<HTML
                {$lastModif}
HTML
);

/*
 * CLOSE FOOTER
 */
$pageweb->appendContent(
    <<<HTML

            <!-- CLOSE FOOTER -->
            </footer>
HTML
);

/*
 * Génération du contenu de la page
 */
echo $pageweb->toHTML();
