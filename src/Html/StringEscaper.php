<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    public static function escapeString(?string $string): string
    {
        if ($string == null) {
            $res = "";
        } else {
            $res = htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
        }
        return $res;
    }

    public function stripTagsAndTrim(): string
    {
        $nom = $_POST["name"];
        if (isset($nom)) {
            $res = strip_tags($nom);
            $res = trim($nom);
        } else {
            $res = "";
        }
        return $res;
    }
}
