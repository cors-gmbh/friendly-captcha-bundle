<?php

namespace CORS\Tests\Bundle\FriendlyCaptchaBundle\DependencyInjection;

use CORS\Bundle\FriendlyCaptchaBundle\DependencyInjection\CORSFriendlyCaptchaExtension;
use CORS\Bundle\FriendlyCaptchaBundle\Form\Type\FriendlyCaptchaType;
use CORS\Bundle\FriendlyCaptchaBundle\Validator\FriendlyCaptchaValidValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class CORSFriendlyCaptchaExtensionTest extends TestCase
{
    /** @var ContainerBuilder */
    private $configuration;

    protected function tearDown(): void
    {
        $this->configuration = null;
    }

    public function testServicesRegistered(): void
    {
        $this->configuration = new ContainerBuilder();
        $loader = new CORSFriendlyCaptchaExtension();
        $config = $this->getSimpleEuConfig();
        $loader->load([$config], $this->configuration);

        $this->assertHasDefinition(FriendlyCaptchaValidValidator::class);
        $this->assertHasDefinition(FriendlyCaptchaType::class);
    }

    public function testSimpleEuConfiguration(): void
    {
        $this->configuration = new ContainerBuilder();
        $loader = new CORSFriendlyCaptchaExtension();
        $config = $this->getSimpleEuConfig();
        $loader->load([$config], $this->configuration);

        $this->assertParameter('secret', 'cors.friendly_captcha.secret');
        $this->assertParameter('sitekey', 'cors.friendly_captcha.sitekey');
        $this->assertParameter('https://eu-api.friendlycaptcha.eu/api/v1/puzzle', 'cors.friendly_captcha.endpoint.puzzle');
        $this->assertParameter('https://eu-api.friendlycaptcha.eu/api/v1/siteverify', 'cors.friendly_captcha.endpoint.validation');
    }

    public function testSimpleComConfiguration(): void
    {
        $this->configuration = new ContainerBuilder();
        $loader = new CORSFriendlyCaptchaExtension();
        $config = $this->getSimpleComConfig();
        $loader->load([$config], $this->configuration);

        $this->assertParameter('secret', 'cors.friendly_captcha.secret');
        $this->assertParameter('sitekey', 'cors.friendly_captcha.sitekey');
        $this->assertParameter('https://api.friendlycaptcha.com/api/v1/puzzle', 'cors.friendly_captcha.endpoint.puzzle');
        $this->assertParameter('https://api.friendlycaptcha.com/api/v1/siteverify', 'cors.friendly_captcha.endpoint.validation');
    }
    public function testCustomEndpointConfiguration(): void
    {
        $this->configuration = new ContainerBuilder();
        $loader = new CORSFriendlyCaptchaExtension();
        $config = $this->getCustomEndpoints();
        $loader->load([$config], $this->configuration);

        $this->assertParameter('secret', 'cors.friendly_captcha.secret');
        $this->assertParameter('sitekey', 'cors.friendly_captcha.sitekey');
        $this->assertParameter('http://custom', 'cors.friendly_captcha.endpoint.puzzle');
        $this->assertParameter('http://custom', 'cors.friendly_captcha.endpoint.validation');
    }

    private function getSimpleEuConfig()
    {
        $yaml = <<<EOF
sitekey: 'sitekey'
secret: 'secret'
use_eu_endpoints: true
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    private function getSimpleComConfig()
    {
        $yaml = <<<EOF
sitekey: 'sitekey'
secret: 'secret'
use_eu_endpoints: false
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    private function getCustomEndpoints()
    {
        $yaml = <<<EOF
sitekey: 'sitekey'
secret: 'secret'
use_eu_endpoints: false
puzzle:
    endpoint: http://custom
validation:
    endpoint: http://custom
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    private function assertParameter($value, $key): void
    {
        $this->assertSame($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }

    private function assertHasDefinition($id): void
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) || $this->configuration->hasAlias($id)));
    }
}
