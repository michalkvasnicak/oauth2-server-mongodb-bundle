<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\Document;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Client;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{


    public function testObject()
    {
        $this->assertInstanceOf(
            'OAuth2\Storage\IClient', new Client()
        );
    }

}
 