<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\Storage\AToken as BaseToken;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\Storage\AScope as BaseScope;
use OAuth2\Storage\IScope;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
abstract class AToken extends BaseToken
{

    public function __construct($id)
    {
        parent::__construct($id);

        $this->scopes = new ArrayCollection();
    }

    /**
     * Adds scopes to token
     *
     * @param BaseScope $scope
     */
    public function addScope(BaseScope $scope)
    {
        $this->getScopes()->add($scope);
    }

    /**
     * Has access token associated scope?
     *
     * @param mixed|AScope|IScope $scope
     *
     * @return bool
     */
    public function hasScope($scope)
    {
        if ($scope instanceof AScope) {
            return $this->getScopes()->contains($scope);
        } else {
            return $this->getScopes()->exists(
                function(AScope $s) use ($scope) {
                    return $s->getId() === $scope;
                }
            );
        }
    }
}
 