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

/*
 * CLOSE MAIN
 */
$pageweb->appendContent(
    <<<HTML

            <!-- CLOSE FOOTER -->
            </footer>
HTML
);


//foreach (TvshowCollection::findAll() as $tv) {
//    $name = WebPage::escapeString($tv->getName());
//    $desc = WebPage::escapeString($tv->getOverview());
//    $pageweb->appendContent($name);
//}

echo $pageweb->toHTML();
