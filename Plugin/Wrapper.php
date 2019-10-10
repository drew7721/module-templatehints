<?php
namespace JustinKase\LayoutHints\Plugin;

use JustinKase\LayoutHints\Api\WrapperInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State as AppState;
use Magento\Framework\View\Layout\Element;

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
    const JK_TEMPLATE = '<div class="justinkase-hint"><span class="justinkase-hint-info">[%s]%s</span><div class="justinkase-hint-extra">%s</div>%s</div>';

    /**
     * @var ScopeConfigInterface $scopeConfig
     */
    protected $scopeConfig;

    /**
     * @var AppState $appState
     */
    private $appState;

    /**
     * @var bool $bodyClassSet
     */
    private $bodyClassSet = false;

    /**
     * @var \Magento\Framework\View\Page\Config
     */
    private $pageConfig;

    /**
     * BlockWrapper constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\View\Page\Config $pageConfig
     * @param AppState $appState
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\View\Page\Config $pageConfig,
        AppState $appState
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->appState = $appState;
        $this->pageConfig = $pageConfig;
    }

    /**
     * This wraps around all rendering of elements.
     *
     * Indicates if it's a container, a ui element or a block and it's name.
     *
     * @param \Magento\Framework\View\Layout $layout
     * @param callable $proceed
     * @param $name
     *
     * @return string
     */
    public function aroundRenderNonCachedElement(
        \Magento\Framework\View\Layout $layout,
        callable $proceed,
        $name
    ) {
        /** @var string $result */
        $result = $proceed($name);

        if ($this->scopeConfig->getValue(self::JK_CONFIG_BLOCK_HINTS_STATUS) && $this->isDeveloperMode()) {
            if (!$this->bodyClassSet) {
                $this->pageConfig->addBodyClass('justinkase-hints-enabled');
                $this->bodyClassSet = true;
            }

            $result = $this->wrapResult($layout, $name, $result);
        }

        return $result;
    }

    public function wrapResult(\Magento\Framework\View\Layout $layout, $name, string $result)
    {
        $type = $layout->getElementProperty($name, 'type');
        $extraData = [
            'type' => $type,
            'alias' => $layout->getElementAlias($name),
            'name' => $name,
            'parent' => $layout->getParentName($name),
        ];
        $block = $layout->getBlock($name);
        if ($block) {
            $blockData = [
                'module_name' => $block->getModuleName(),
                'cache_key' => $block->getCacheKey(),
                'template' => $block->getTemplate(),
                'block_class' => get_class($block)
            ];
            $extraData = array_merge($extraData, $blockData);
        }
        $extraDataHtml = '<ul>';
        foreach ($extraData as $key => $value) {
            $extraDataHtml .= "<li><strong>$key</strong>: $value</li>";
        }
        $extraDataHtml .= '</ul>';


        return sprintf(
            self::JK_TEMPLATE,
            $type,
            $name,
            $extraDataHtml,
            $result
        );
    }

    /**
     * Check if in developer mode.
     *
     * @return bool
     */
    private function isDeveloperMode()
    {
        return ($this->appState->getMode() === AppState::MODE_DEVELOPER);
    }
}
