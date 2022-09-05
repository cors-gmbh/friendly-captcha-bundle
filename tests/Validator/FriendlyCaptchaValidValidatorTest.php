<?php

declare(strict_types=1);

namespace CORS\Tests\Bundle\FriendlyCaptchaBundle\Validator;

use CORS\Bundle\FriendlyCaptchaBundle\Validator\FriendlyCaptchaValid;
use CORS\Bundle\FriendlyCaptchaBundle\Validator\FriendlyCaptchaValidValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class FriendlyCaptchaValidValidatorTest extends TestCase
{
    public function testValidateFalse(): void
    {
        $context = $this->createMock(ExecutionContextInterface::class);
        $client = new MockHttpClient(static function() {
            return new MockResponse('{"success": false}');
        });

        $context->expects(self::once())
            ->method('addViolation');
        $context->expects(self::never())
            ->method('buildViolation');

        $validator = new FriendlyCaptchaValidValidator($client, 'secret', 'sitekey', '');
        $validator->initialize($context);
        $validator->validate('', $this->createMock(FriendlyCaptchaValid::class));
    }

    public function testValidateTrue(): void
    {
        $context = $this->createMock(ExecutionContextInterface::class);
        $client = new MockHttpClient(static function() {
            return new MockResponse('{"success": true}');
        });

        $context->expects(self::never())
            ->method('addViolation');
        $context->expects(self::never())
            ->method('buildViolation');

        $validator = new FriendlyCaptchaValidValidator($client, 'secret', 'sitekey', '');
        $validator->initialize($context);
        $validator->validate('', $this->createMock(FriendlyCaptchaValid::class));
    }
}
