<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\Functional;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class OAuth2ServerMongoDBBundleTest extends \PHPUnit_Framework_TestCase 
{

    public function testSomething()
    {

    }



    private function createKernel()
    {
        $kernel = new TestKernel('test', true);
        $kernel->boot();
    }

}
 