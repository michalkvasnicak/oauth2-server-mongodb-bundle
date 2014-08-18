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
class DocumentClassesPass implements CompilerPassInterface
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
        // validate document classes
        $classes = $container->getParameter('o_auth2_server_mongo_db.document_classes');

        $interfaces = [
            'access_token' => 'OAuth2\Storage\IAccessToken',
            'authorization_code' => 'OAuth2\Storage\IAuthorizationCode',
            'client' => 'OAuth2\Storage\IClient',
            'refresh_token' => 'OAuth2\Storage\IRefreshToken',
            'user' => 'OAuth2\Storage\IUser'
        ];

        foreach ($classes as $document => $documentClass) {
            if (!class_exists($documentClass)) {
                throw new InvalidConfigurationException(
                    "Class $documentClass does not exist."
                );
            }

            if (!is_subclass_of($documentClass, $interfaces[$document])) {
                throw new InvalidConfigurationException(
                    "Class $documentClass does not implement {$interfaces[$document]}."
                );
            }
        }
    }
}
 