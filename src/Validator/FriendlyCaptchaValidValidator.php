<?php

declare(strict_types=1);

namespace CORS\Bundle\FriendlyCaptchaBundle\Validator;

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FriendlyCaptchaValidValidator extends ConstraintValidator
{
    protected HttpClientInterface $httpClient;
    protected string $secret;
    protected string $sitekey;
    protected string $endpoint;

    public function __construct(HttpClientInterface $httpClient, string $secret, string $sitekey, string $endpoint)
    {
        $this->httpClient = $httpClient;
        $this->secret = $secret;
        $this->sitekey = $sitekey;
        $this->endpoint = $endpoint;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FriendlyCaptchaValid) {
            throw new UnexpectedTypeException($constraint, FriendlyCaptchaValid::class);
        }

        $response = $this->httpClient->request('POST', $this->endpoint, [
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

        if (array_key_exists('success', $result) && $result['success'] === true) {
            return;
        }

        $this->context->addViolation($constraint->message);
    }
}
