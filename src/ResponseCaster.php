<?php

namespace Damonto\ResponseCaster;

trait ResponseCaster
{
    /**
     * Response
     *
     * @return  \Damonto\ResponseCaster\Caster
     */
    public function response()
    {
        return app(Caster::class);
    }
}
