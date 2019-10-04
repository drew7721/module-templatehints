<?php
namespace JustinKase\LayoutHints\Plugin;

/**
 * Class BlockWrapper
 *
 * Plugin to wrap the block rendered results in a template hint `div`.
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
class BlockWrapper implements WrapperInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * BlockWrapper constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

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
        if ($this->scopeConfig->getValue(self::JK_CONFIG_BLOCK_HINTS_STATUS)) {
            $result = sprintf(
                self::JK_TEMPLATE,
                $subject->getNameInLayout(),
                $subject->getTemplate(),
                $result
            );
        }

        return $result;
    }
}
