<?php

declare(strict_types=1);

use Entity\Exception\ParameterException;
use Entity\Tvshow;
use Html\Form\TvshowForm;
use Html\WebPage;

$pageweb = new WebPage("Formulaire");

if (!isset($_GET["tvShowId"])) {


    /*
     * Définition du titre de la page
     */
    $pageweb->setTitle("Formulaire de création ou d'édition d'une série");

    $pageweb->appendCssUrl("../css/styles.css");

    /*
     * FORMULAIRE VIDE CAR PAS SET
     */

    $form = new TvshowForm(null);
    $pageweb->appendContent($form->getHtmlForm("tvshow-form.php", true));

    echo $pageweb->toHTML();
} else {

    if (ctype_digit($_GET["tvShowId"]) == false) {
        throw new ParameterException("No data found");
    } else {
        $tvShowId = (int)$_GET["tvShowId"];
    }

    /*
     * Définition du titre de la page
     */
    $pageweb->setTitle("Formulaire de création ou d'édition d'une série");

    $pageweb->appendCssUrl("../css/styles.css");



    $tvshow = Tvshow::findById(($tvShowId));

    $form = new TvshowForm($tvshow);
    $pageweb->appendContent($form->getHtmlForm("tvshow-form.php?tvShowId={$tvShowId}", false));

    echo $pageweb->toHTML();
}
