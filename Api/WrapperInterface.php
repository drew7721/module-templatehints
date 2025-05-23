<?php
/**
 * Copyright © 2020
 * @copyright Alex Ghiban & JustinKase.ca - All rights reserved.
 * @license GPL-3.0-only
 * @see https://justinkase.ca or https://ghiban.com
 * @contact <alex@justinkase.ca>
 */

namespace JustinKase\LayoutHints\Api;

/**
 * Class WrapperInterface
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
interface WrapperInterface
{
    const JK_CONFIG_BLOCK_HINTS_STATUS = 'dev/justinkase_hints/status';

    const JK_TEMPLATE = '<div class="justinkase-hint" id="%s"><span class="justinkase-hint-info type-%s">[%s] %s</span><div class="justinkase-hint-extra">%s</div>%s</div>';
}
