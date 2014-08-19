<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\Document;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Scope;


/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class ScopeTest extends \PHPUnit_Framework_TestCase
{


    public function testObject()
    {
        $scope = new Scope('test');

        $this->assertInstanceOf('OAuth2\Storage\IScope', $scope);

        $this->assertInstanceOf('Symfony\Component\Security\Core\Role\RoleInterface', $scope);
    }

}
 