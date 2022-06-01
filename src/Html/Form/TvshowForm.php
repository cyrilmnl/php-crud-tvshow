<?php

namespace Html\Form;

use Entity\Tvshow;

class TvshowForm
{
    private ?Tvshow $tvshow;

    /** Constructeur de la classe TvshowForm
     *
     * @param Tvshow|null $tvshow
     */
    public function __construct(?Tvshow $tvshow)
    {
        $this->tvshow = $tvshow;
    }

    
}