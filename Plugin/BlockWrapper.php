<?php
namespace JustinKase\LayoutHints\Plugin;

/**
 * Class BlockWrapper
 *
 * Plugin to wrap the block rendered results in a template hint `div`.
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
class BlockWrapper
{
    const JK_TEMPLATE = '<div class="justinkase-hint"><code><strong>%s</strong> %s</code>%s</div>';

    /**
     * @param \Magento\Framework\View\Element\Template $subject
     * @param string $result
     *
     * @return string
     */
    public function afterFetchView(
        \Magento\Framework\View\Element\Template $subject,
        $result
    ) {
        return sprintf(
            self::JK_TEMPLATE,
            $subject->getNameInLayout(),
            $subject->getTemplate(),
            $result
        );
    }
}
