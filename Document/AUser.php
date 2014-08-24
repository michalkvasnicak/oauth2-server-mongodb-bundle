<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\Storage\AClient as BaseClient;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\Storage\AScope as BaseScope;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\Storage\AUser as BaseUser;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
abstract class AUser extends BaseUser
{

    public function __construct()
    {
        parent::__construct();
        $this->roles = new ArrayCollection();
        $this->clients = new ArrayCollection();
    }

    /**
     * Adds scope to user (what user can and can not do)
     *
     * @param BaseScope $scope
     */
    public function addRole(BaseScope $scope)
    {
        $this->getRoles()->add($scope);
    }

    /**
     * Adds client to user clients collection
     *
     * @param BaseClient $client
     */
    public function addClient(BaseClient $client)
    {
        $this->getClients()->add($client);
    }
}
 