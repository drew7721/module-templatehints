<?php

namespace JustinKase\LayoutHints\Plugin;

class CmsBlockWrapper extends AbstractWrapper
{
    /**
     * @param \Magento\Cms\Block\Block $block
     * @param string $result
     * @return string
     */
    public function afterToHtml($block, $result)
    {
        if ($this->isEnabled()) {
            $result = $this->enhanceResult($block, $result);
        }

        return $result;
    }

    /**
     * @param \Magento\Cms\Block\Block $block
     * @param string $result
     * @return string
     */
    private function enhanceResult($block, $result): string
    {
        $layout = $block->getLayout();
        $name = $block->getNameInLayout();
        $extraData = [
            'Type' => 'CMS Block',
            'Name' => $name,
            'Module' => $block->getModuleName(),
        ];

        $wrappedHtml = $this->wrapInTemplate(
            'cms-block',
            $name,
            $result,
            $extraData
        );

        return $wrappedHtml;
    }
}
