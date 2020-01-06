<?php

namespace Damonto\ResponseCaster;

trait ResponseCaster
{
    /**
     * Response
     *
     * @return  \App\Packages\ResponseCaster\Caster
     */
    public function response()
    {
        return app(Caster::class);
    }
}
