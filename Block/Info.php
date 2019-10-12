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
     * Should the jk-hints info show?
     *
     * Checks the app state and the status of the module.
     *
     * @return bool
     */
    public function isDeveloperMode()
    {
        return ($this->_appState->getMode() === $this->_appState::MODE_DEVELOPER);
    }
}
