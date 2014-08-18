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
class RepositoryClassesPass implements CompilerPassInterface
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
        // validate repository classes
        $classes = $container->getParameter('o_auth2_server_mongo_db.repository_classes');

        foreach ($classes as $repository => $repositoryClass) {
            if (!class_exists($repositoryClass)) {
                throw new InvalidConfigurationException(
                    "Class $repositoryClass does not exist."
                );
            }

            if (!is_subclass_of($repositoryClass, 'Doctrine\ODM\MongoDB\DocumentRepository')) {
                throw new InvalidConfigurationException(
                    "Class $repositoryClass is not subclass of Doctrine\\ODM\\MongoDB\\DocumentRepository."
                );
            }
        }
    }
}
 