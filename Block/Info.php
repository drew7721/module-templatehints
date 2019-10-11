<?php

namespace JustinKase\LayoutHints\Block;

use JustinKase\LayoutHints\Api\WrapperInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class Info
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
class Info extends Template
{
    /**
     * Should the jk-hints info show?
     *
     * Checks the app state and the status of the module.
     *
     * @return bool
     */
    public function isJustinKaseHintsEnabled()
    {
        return ($this->_appState->getMode() === $this->_appState::MODE_DEVELOPER)
            && $this->_scopeConfig->getValue(WrapperInterface::JK_CONFIG_BLOCK_HINTS_STATUS);
    }
}
