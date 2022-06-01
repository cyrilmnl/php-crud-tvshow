<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Tvshow;
use Html\WebPage;

try {
    if (isset($_GET["tvShowId"])) {
        if (ctype_digit($_GET["tvShowId"]) == false) {
            throw new ParameterException("No data found");
        } else {
            $tvShowId = Tvshow::findById((int)$_GET["tvShowId"]);
        }
    } else {
        $tvShowId = null;
    }
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}

$pageweb = new WebPage();

/*
 * Définition du titre de la page
 */
$pageweb->setTitle("Liste des show TV");

$pageweb->appendCssUrl("../css/styles.css");

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
                <h1>Formulaire</h1>
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

$pageweb->appendContent(TvshowForm::getHtmlForm());

echo $pageweb->toHTML();
