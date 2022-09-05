<?php

declare(strict_types=1);

namespace CORS\Bundle\FriendlyCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class CORSFriendlyCaptchaExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configs = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if ($configs['use_eu_endpoints']) {
            $puzzleEndpoint = $configs['puzzle']['eu_endpoint'];
            $verificationEndpoint = $configs['validation']['eu_endpoint'];
        }
        else {
            $puzzleEndpoint = $configs['puzzle']['endpoint'];
            $verificationEndpoint = $configs['validation']['endpoint'];
        }

        $container->setParameter('cors.friendly_captcha.secret', $configs['secret']);
        $container->setParameter('cors.friendly_captcha.sitekey', $configs['sitekey']);
        $container->setParameter('cors.friendly_captcha.endpoint.puzzle', $puzzleEndpoint);
        $container->setParameter('cors.friendly_captcha.endpoint.validation', $verificationEndpoint);

        $loader->load('services.yaml');
    }
}
