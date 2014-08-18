<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\DependencyInjection\Compiler;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler\DocumentManagerPass;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\BaseTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class DocumentManagerPassTest extends BaseTestCase
{


    public function testProcessMethod()
    {
        $compilerPass = new DocumentManagerPass();
        $container = new ContainerBuilder();

        // unknown parameter
        $this->assertException(
            function() use ($container, $compilerPass) {
                $compilerPass->process($container);
            },
            'Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException',
            null,
            'You have requested a non-existent parameter "o_auth2_server_mongo_db.document_manager".'
        );

        $container->setParameter('o_auth2_server_mongo_db.document_manager', 'test_manager');

        // unknown service definition
        $this->assertException(
            function() use ($container, $compilerPass) {
                $compilerPass->process($container);
            },
            'Symfony\Component\DependencyInjection\Exception\InvalidArgumentException',
            null,
            'The service definition "test_manager" does not exist.'
        );

        // invalid service definition class
        $this->assertException(
            function() use ($container, $compilerPass) {
                $container->setDefinition('test_manager', new Definition('stdClass'));
                $compilerPass->process($container);
            },
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            null,
            'The service test_manager is not instance of Doctrine\ODM\MongoDB\DocumentManager.'
        );

        // valid
        $container->setDefinition('test_manager', new Definition('Doctrine\ODM\MongoDB\DocumentManager'));
        $compilerPass->process($container);
    }

}
 