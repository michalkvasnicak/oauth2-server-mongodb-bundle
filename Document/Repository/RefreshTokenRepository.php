<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\RefreshToken;
use OAuth2\Storage\IRefreshToken;
use OAuth2\Storage\IRefreshTokenStorage;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class RefreshTokenRepository extends ATokenRepository implements IRefreshTokenStorage
{

    /**
     * Gets refresh token by its identifier
     *
     * @param string $id
     *
     * @return IRefreshToken|RefreshToken|null
     */
    public function get($id)
    {
        return $this->find($id);
    }
}
 