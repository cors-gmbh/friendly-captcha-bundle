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

namespace CORS\Bundle\FriendlyCaptchaBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FriendlyCaptchaValidValidator extends ConstraintValidator
{
    protected HttpClientInterface $httpClient;
    protected string $secret;
    protected string $sitekey;

    public function __construct(HttpClientInterface $httpClient, string $secret, string $sitekey)
    {
        $this->httpClient = $httpClient;
        $this->secret = $secret;
        $this->sitekey = $sitekey;
    }

    public function validate($value, Constraint $constraint)
    {
        $response = $this->httpClient->request('POST', 'https://api.friendlycaptcha.com/api/v1/siteverify', [
            'body' => [
                'secret' => $this->secret,
                'sitekey' => $this->sitekey,
                'solution' => $value,
            ],
        ]);

        $content = $response->getContent();

        if (!$content) {
            $this->context->addViolation($constraint->message);

            return;
        }

        $result = \json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        if (array_key_exists('success', $result) && $result['success']) {
            return;
        }

        $this->context->addViolation($constraint->message);
    }
}
