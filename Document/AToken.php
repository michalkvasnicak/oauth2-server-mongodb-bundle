<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use OAuth2\Storage\IClient;
use OAuth2\Storage\IScope;
use OAuth2\Storage\IToken;
use OAuth2\Storage\IUser;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class AToken implements IToken
{

    /**
     * @var string
     */
    protected $id;


    /**
     * @var \DateTime
     */
    protected $createdAt;


    /**
     * @var int
     */
    protected $expiresAt;


    /**
     * @var IUser
     */
    protected $user;


    /**
     * @var IClient
     */
    protected $client;


    /**
     * @var IScope
     */
    protected $scopes;


    public function __construct($id)
    {
        $this->id = (string) $id;
        $this->createdAt = new \DateTime();
        $this->scopes = new ArrayCollection();
    }


    /**
     * Gets token identifier
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets token creation date
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Gets user associated with this access token
     *
     * @return IUser
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Sets user asocciated with this access token
     *
     * User was using client to obtain this access token
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }


    /**
     * Gets client associated with this access token
     *
     * @return IClient
     */
    public function getClient()
    {
        return $this->client;
    }


    /**
     * Sets client associated with this access token
     *
     * Client was used to obtain this access token
     *
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }


    /**
     * Gets associated scopes
     *
     * @return ArrayCollection|Scope[]|IScope[]
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Adds scopes to token
     *
     * @param Scope $scope
     */
    public function addScope(Scope $scope)
    {
        $this->getScopes()->add($scope);
    }

    /**
     * Has access token associated scope?
     *
     * @param mixed $scope
     *
     * @return bool
     */
    public function hasScope($scope)
    {
        if ($scope instanceof Scope) {
            return $this->getScopes()->contains($scope);
        } else {
            return $this->getScopes()->exists(
                function(Scope $s) use ($scope) {
                    return $s->getId() === $scope;
                }
            );
        }
    }

    /**
     * Gets expiration time (timestamp)
     *
     * @return int
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }


    /**
     * Sets expiration time
     *
     * @param int $time
     */
    public function setExpiresAt($time)
    {
        $this->expiresAt = (int) $time;
    }
}
 