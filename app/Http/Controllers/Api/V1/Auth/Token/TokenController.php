<?php

namespace App\Http\Controllers\Api\V1\Auth\Token;

use App\Extensions\Services\Auth\TokenService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\NewTokenResource;
use App\Http\Resources\Api\V1\TokenResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;

class TokenController extends Controller
{
    public function __construct(protected Request $request, protected Response $response, protected TokenService $tokenService)
    {
        //
    }

    public function store()
    {
        $newToken = $this

            ->tokenService
            ->create($this->request->user(), $this->request->userAgent());

        return NewTokenResource::make($newToken)

            ->response()
            ->setStatusCode(201);
    }

    public function index()
    {
        $tokensCollection = $this

            ->tokenService
            ->getManyByTokenablePaginated($this->request->user(), 24);

        return TokenResource::collection($tokensCollection);
    }

    public function destroy(PersonalAccessToken $accessToken = null)
    {
        $accessToken->delete();

        return $this

            ->response
            ->setStatusCode(202);
    }
}
