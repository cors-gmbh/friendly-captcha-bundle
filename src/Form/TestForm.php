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

namespace CORS\Bundle\FriendlyCaptchaBundle\Form;

use CORS\Bundle\FriendlyCaptchaBundle\Form\Type\FriendlyCaptchaType;
use CORS\Bundle\FriendlyCaptchaBundle\Validator\FriendlyCaptchaValid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class TestForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class)
            ->add('captcha', FriendlyCaptchaType::class, [
                'constraints' => [
                    new FriendlyCaptchaValid(),
                ],
            ])
            ->add('submit', SubmitType::class);
    }
}
