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
    protected function _construct()
    {
        parent::_construct();
        if ($this->isDeveloperMode()) {
            $this->pageConfig->addBodyClass('justinkase-hints-enabled');
        }
    }

    /**
     *
     * Check if app is deployed in developer mode.
     *
     * @return bool
     */
    public function isDeveloperMode()
    {
        return ($this->_appState->getMode() === $this->_appState::MODE_DEVELOPER);
    }

    /**
     * Are hints enabled?
     *
     * @return mixed
     */
    public function hintsAreEnabled()
    {
        return $this->_scopeConfig->getValue(WrapperInterface::JK_CONFIG_BLOCK_HINTS_STATUS);
    }
}
