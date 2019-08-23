<?php

namespace Zakjakub\OswisCoreBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ZakjakubOswisCoreExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    final public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
        $configuration = $this->getConfiguration($configs, $container);
        if ($configuration) {
            $config = $this->processConfiguration($configuration, $configs);
            $this->oswisCoreSettingsProvider($container, $config);
        }
    }

    /**
     * @param ContainerBuilder $container
     *
     * @param array            $config
     *
     * @throws ServiceNotFoundException
     */
    private function oswisCoreSettingsProvider(ContainerBuilder $container, array $config): void
    {
        $definition = $container->getDefinition('zakjakub_oswis_core.oswis_core_settings_provider');
        $definition->setArgument(0, $config['app']);
        $definition->setArgument(1, $config['admin']);
        $definition->setArgument(2, $config['email']);
        $definition->setArgument(3, $config['web']);
    }

    /**
     * @param ContainerBuilder $container
     */
    final public function prepend(ContainerBuilder $container): void
    {
        $this->prependTwig($container);
    }

    private function prependTwig(ContainerBuilder $container): void
    {
        $twigGlobals = [
            'globals' => [
                'oswis_core_settings' => '@zakjakub_oswis_core.oswis_core_settings_provider',
            ],
        ];
        $container->prependExtensionConfig('twig', $twigGlobals);
    }
}
