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
class WidgetWrapper extends AbstractWrapper
{
    public function afterProcess(DirectiveProcessorInterface $directiveProcessor, $result, array $construction, Template $filter, array $templateVariables)
    {
        if ($this->isEnabled()) {
            $result = $this->enhanceResult($directiveProcessor, $result, $construction, $filter, $templateVariables);
        }

        return $result;
    }


    public function enhanceResult(DirectiveProcessorInterface $directiveProcessor, $result, array $construction, Template $filter, array $templateVariables)
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
            'Type' => $type,
            'Name' => $widgetClass,
            'Code' => $widgetContent
        ];

        return $this->wrapInTemplate(
            $type,
            $widgetClass,
            $result,
            $extraData
        );
    }

}
