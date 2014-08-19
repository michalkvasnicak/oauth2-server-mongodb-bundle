<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\User;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AUser;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class UserRepository extends DocumentRepository implements UserProviderInterface
{

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface|User|AUser
     *
     * @see UsernameNotFoundException
     *
     * @throws UsernameNotFoundException if the user is not found
     *
     */
    public function loadUserByUsername($username)
    {
        $user = $this->findOneBy(['username' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException();
        }

        return $user;
    }


    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface|AUser|User $user
     *
     * @return UserInterface|AUser
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        if (!($user instanceof AUser)) {
            $class = get_class($user);

            throw new UnsupportedUserException(
                "Instances of $class are not supported."
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class instanceof AUser;
    }
}
 