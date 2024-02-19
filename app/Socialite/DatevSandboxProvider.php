<?php

namespace App\Socialite;

use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;

class DatevSandboxProvider extends AbstractProvider implements Provider
{

    protected $usesPKCE = true;

    protected $scopes = ['openid', 'account_id', 'profile'];

    protected $scopeSeparator = " ";

    protected function getAuthUrl ($state)
    {
        return $this->buildAuthUrlFromBase(config('datev.oidc.sandbox.authorization_endpoint'), $state);
    }

    protected function getTokenUrl ()
    {
        return config('datev.oidc.sandbox.token_endpoint');
    }

    protected function getCodeFields ($state = null)
    {
        $params = parent::getCodeFields($state);
        $params['nonce'] = Str::uuid() . '.' . $state;

        return array_merge($params, $this->parameters);
    }

    protected function getUserByToken ($token)
    {
        $response = $this->getHttpClient()
            ->get(config('datev.oidc.sandbox.userinfo_endpoint'), [
                'headers' => [
                    'cache-control' => 'no-cache',
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function mapUserToObject (array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'nickname' => $user['username'],
            'name' => $user['name'],
            'avatar' => $user['profile_image_url'],
        ]);
    }


}
