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

namespace CORS\Bundle\FriendlyCaptchaBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class CORSFriendlyCaptchaBundle extends AbstractPimcoreBundle
{
    public function getNiceName(): string
    {
        return 'CORS - Friendly Captcha Bundle';
    }

    public function getDescription(): string
    {
        return 'CORS Friendly Captcha Bundle';
    }
}
