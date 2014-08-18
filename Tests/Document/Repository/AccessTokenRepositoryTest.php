<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\Document\Repository;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AccessTokenRepository;
use Mockery as m;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class AccessTokenRepositoryTest extends \PHPUnit_Framework_TestCase 
{

    /**
     * @var m\MockInterface|AccessTokenRepository
     */
    private $repository;


    public function testRepositoryObject()
    {
        $this->assertInstanceOf('OAuth2\Storage\IAccessTokenStorage', $this->repository);
    }


    public function testGetMethod()
    {
        $this->repository->shouldReceive('find')->once()->with(1)->andReturnNull();

        $this->assertNull($this->repository->get(1));
    }


    protected function setUp()
    {
        // partial mock
        $this->repository = m::mock(
            'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AccessTokenRepository'
        )->makePartial();
    }

    protected function tearDown()
    {
        m::close();
    }
}
 