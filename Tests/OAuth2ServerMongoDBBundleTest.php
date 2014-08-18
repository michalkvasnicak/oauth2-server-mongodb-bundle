<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests;

use Doctrine\Bundle\MongoDBBundle\DependencyInjection\DoctrineMongoDBExtension;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\DependencyInjection\OAuth2ServerExtension;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\OAuth2ServerMongoDBBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class OAuth2ServerMongoDBBundleTest extends BaseTestCase
{


    public function testBuildMethod()
    {
        $bundle = new OAuth2ServerMongoDBBundle();
        $container = new ContainerBuilder();

        // invalid build, there is not OAuth2ServerBundle
        $this->assertException(
            function() use ($bundle, $container) {
                $bundle->build($container);
            },
            'Symfony\Component\DependencyInjection\Exception\LogicException',
            null,
            'Container extension "o_auth2_server" is not registered'
        );

        // register OAuth2ServerBundle
        $container->registerExtension(new OAuth2ServerExtension());
        $container->registerExtension(new DoctrineMongoDBExtension());

        $bundle->build($container);
    }


}
 