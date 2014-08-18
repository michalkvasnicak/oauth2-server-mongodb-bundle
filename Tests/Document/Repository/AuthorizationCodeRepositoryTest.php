<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\Document\Repository;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AuthorizationCodeRepository;
use Mockery\MockInterface;
use Mockery as m;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class AuthorizationCodeRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var MockInterface|AuthorizationCodeRepository
     */
    private $repository;


    public function testRepositoryObject()
    {
        $this->assertInstanceOf('OAuth2\Storage\IAuthorizationCodeStorage', $this->repository);
    }


    public function testGetMethod()
    {
        $this->repository->shouldReceive('find')->once()->with(1)->andReturnNull();

        $this->assertNull($this->repository->get(1));
    }


    public function testGetLifetimeMethod()
    {
        $this->assertNull($this->repository->getLifetime());
    }


    public function testSetLifetimeMethod()
    {
        $this->repository->setLifetime(1000);

        $this->assertEquals(1000, $this->repository->getLifetime());
    }


    public function testGenerateMethod()
    {
        // first call will return true, second null
        $this->repository->shouldReceive('find')->twice()->with(m::type('string'))->andReturn(true, null);

        $this->repository->shouldReceive('getDocumentManager')->andReturn(
            $documentManagerMock = m::mock('Doctrine\ODM\MongoDB\DocumentManager')
        );

        $documentManagerMock
            ->shouldReceive('persist')
            ->once()
            ->with(
                m::type('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AuthorizationCode')
            )->andReturnNull();

        $documentManagerMock
            ->shouldReceive('flush')
            ->once()
            ->with(
                m::type('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AuthorizationCode')
            )->andReturnNull();

        $this->assertInstanceOf(
            'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AuthorizationCode',
            $this->repository->generate(
                m::mock('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\User'),
                m::mock('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Client'),
                [
                    m::mock('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Scope')
                ],
                'http://google.com'
            )
        );
    }


    protected function setUp()
    {
        // make partial
        $this->repository = m::mock(
            'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AuthorizationCodeRepository'
        )->makePartial();
    }


    protected function tearDown()
    {
        m::close();
    }

}
 