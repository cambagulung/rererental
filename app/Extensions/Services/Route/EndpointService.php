<?php namespace App\Extensions\Services\Route;

use App\Extensions\Repositories\EndpointRepository;
use Illuminate\Support\Str;

class EndpointService {
    public function __construct(protected EndpointRepository $endpointRepository)
    {
        //
    }

    public function parse(string $prefix = 'api')
    {
        return $this->endpointRepository->getManyByNamePrefix($prefix);
    }
}
