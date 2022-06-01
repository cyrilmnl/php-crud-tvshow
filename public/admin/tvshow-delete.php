<?php

declare(strict_types=1);

use Entity\Exception\ParameterException;
use Entity\Tvshow;

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

    $tvshow = Tvshow::findById(($tvShowId));
    $tvshow->delete();
    header("Location: ../index.php");

} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
