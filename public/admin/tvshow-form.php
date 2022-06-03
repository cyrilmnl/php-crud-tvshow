<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Tvshow;

try {
    if (isset($_GET["tvShowId"])) {
        if (ctype_digit($_GET["tvShowId"]) == false) {
            throw new ParameterException("No data found");
        } else {
            $tvShow = Tvshow::findById((int)$_GET["tvShowId"]);
            $name = $_POST["name"];
            $nameoriginal = $_POST["nomoriginal"];
            $homepage = $_POST["homepage"];
            $overview = $_POST["overview"];

            /*
             * Création de l'objet Tvshow (id de la série existant)
             */
            $newTv = Tvshow::create($tvShow->getId(), $name, $nameoriginal, $homepage, $overview, null);

            /*
             * Mise à jour dans la base de données
             */
            $newTv->update();
        }
    } else {
        $tvShow = null;
        $name = $_POST["name"];
        $nameoriginal = $_POST["nomoriginal"];
        $homepage = $_POST["homepage"];
        $overview = $_POST["overview"];

        /*
         * Création de l'objet Tvshow (id de la série null)
         */
        $newTv = Tvshow::create(null, $name, $nameoriginal, $homepage, $overview, null);

        /*
         * Insertion de la nouvelle série dans la base de données
         */
        $newTv->insert($newTv->getName(), $newTv->getOriginalName(), $newTv->getHomepage(), $newTv->getOverview(), null);
    }

    header("Location: ../index.php");

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
