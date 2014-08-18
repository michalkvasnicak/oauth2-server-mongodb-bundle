<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\Document\Repository;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\ATokenRepository;
use Mockery as m;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class ATokenRepositoryTest extends \PHPUnit_Framework_TestCase 
{


    /**
     * @var m\MockInterface|ATokenRepository
     */
    private $repository;


    public function testRepositoryObject()
    {
        $this->assertInstanceOf('OAuth2\Storage\ITokenGenerator', $this->repository);
        $this->assertInstanceOf('OAuth2\Storage\ITemporaryGenerator', $this->repository);
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
        $this->repository->shouldReceive('getDocumentName')->once()->withNoArgs()->andReturn(
            'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AccessToken'
        );

        // first call will return true and second null
        $this->repository->shouldReceive('find')->twice()->with(m::type('string'))->andReturn(true, null);

        $this->repository->shouldReceive('getDocumentManager')->andReturn(
            $documentManagerMock = m::mock('Doctrine\ODM\MongoDB\DocumentManager')
        );

        $documentManagerMock
            ->shouldReceive('persist')
            ->once()
            ->with(
                m::type('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AccessToken')
            )->andReturnNull();

        $documentManagerMock
            ->shouldReceive('flush')
            ->once()
            ->with(
                m::type('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AccessToken')
            )->andReturnNull();

        $this->assertInstanceOf(
            'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AccessToken',
            $this->repository->generate(
                m::mock('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\User'),
                m::mock('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Client'),
                [
                    m::mock('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Scope')
                ]
            )
        );
    }


    protected function setUp()
    {
        // make partial
        $this->repository = m::mock(
            'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\ATokenRepository'
        )->makePartial();
    }


    protected function tearDown()
    {
        m::close();
    }
}
 