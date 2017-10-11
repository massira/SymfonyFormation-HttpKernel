<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
    /**
     * @inheritdoc
     */
    public function registerBundles()
    {
        return [];
    }

    /** @inheritdoc */
    public function build(ContainerBuilder $container)
    {
        $container->autowire('HttpKernel\Formation\Service\Factory\HttpKernelFactory');

        $container->register('http_kernel', 'Symfony\Component\HttpKernel\HttpKernel')
            ->setFactory([new Reference('HttpKernel\Formation\Service\Factory\HttpKernelFactory'), 'getHttpKernel']);
    }

    /**
     * @inheritdoc
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/../Config/parameters.yml');
    }
}