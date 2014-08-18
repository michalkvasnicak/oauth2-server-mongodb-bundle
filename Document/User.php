<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use OAuth2\Storage\IClient;
use OAuth2\Storage\IScope;
use OAuth2\Storage\IUser;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class User implements IUser, UserInterface
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
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var ArrayCollection|Scope[]|IScope[]|RoleInterface[]
     */
    protected $roles;

    /**
     * @var ArrayCollection|Client[]|IClient[]
     */
    protected $clients;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->roles = new ArrayCollection();
        $this->clients = new ArrayCollection();

        // generates salt
        $this->setSalt(
            hash('sha256', uniqid('2', true) . uniqid('2', true) . uniqid('3', true))
        );
    }

    /**
     * Gets id
     *
     * @return \MongoId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return ArrayCollection|Scope[]|IScope[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Adds scope to user (what user can and can not do)
     *
     * @param Scope $scope
     */
    public function addRole(Scope $scope)
    {
        $this->getRoles()->add($scope);
    }

    /**
     * Gets user clients (his registered applications)
     *
     * @return ArrayCollection|Client[]|\OAuth2\Storage\IClient[]
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Adds client to user clients collection
     *
     * @param Client $client
     */
    public function addClient(Client $client)
    {
        $this->getClients()->add($client);
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets salt
     *
     * @param $salt
     */
    public function setSalt($salt)
    {
        $this->salt = (string) $salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->setUsername(null);
        $this->setPassword(null);
    }

    /**
     * Updates update time on document
     */
    public function _update()
    {
        $this->updatedAt = new \DateTime();
    }
}
 