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
use Magento\Framework\View\Layout;
use Magento\Framework\View\Page\Config;

/**
 * Class Wrapper
 *
 * Plugin to wrap the rendered block content.
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
class Wrapper extends AbstractWrapper
{
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
        if ($this->isenabled()) {
            return $this->enhanceResult($layout, $name, $proceed);
        } else {
            return $proceed($name);
        }
    }

    public function enhanceResult(Layout $layout, $name, callable $proceed)
    {
        $type = $layout->getElementProperty($name, 'type');
        $extraData = [
            'Type' => $type,
            'Name' => $name,
            'Alias' => $layout->getElementAlias($name),
            'Parent' => $layout->getParentName($name),
        ];

        $htmlClass = $layout->getElementProperty($name, 'htmlClass');
        if ($htmlClass) {
            $extraData['Html Classes'] = $htmlClass ?? "NONE";
        }

        $block = $layout->getBlock($name);
        if ($block) {
            $blockData = [
                'Template' => $block->getTemplate(),
                'Module Name' => $block->getModuleName(),
                'Class' => get_class($block),
            ];

            $group = $layout->getElementProperty($name, 'group');
            if ($group) {
                $blockData['group'] = $group;
            }

            $extraData = array_merge($extraData, $blockData);
        }

        return $this->wrapInTemplate(
            $type,
            $name,
            $proceed($name),
            $extraData
        );
    }
}
