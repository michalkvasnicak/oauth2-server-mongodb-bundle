<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\Storage\AScope as BaseScope;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\Storage\AClient as BaseClient;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
abstract class AClient extends BaseClient
{

    public function __construct()
    {
        parent::__construct();
        $this->scopes = new ArrayCollection();
    }

    /**
     * Adds scope client scopes
     *
     * @param BaseScope $scope
     */
    public function addScope(BaseScope $scope)
    {
        $this->getScopes()->add($scope);
    }
}
 