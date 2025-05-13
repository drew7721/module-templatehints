<?php

namespace JustinKase\LayoutHints\Plugin;

use JustinKase\LayoutHints\Api\WrapperInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State as AppState;
use Magento\Framework\View\Page\Config;

abstract class AbstractWrapper implements WrapperInterface
{

    /**
     * @var ScopeConfigInterface $scopeConfig
     */
    protected $scopeConfig;

    /**
     * @var AppState $appState
     */
    protected $appState;

    /**
     * @var Config
     */
    protected $pageConfig;

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

    protected function isEnabled()
    {
        return $this->scopeConfig->getValue(self::JK_CONFIG_BLOCK_HINTS_STATUS) && $this->isDeveloperMode();
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


    protected function renderExtraData($extraData): string
    {
        $extraDataHtml = '';
        foreach ($extraData as $key => $value) {
            $keyName = ucfirst($key);
            $extraDataHtml .= "<div><b>$keyName</b>: <code>$value</code></div>";
        }

        return $extraDataHtml;
    }

    protected function wrapInTemplate(string $type, string $identifier, $content, array $extraData): string
    {
        return sprintf(
            self::JK_TEMPLATE,
            $identifier,
            $type,
            $type,
            $identifier,
            $this->renderExtraData($extraData),
            $content
        );
    }
}
