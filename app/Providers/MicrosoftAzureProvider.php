<?php

namespace App\Providers;

use Laravel\Socialite\Two\AbstractProvider;
use GuzzleHttp\RequestOptions;

class MicrosoftAzureProvider extends AbstractProvider
{
    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = [
        'openid',
        'profile',
        'email',
        'User.Read',
    ];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://login.microsoftonline.com/' . $this->getTenant() . '/oauth2/v2.0/authorize',
            $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://login.microsoftonline.com/' . $this->getTenant() . '/oauth2/v2.0/token';
    }

    /**
     * Get tenant ID from config.
     */
    protected function getTenant()
    {
        return $this->config['tenant'] ?? 'common';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://graph.microsoft.com/v1.0/me', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return $this->userInstance([
            'id' => $user['id'] ?? null,
            'nickname' => null,
            'name' => $user['displayName'] ?? null,
            'email' => $user['userPrincipalName'] ?? $user['mail'] ?? null,
            'avatar' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getCodeFields($state = null)
    {
        return array_merge(parent::getCodeFields($state), [
            'scope' => $this->formatScopes($this->getScopes(), ' '),
        ]);
    }
}
