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
            $tvShowId = Tvshow::findById((int)$_GET["tvShowId"]);
        }
    } else {
        $tvShowId = null;
    }
    header("Location: ../index.php");
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
