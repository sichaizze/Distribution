<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Invalid\UnexpectedRoutingPrefix2;

use Claroline\CoreBundle\Library\DistributionPluginBundle;

class InvalidUnexpectedRoutingPrefix2 extends DistributionPluginBundle
{
    public function getRoutingPrefix()
    {
        return '';
    }
}
