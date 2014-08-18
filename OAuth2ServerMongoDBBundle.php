<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle;

use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler\DocumentClassesPass;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler\DocumentManagerPass;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler\RepositoryClassesPass;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\DependencyInjection\Compiler\UserProviderPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Michal Kvasničák, 2014
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class OAuth2ServerMongoDBBundle extends Bundle
{


    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // get extension (just to throw exception if there isn't)
        $container->getExtension('o_auth2_server');
        $container->getExtension('doctrine_mongodb');

        $container->addCompilerPass(new DocumentClassesPass());
        $container->addCompilerPass(new RepositoryClassesPass());
        $container->addCompilerPass(new DocumentManagerPass(), PassConfig::TYPE_BEFORE_REMOVING);
        $container->addCompilerPass(new UserProviderPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }

}
 