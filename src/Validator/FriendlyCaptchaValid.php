<?php

declare(strict_types=1);

namespace CORS\Bundle\FriendlyCaptchaBundle\Validator;

use Symfony\Component\Validator\Constraint;

class FriendlyCaptchaValid extends Constraint
{
    public $message = 'Friendly Captcha is Invalid';

    public function validatedBy()
    {
        return 'cors_friendly_captcha_validator';
    }
}
