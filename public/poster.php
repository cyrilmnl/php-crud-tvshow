<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Poster;

try {
    if (isset($_GET["id"]) && ctype_digit($_GET["id"]) == false) {
        throw new ParameterException("No data found");
    }
    $posterId = Poster::findById((int)$_GET["id"]);
    header("Content-type: image/jpeg");
    echo $posterId->getJpeg();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
