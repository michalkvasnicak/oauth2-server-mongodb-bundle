<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class DocumentManagerPass implements CompilerPassInterface
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
        $documentManagerServiceName = $container->getParameter('o_auth2_server_mongo_db.document_manager');

        $service = $container->getDefinition($documentManagerServiceName);
        $class = 'Doctrine\ODM\MongoDB\DocumentManager';
        $serviceClass = $service->getClass();

        if (!(strcmp($serviceClass, $class) == 0 || is_subclass_of($serviceClass, $class))) {
            throw new InvalidConfigurationException(
                "The service $documentManagerServiceName is not instance of Doctrine\\ODM\\MongoDB\\DocumentManager."
            );
        }
    }
}
 