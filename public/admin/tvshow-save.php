<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Tvshow;
use Html\Form\TvshowForm;
use Html\WebPage;

try {
    if (isset($_GET["tvShowId"])) {
        if (ctype_digit($_GET["tvShowId"]) == false) {
            throw new ParameterException("No data found");
        } else {
            $tvShowId = (int)$_GET["tvShowId"];
        }
    } else {
        $tvShowId = null;
    }

    $pageweb = new WebPage();

    /*
     * Définition du titre de la page
     */
    $pageweb->setTitle("Formulaire de création ou d'édition d'une série");

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

    $tvshow = Tvshow::findById(($tvShowId));

    $form = new TvshowForm($tvshow);
    $pageweb->appendContent($form->getHtmlForm("tvshow-form.php?tvShowId={$tvShowId}"));

    echo $pageweb->toHTML();

} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
