<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class UserProviderPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $userProviderServiceAlias = 'o_auth2_server_mongo_db.services.user_provider';
        $service = $container->getAlias($userProviderServiceAlias);
        $service = $container->getDefinition((string) $service);

        if (!is_subclass_of($service->getClass(), 'Symfony\Component\Security\Core\User\UserProviderInterface')) {
            throw new InvalidConfigurationException(
                "The service $userProviderServiceAlias is not instance of Symfony\\Component\\Security\\Core\\User\\UserProviderInterface."
            );
        }
    }
}
 