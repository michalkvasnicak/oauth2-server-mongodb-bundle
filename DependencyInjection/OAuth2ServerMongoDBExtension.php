<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class OAuth2ServerMongoDBExtension extends Extension implements PrependExtensionInterface
{

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig(
            'o_auth2_server',
            [
                'user_provider' => 'o_auth2_server_mongo_db.services.user_provider',
                'storage' => [
                    'access_token' => 'o_auth2_server_mongo_db.storage.access_token',
                    'authorization_code' => 'o_auth2_server_mongo_db.storage.authorization_code',
                    'client' => 'o_auth2_server_mongo_db.storage.client',
                    'refresh_token' => 'o_auth2_server_mongo_db.storage.refresh_token'
                ]
            ]
        );
    }


    /**
     * Loads a specific configuration.
     *
     * @param array $config An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $container->setParameter(
            'o_auth2_server_mongo_db.document_manager', $config['document_manager']
        );

        $container->setParameter(
            'o_auth2_server_mongo_db.document_classes', $config['document_classes']
        );

        $container->setParameter(
            'o_auth2_server_mongo_db.repository_classes', $config['repository_classes']
        );

        foreach ($config['document_classes'] as $key => $class) {
            $container->setParameter("o_auth2_server_mongo_db.document_classes.$key", $class);
        }

        foreach ($config['repository_classes'] as $key => $class) {
            $container->setParameter("o_auth2_server_mongo_db.repository_classes.$key", $class);
        }
    }

    public function getAlias()
    {
        return 'o_auth2_server_mongo_db';
    }
}
 