<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AuthorizationCode;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Client;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Scope;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\User;
use OAuth2\Storage\IAuthorizationCode;
use OAuth2\Storage\IAuthorizationCodeStorage;
use OAuth2\Storage\IClient;
use OAuth2\Storage\IScope;
use OAuth2\Storage\IUser;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class AuthorizationCodeRepository extends DocumentRepository implements IAuthorizationCodeStorage
{

    /**
     * @var int
     */
    protected $lifetime;

    /**
     * Gets authorization code
     *
     * @param string $code
     *
     * @return IAuthorizationCode|null
     */
    public function get($code)
    {
        return $this->find($code);
    }

    /**
     * Generates unique authorization code
     *
     * @param IUser|User $user
     * @param IClient|Client $client
     * @param array|IScope[]|Scope[] $scopes
     * @param string $redirectUri
     * @param string|null $state state provided to authorization
     *
     * @return IAuthorizationCode
     */
    public function generate(IUser $user, IClient $client, array $scopes = [], $redirectUri, $state = null)
    {
        do {
            $id = uniqid();

            if ($this->find($id)) continue;

            $code = new AuthorizationCode(
                $id
            );

            $code->setUser($user);
            $code->setClient($client);
            $code->setExpiresAt($this->lifetime + time());
            $code->setRedirectUri($redirectUri);
            $code->setState($state);

            foreach ($scopes as $scope) {
                $code->addScope($scope);
            }

            $this->getDocumentManager()->persist($code);
            $this->getDocumentManager()->flush($code);

            break; // code is generated, break cycle
        } while (true);

        return $code;
    }

    /**
     * Sets lifetime for generator
     *
     * @param int $lifetime
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = (int) $lifetime;
    }


    /**
     * Gets lifetime of an authorization code
     *
     * @return int|null
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }
}
 