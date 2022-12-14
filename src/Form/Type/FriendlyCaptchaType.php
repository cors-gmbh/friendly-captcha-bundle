<?php

declare(strict_types=1);

namespace CORS\Bundle\FriendlyCaptchaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class FriendlyCaptchaType extends AbstractType
{
    protected $sitekey;
    protected $endpoint;

    public function __construct(string $sitekey, string $endpoint)
    {
        $this->sitekey = $sitekey;
        $this->endpoint = $endpoint;
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $fcValues = array_filter([
            'puzzle-endpoint' => $this->endpoint,
            'lang' => $options['lang'] ?? null,
            'start' => $options['start'] ?? null,
            'callback' => $options['callback'] ?? null,
        ]);

        $view->vars['sitekey'] = $this->sitekey;
        $view->vars['friendly_captcha'] = $fcValues;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'lang' => null,
            'start' => 'focus',
            'callback' => null,
        ]);

        $resolver->setAllowedValues('start', ['auto', 'focus', 'none']);
    }

    public function getBlockPrefix()
    {
        return 'cors_friendly_catcha_type';
    }

    public function getSiteKey(): string
    {
        return $this->sitekey;
    }

}
