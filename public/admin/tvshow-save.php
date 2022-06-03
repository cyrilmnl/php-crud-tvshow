<?php

declare(strict_types=1);

use Entity\Exception\ParameterException;
use Entity\Tvshow;
use Html\Form\TvshowForm;
use Html\WebPage;

/*
 * Initialisation de l'objet WebPage et définition du titre de la page
 */
$pageweb = new WebPage();

/*
* Définition du titre de la page
*/
$pageweb->setTitle("Formulaire de création ou d'édition d'une série");

/*
 * Ajout de la feuille de style
 */
$pageweb->appendCssUrl("../css/styles.css");

if (!isset($_GET["tvShowId"])) {

    /*
     * Initilisation d'un formulaire avec tvshow null en
     * paramètre car tvShowId n'est pas défini
     */
    $form = new TvshowForm(null);

    /*
     * Ajout d'un formulaire vide dans le corps du Html
     */
    $pageweb->appendContent($form->getHtmlForm("tvshow-form.php", true));

    echo $pageweb->toHTML();
} else {
    if (ctype_digit($_GET["tvShowId"]) == false) {
        throw new ParameterException("No data found");
    } else {
        $tvShowId = (int)$_GET["tvShowId"];
    }

    /*
     * Initilisation d'un Tvshow grâce à l'ID récupéré
     * grâce à la méthode GET
     */
    $tvshow = Tvshow::findById(($tvShowId));

    /*
     * Initilisation d'un formulaire avec le Tvshow
     * précédemment initialisé
     */
    $form = new TvshowForm($tvshow);

    /*
     * Ajout d'un formulaire remplit avec les données
     * du Tvshow précédemment initialisé
     */
    $pageweb->appendContent($form->getHtmlForm("tvshow-form.php?tvShowId={$tvShowId}", false));

    echo $pageweb->toHTML();
}
