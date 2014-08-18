<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('o_auth2_server_mongo_db');
        $nodes = $rootNode->children();

        $documentManagerNode = $nodes->scalarNode('document_manager');
        $documentClassesNode = $nodes->arrayNode('document_classes');
        $documentRepositoriesNode = $nodes->arrayNode('repository_classes');

        // validation
        $documentManagerNode
            ->cannotBeEmpty()
            ->defaultValue('doctrine_mongodb.odm.default_document_manager')
            ->validate()
                ->always(
                    function($value) {
                        if (!is_string($value)) {
                            $type = gettype($value);

                            throw new InvalidConfigurationException(
                                "Parameter o_auth2_server_mongo_db.document_manager has to be string, $type given."
                            );
                        }
                    }
                );

        // document classes
        $documentClassesNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('access_token')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AccessToken')
                ->end()
                ->scalarNode('authorization_code')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\AuthorizationCode')
                ->end()
                ->scalarNode('client')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Client')
                ->end()
                ->scalarNode('refresh_token')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\RefreshToken')
                ->end()
                ->scalarNode('user')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\User')
                ->end();

        $documentRepositoriesNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('access_token')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AccessTokenRepository')
                ->end()
                ->scalarNode('authorization_code')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\AuthorizationCodeRepository')
                ->end()
                ->scalarNode('client')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\ClientRepository')
                ->end()
                ->scalarNode('refresh_token')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\RefreshTokenRepository')
                ->end()
                ->scalarNode('user')
                    ->cannotBeEmpty()
                    ->defaultValue('MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Document\Repository\UserRepository')
                ->end();

        return $treeBuilder;
    }
}
 