<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AAccessToken;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AClient;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\ARefreshToken;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AScope;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AUser;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Client;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Scope;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\User;
use OAuth2\Storage\IAccessToken;
use OAuth2\Storage\IClient;
use OAuth2\Storage\IRefreshToken;
use OAuth2\Storage\IScope;
use OAuth2\Storage\ITokenGenerator;
use OAuth2\Storage\IUser;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class ATokenRepository extends DocumentRepository implements ITokenGenerator
{

    /**
     * @var int
     */
    protected $lifetime;

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
     * Gets lifetime of a token
     *
     * @return int|null
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * Generates refresh token for given user, client, scopes and lifetime
     *
     * @param IUser|User|AUser|null $user user associated with token
     * @param IClient|AClient|Client $client
     * @param array|Scope|AScope[]|IScope[] $scopes
     *
     * @return IRefreshToken|IAccessToken
     */
    public function generate(IUser $user = null, IClient $client, array $scopes = [])
    {
        $tokenClass = $this->getDocumentName();

        do {
            $id = uniqid();

            if ($this->find($id)) continue;

            /** @var AAccessToken|ARefreshToken $token */
            $token = new $tokenClass(
                $id
            );

            $token->setUser($user);
            $token->setClient($client);
            $token->setExpiresAt($this->lifetime + time());

            foreach ($scopes as $scope) {
                $token->addScope($scope);
            }

            $this->getDocumentManager()->persist($token);
            $this->getDocumentManager()->flush($token);

            break; // token is generated, break cycle
        } while (true);

        return $token;
    }
}
 