<?php
namespace JustinKase\LayoutHints\Plugin;

/**
 * Class WrapperInterface
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
interface WrapperInterface
{
    const JK_CONFIG_BLOCK_HINTS_STATUS = 'dev/justinkase_hints/justinkase_hints_status';
    const JK_TEMPLATE = '<div class="justinkase-hint"><code><strong>%s</strong> %s <span class="justinkase-hint-classname">%s</span></code>%s</div>';
}
