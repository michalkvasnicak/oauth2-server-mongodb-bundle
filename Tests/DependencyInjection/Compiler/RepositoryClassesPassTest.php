<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\DependencyInjection\Compiler;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler\RepositoryClassesPass;
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
class RepositoryClassesPassTest extends BaseTestCase
{

    public function testProcessMethod()
    {
        $compilerPass = new RepositoryClassesPass();
        $container = new ContainerBuilder();

        // valid
        $container->setParameter(
            'o_auth2_server_mongo_db.repository_classes',
            [
                'access_token' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AccessTokenRepository',
                'authorization_code' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AuthorizationCodeRepository',
                'client' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\ClientRepository',
                'refresh_token' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\RefreshTokenRepository',
                'user' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\UserRepository'
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
            'You have requested a non-existent parameter "o_auth2_server_mongo_db.repository_classes".'
        );

        // not existing class
        $this->assertException(
            function() use ($compilerPass, $container) {
                $container->setParameter(
                    'o_auth2_server_mongo_db.repository_classes',
                    [
                        'access_token' => 'not_existing',
                        'authorization_code' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AuthorizationCodeRepository',
                        'client' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\ClientRepository',
                        'refresh_token' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\RefreshTokenRepository',
                        'user' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\UserRepository'
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
                    'o_auth2_server_mongo_db.repository_classes',
                    [
                        'access_token' => 'stdClass',
                        'authorization_code' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AuthorizationCodeRepository',
                        'client' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\ClientRepository',
                        'refresh_token' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\RefreshTokenRepository',
                        'user' => 'MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\UserRepository'
                    ]
                );

                $compilerPass->process($container);
            },
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            null,
            'Class stdClass is not subclass of Doctrine\ODM\MongoDB\DocumentRepository.'
        );
    }

}
 