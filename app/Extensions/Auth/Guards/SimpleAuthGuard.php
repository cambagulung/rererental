<?php

namespace App\Extensions\Auth\Guards;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SimpleAuthGuard implements Guard
{
    use GuardHelpers;

    public function __construct(UserProvider $provider, protected Request $request, protected string $inputKey = 'authorization')
    {
        $this->setProvider($provider);
    }

    public function user(): ?Authenticatable
    {
        if (!is_null($this->user)) return $this->user;

        Log::debug(base64_decode($this->getTokenForRequest()));

        if (!empty($token = $this->getTokenForRequest()) && $credentials = json_decode(base64_decode($token), true))
        {
            if ($this->validate($credentials))
            {
                return $this->user = $this->provider->retrieveByCredentials($credentials);
            }
        }

        return null;
    }

    public function getTokenForRequest()
    {
        $token = $this->request->query($this->inputKey);

        if (empty($token))
        {
            $token = $this->request->input($this->inputKey);
        }

        if (empty($token))
        {
            $token = $this->request->bearerToken();
        }

        if (empty($token))
        {
            $token = $this->request->getPassword();
        }

        return $token;
    }

    public function validate(array $credentials = [])
    {
        if ($user = $this->provider->retrieveByCredentials($credentials))
        {
            return password_verify(@$credentials['password'], $user->getAuthPassword());
        }

        return false;
    }
}
