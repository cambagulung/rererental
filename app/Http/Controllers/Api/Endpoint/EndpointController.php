<?php

namespace App\Http\Controllers\Api\Endpoint;

use App\Extensions\Helpers\Route\Endpoint;
use App\Extensions\Services\Route\EndpointService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Endpoint\EndpointResource;
use Illuminate\Support\Str;

class EndpointController extends Controller
{
    public function __construct(protected EndpointService $endpointService)
    {
        //
    }
    public function index(string $prefix)
    {
        return EndpointResource::collection($this->endpointService->parse($prefix));
    }
}
