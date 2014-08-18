<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\DependencyInjection\Compiler;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler\UserProviderPass;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\BaseTestCase;
use Symfony\Component\DependencyInjection\Alias;
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
class UserProviderPassTest extends BaseTestCase
{


    public function testProcessMethod()
    {
        $compilerPass = new UserProviderPass();
        $container = new ContainerBuilder();

        // unknown alias
        $this->assertException(
            function() use ($container, $compilerPass) {
                $compilerPass->process($container);
            },
            'Symfony\Component\DependencyInjection\Exception\InvalidArgumentException',
            null,
            'The service alias "o_auth2_server_mongo_db.services.user_provider" does not exist.'
        );

        $container->setAlias('o_auth2_server_mongo_db.services.user_provider', new Alias('user_provider'));

        // unknown service definition
        $this->assertException(
            function() use ($container, $compilerPass) {
                $compilerPass->process($container);
            },
            'Symfony\Component\DependencyInjection\Exception\InvalidArgumentException',
            null,
            'The service definition "user_provider" does not exist.'
        );

        // invalid service definition class
        $this->assertException(
            function() use ($container, $compilerPass) {
                $container->setDefinition('user_provider', new Definition('stdClass'));
                $compilerPass->process($container);
            },
            'Symfony\Component\Config\Definition\Exception\InvalidConfigurationException',
            null,
            'The service o_auth2_server_mongo_db.services.user_provider is not instance of Symfony\Component\Security\Core\User\UserProviderInterface.'
        );

        // valid
        $container->setDefinition(
            'user_provider',
            new Definition('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\UserRepository')
        );

        $compilerPass->process($container);
    }

}
 