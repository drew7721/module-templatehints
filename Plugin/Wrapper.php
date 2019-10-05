<?php
namespace JustinKase\LayoutHints\Plugin;

/**
 * Class Wrapper
 *
 * Plugin for the classes :
 *  \Magento\Framework\View\Element\Template - fetchView
 *  \Magento\Framework\View\Layout - renderNonCachedElement
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
class Wrapper implements WrapperInterface
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
     * Wraps only around blocks to output the template file.
     *
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

    /**
     * This wraps around all rendering of elements.
     *
     * Indicates if it's a container, a ui element or a block and it's name.
     *
     * @param \Magento\Framework\View\Layout $subject
     * @param callable $proceed
     * @param $name
     *
     * @return string
     */
    public function aroundRenderNonCachedElement(
        \Magento\Framework\View\Layout $subject,
        callable $proceed,
        $name
    ) {
        $result = $proceed($name);

        if ($this->scopeConfig->getValue(self::JK_CONFIG_BLOCK_HINTS_STATUS)) {
            $type = $this->getElementType($subject, $name);
            $result = "<div class=\"justinkase-hint\"><code>($type) <strong>$name</strong></code>$result</div>";
        }

        return $result;
    }

    /**
     * Get the type of the element that is rendered.
     *
     * @param \Magento\Framework\View\Layout $subject
     * @param $name
     *
     * @return string
     */
    private function getElementType(\Magento\Framework\View\Layout $subject, $name)
    {
        if ($subject->isUiComponent($name)) {
            return "Ui";
        }

        if ($subject->isBlock($name)) {
            return "Block";
        }

        return "Container";
    }
}
