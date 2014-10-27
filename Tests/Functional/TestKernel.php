<?php

namespace MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\Tests\Functional;

use Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle;
use MichalKvasnicak\Bundle\OAuth2ServerBundle\OAuth2ServerBundle;
use MichalKvasnicak\Bundle\OAuth2ServerMongoDBBundle\OAuth2ServerMongoDBBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @author Michal Kvasničák <michal.kvasnicak@mink.sk>
 * @copyright Mink Ltd, 2014
 */
class TestKernel extends Kernel
{

    /**
     * Returns an array of bundles to register.
     *
     * @return BundleInterface[] An array of bundle instances.
     *
     * @api
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new SecurityBundle(),
            new DoctrineMongoDBBundle(),
            new OAuth2ServerBundle(),
            new OAuth2ServerMongoDBBundle()
        ];
    }

    /**
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     *
     * @api
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
    }
}
 