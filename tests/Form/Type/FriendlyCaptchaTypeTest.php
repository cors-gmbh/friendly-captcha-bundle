<?php

namespace CORS\Tests\Bundle\FriendlyCaptchaBundle\Form\Type;

use CORS\Bundle\FriendlyCaptchaBundle\Form\Type\FriendlyCaptchaType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class FriendlyCaptchaTypeTest extends TestCase
{
    /** @var FriendlyCaptchaType */
    protected $type;

    protected function setUp(): void
    {
        $this->type = new FriendlyCaptchaType('sitekey', '');
    }

    /**
     * @test
     */
    public function buildView(): void
    {
        $view = new FormView();

        /** @var FormInterface $form */
        $form = $this->createMock(FormInterface::class);

        $this->assertArrayNotHasKey('sitekey', $view->vars);

        $this->type->buildView($view, $form, []);

        $this->assertArrayHasKey('sitekey', $view->vars);
        $this->assertArrayHasKey('friendly_captcha', $view->vars);
    }

    /**
     * @test
     */
    public function buildViewWithOptions(): void
    {
        $view = new FormView();

        /** @var FormInterface $form */
        $form = $this->createMock(FormInterface::class);

        $this->assertArrayNotHasKey('sitekey', $view->vars);

        $this->type->buildView($view, $form, [
            'lang' => 'de',
            'start' => 'none',
            'callback' => 'globalThis.loadForm'
        ]);

        $this->assertArrayHasKey('sitekey', $view->vars);
        $this->assertArrayHasKey('friendly_captcha', $view->vars);
        $this->assertSame([
            'lang' => 'de',
            'start' => 'none',
            'callback' => 'globalThis.loadForm'
        ], $view->vars['friendly_captcha']);
    }

    /**
     * @test
     */
    public function buildViewWithoutLangOption(): void
    {
        $view = new FormView();

        /** @var FormInterface $form */
        $form = $this->createMock(FormInterface::class);

        $this->assertArrayNotHasKey('sitekey', $view->vars);

        $this->type->buildView($view, $form, [
            'start' => 'none',
            'callback' => 'globalThis.loadForm'
        ]);

        $this->assertArrayHasKey('sitekey', $view->vars);
        $this->assertArrayHasKey('friendly_captcha', $view->vars);
        $this->assertSame([
            'start' => 'none',
            'callback' => 'globalThis.loadForm'
        ], $view->vars['friendly_captcha']);
    }

    /**
     * @test
     */
    public function buildViewWithoutCallbackAndStartOption(): void
    {
        $view = new FormView();

        /** @var FormInterface $form */
        $form = $this->createMock(FormInterface::class);

        $this->assertArrayNotHasKey('sitekey', $view->vars);

        $this->type->buildView($view, $form, [
            'lang' => 'de',
        ]);

        $this->assertArrayHasKey('sitekey', $view->vars);
        $this->assertArrayHasKey('friendly_captcha', $view->vars);
        $this->assertSame([
            'lang' => 'de',
        ], $view->vars['friendly_captcha']);
    }

    /**
     * @test
     */
    public function getParent(): void
    {
        $this->assertSame(HiddenType::class, $this->type->getParent());
    }

    /**
     * @test
     */
    public function getPublicKey(): void
    {
        $this->assertSame('sitekey', $this->type->getSiteKey());
    }

    /**
     * @test
     */
    public function getBlockPrefix(): void
    {
        $this->assertEquals('cors_friendly_catcha_type', $this->type->getBlockPrefix());
    }
}
