<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\DependencyInjection\Compiler;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler\DocumentClassesPass;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\BaseTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class DocumentClassesPassTest extends BaseTestCase
{

    public function testProcessMethod()
    {
        $compilerPass = new DocumentClassesPass();
        $container = new ContainerBuilder();

        // valid
        $container->setParameter(
            'o_auth2_server_mongo_db.document_classes',
            [
                'access_token' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AccessToken',
                'authorization_code' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AuthorizationCode',
                'client' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Client',
                'refresh_token' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\RefreshToken'
            ]
        );

        $compilerPass->process($container);

        // unknown parameter
        $this->assertException(
            function() use ($compilerPass, $container) {
                $container->getParameterBag()->clear();
                $compilerPass->process($container);
            },
            'Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException',
            null,
            'You have requested a non-existent parameter "o_auth2_server_mongo_db.document_classes".'
        );

        // not existing class
        $this->assertException(
            function() use ($compilerPass, $container) {
                $container->setParameter(
                    'o_auth2_server_mongo_db.document_classes',
                    [
                        'access_token' => 'not_existing',
                        'authorization_code' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AuthorizationCode',
                        'client' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Client',
                        'refresh_token' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\RefreshToken'
                    ]
                );

                $compilerPass->process($container);
            },
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            null,
            'Class not_existing does not exist.'
        );

        // invalid class
        $this->assertException(
            function() use ($compilerPass, $container) {
                $container->setParameter(
                    'o_auth2_server_mongo_db.document_classes',
                    [
                        'access_token' => 'stdClass',
                        'authorization_code' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AuthorizationCode',
                        'client' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Client',
                        'refresh_token' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\RefreshToken'
                    ]
                );

                $compilerPass->process($container);
            },
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            null,
            'Class stdClass does not implement OAuth2\Storage\IAccessToken'
        );
    }

}
 