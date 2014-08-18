<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use OAuth2\GrantType\IGrantType;
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
class Client implements IClient
{

    /**
     * @var \MongoId
     */
    protected $id;


    /**
     * @var \DateTime
     */
    protected $createdAt;


    /**
     * @var string
     */
    protected $name;


    /**
     * If is set, client is confidential
     *
     * @var string|null
     */
    protected $secret;

    /**
     * @var string
     */
    protected $redirectUri;


    /**
     * Class names of allowed grant types
     *
     * @var array
     */
    protected $grantTypes = [];

    /**
     * @var IUser|User|null
     */
    protected $owner;


    /**
     * @var ArrayCollection|Scope[]|IScope[]
     */
    protected $scopes;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->scopes = new ArrayCollection();
    }


    /**
     * Gets client identifier
     *
     * @return \MongoId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets creation date of client
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Gets client name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets client name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Gets client secret key (if is confidential)
     *
     * @return string|null
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Sets user secret
     *
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = (string) $secret;
    }

    /**
     * Gets scopes associated with client (which is allowed to access)
     *
     * @return ArrayCollection|Scope[]|IScope[]
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Adds scope client scopes
     *
     * @param Scope $scope
     */
    public function addScope(Scope $scope)
    {
        $this->getScopes()->add($scope);
    }

    /**
     * Gets client owner (creator) if exists
     *
     * @return User|IUser|null
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Sets client owner
     *
     * @param User $user
     */
    public function setOwner(User $user)
    {
        $this->owner = $user;
    }

    /**
     * Gets client redirect uri
     *
     * @return string|null
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Sets user redirect uri
     *
     * @param string $uri
     */
    public function setRedirectUri($uri)
    {
        $this->redirectUri = (string) $uri;
    }

    /**
     * Is client allowed to use grant type?
     *
     * @param IGrantType $grantType
     *
     * @return bool
     */
    public function isAllowedToUse(IGrantType $grantType)
    {
        $class = get_class($grantType);

        return in_array($class, $this->grantTypes);
    }


    /**
     * Allow grant type
     *
     * @param string|IGrantType $grantType
     */
    public function allowGrantType($grantType)
    {
        if ($grantType instanceof IGrantType) {
            $this->grantTypes[] = get_class($grantType);
        } else if (is_string($grantType) && class_exists($grantType)) {
            $this->grantTypes[] = $grantType;
        } else {
            throw new \InvalidArgumentException(
                "Grant type has to be fully qualified class name or instance of OAuth2\\GrantType\\IGrantType."
            );
        }
    }
}
 