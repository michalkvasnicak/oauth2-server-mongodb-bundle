<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use OAuth2\Storage\IAuthorizationCode;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\Storage\AScope;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\Storage\AAuthorizationCode as BaseAuthorizationCode;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
abstract class AAuthorizationCode extends BaseAuthorizationCode implements IAuthorizationCode
{

    public function __construct($id)
    {
        parent::__construct($id);
        $this->scopes = new ArrayCollection();
    }


    /**
     * Adds scope to code
     *
     * @param AScope $scope
     */
    public function addScope(AScope $scope)
    {
        $this->getScopes()->add($scope);
    }
}
 