<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AccessToken;
use OAuth2\Storage\IAccessToken;
use OAuth2\Storage\IAccessTokenStorage;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class AccessTokenRepository extends ATokenRepository implements IAccessTokenStorage
{

    /**
     * Gets access token by id
     *
     * @param string $id
     *
     * @return IAccessToken|AccessToken|null
     */
    public function get($id)
    {
        return $this->find($id);
    }
}
 