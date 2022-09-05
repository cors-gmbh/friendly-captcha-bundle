<?php

declare(strict_types=1);

/**
 * CORS GmbH.
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) CORS GmbH (https://www.cors.gmbh)
 *  @license    https://www.cors.gmbh/license     GPLv3 and PCL
 */

use Pimcore\HttpKernel\BundleCollection\BundleCollection;
use Pimcore\Kernel as PimcoreKernel;

class Kernel extends PimcoreKernel
{
    public function registerBundlesToCollection(BundleCollection $collection)
    {
        $collection->addBundle(new \CORS\Bundle\FriendlyCaptchaBundle\CORSFriendlyCaptchaBundle());
    }
}
