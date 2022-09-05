<?php

declare(strict_types=1);

/**
 * CORS GmbH.
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 *
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CORS GmbH (https://www.cors.gmbh)
 * @license    https://www.cors.gmbh/license     GPLv3
 */

namespace CORS\Bundle\FriendlyCaptchaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

final class FriendlyCaptchaType extends AbstractType
{
    protected string $sitekey;

    public function __construct(string $sitekey)
    {
        $this->sitekey = $sitekey;
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['sitekey'] = $this->sitekey;
    }

    public function getBlockPrefix()
    {
        return 'cors_friendly_catcha_type';
    }
}
