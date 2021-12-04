<?php

namespace App\Http\Controllers\Api\V1\Auth\Session;

use App\Extensions\Services\Auth\TokenService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SessionController extends Controller
{
    public function __construct(protected Request $request, protected Response $response)
    {
        //
    }

    public function verify()
    {
        return UserResource::make($this->request->user());
    }

    public function destroy()
    {
        $this

            ->request
            ->user()
            ->currentAccessToken()
            ->delete();

        return $this

            ->response
            ->setStatusCode(202);
    }
}
