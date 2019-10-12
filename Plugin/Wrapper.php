<?php
namespace JustinKase\LayoutHints\Plugin;

use JustinKase\LayoutHints\Api\WrapperInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State as AppState;
use Magento\Framework\View\Layout;
use Magento\Framework\View\Page\Config;

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
    const JK_TEMPLATE = '<div class="justinkase-hint"><span class="justinkase-hint-info">[%s] %s</span><div class="justinkase-hint-extra">%s</div>%s</div>';

    /**
     * @var ScopeConfigInterface $scopeConfig
     */
    protected $scopeConfig;

    /**
     * @var AppState $appState
     */
    private $appState;

    /**
     * @var Config
     */
    private $pageConfig;

    /**
     * BlockWrapper constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param Config $pageConfig
     * @param AppState $appState
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Config $pageConfig,
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
     * @param Layout $layout
     * @param callable $proceed
     * @param $name
     *
     * @return string
     */
    public function aroundRenderNonCachedElement(
        Layout $layout,
        callable $proceed,
        $name
    ) {
        if ($this->scopeConfig->getValue(self::JK_CONFIG_BLOCK_HINTS_STATUS) && $this->isDeveloperMode()) {
            $result = $this->wrapResult($layout, $name, $proceed);
        } else {
            $result = $proceed($name);
        }

        return $result;
    }

    public function wrapResult(Layout $layout, $name, callable $proceed)
    {
        $type = $layout->getElementProperty($name, 'type');
        $extraData = [
            'type' => $type,
            'name' => $name,
            'alias' => $layout->getElementAlias($name),
            'parent' => $layout->getParentName($name),
        ];
        $block = $layout->getBlock($name);
        if ($block) {
            $blockData = [
                'template' => $block->getTemplate(),
                'module_name' => $block->getModuleName(),
                'class' => get_class($block),
            ];

            $group = $layout->getElementProperty($name, 'group');
            if ($group) {
                $blockData['group'] = $group;
            }

            $extraData = array_merge($extraData, $blockData);
        }
        $extraDataHtml = '<ul>';
        foreach ($extraData as $key => $value) {
            $extraDataHtml .= "<li>$key => $value</li>";
        }
        $extraDataHtml .= '</ul>';


        return sprintf(
            self::JK_TEMPLATE,
            $type,
            $name,
            $extraDataHtml,
            $proceed($name)
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
