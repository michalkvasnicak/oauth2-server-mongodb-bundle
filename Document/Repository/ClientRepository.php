<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use OAuth2\Storage\IClient;
use OAuth2\Storage\IClientStorage;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class ClientRepository extends DocumentRepository implements IClientStorage
{

    /**
     * Gets client by id
     *
     * @param string $id
     *
     * @return IClient|null
     */
    public function get($id)
    {
        return $this->find($id);
    }
}
 