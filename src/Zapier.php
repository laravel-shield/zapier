<?php

namespace Shield\Zapier;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Shield\Shield\Contracts\Service;
use Shield\Shield\Support\BasicAuth;

/**
 * Class Zapier
 *
 * @package \Shield\Zapier
 */
class Zapier implements Service
{
    use BasicAuth;

    public function verify(Request $request, Collection $config): bool
    {
        return $this->checkBasic($request, $config->get('username'), $config->get('password'));
    }

    public function headers(): array
    {
        return [];
    }
}
