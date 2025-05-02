<?php
/**
 * Copyright © 2020
 * @copyright Alex Ghiban & JustinKase.ca - All rights reserved.
 * @license GPL-3.0-only
 * @see https://justinkase.ca or https://ghiban.com
 * @contact <alex@justinkase.ca>
 */

namespace JustinKase\LayoutHints\Plugin;

use JustinKase\LayoutHints\Api\WrapperInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State as AppState;
use Magento\Framework\Filter\DirectiveProcessorInterface;
use Magento\Framework\Filter\Template;
use Magento\Framework\View\Page\Config;

/**
 * Widget Wrapper
 *
 * Plugin to wrap the rendered widget content.
 *
 * TODO: create an abstract class for the common functionality between this and the BlockWrapper
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
class WidgetWrapper implements WrapperInterface
{

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

    public function afterProcess(DirectiveProcessorInterface $directiveProcessor, $result, array $construction, Template $filter, array $templateVariables)
    {
        if ($this->scopeConfig->getValue(self::JK_CONFIG_BLOCK_HINTS_STATUS) && $this->isDeveloperMode()) {
            $result = $this->wrapResult($directiveProcessor, $result, $construction, $filter, $templateVariables);
        }

        return $result;
    }


    public function wrapResult(DirectiveProcessorInterface $directiveProcessor, $result, array $construction, Template $filter, array $templateVariables)
    {


        $type = $construction[1];
        $widgetContent = $construction[0];
        $typeMatches = [];
        preg_match('/(?<=\btype=")[^"]+/', $construction[0], $typeMatches);
        $widgetClass = $typeMatches[0] ?? null;


        $pattern = '/(?<=\s)([a-zA-Z0-9_]+)(?==)/';
        $replacement = '<b>$1</b>';
        $widgetContent = preg_replace($pattern, $replacement, $widgetContent);

        $extraData = [
            'type' => $type,
            'name' => $widgetClass,
            'code' => $widgetContent
        ];

        $extraDataHtml = '<ul>';
        foreach ($extraData as $key => $value) {
            $extraDataHtml .= "<li>$key => $value</li>";
        }
        $extraDataHtml .= '</ul>';


        return sprintf(
            self::JK_TEMPLATE,
            $type,
            $type,
            $widgetClass,
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
