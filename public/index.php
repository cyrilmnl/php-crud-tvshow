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


foreach (TvshowCollection::findAll() as $tv) {
    $name = WebPage::escapeString($tv->getName());
    $pageweb->appendContent($name);
}

echo $pageweb->toHTML(false);
