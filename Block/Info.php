<?php
/**
 * Copyright © 2020
 * @copyright Alex Ghiban & JustinKase.ca - All rights reserved.
 * @license GPL-3.0-only
 * @see https://justinkase.ca or https://ghiban.com
 * @contact <alex@justinkase.ca>
 */

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
     * Use the sub construct class.
     *
     * Add the body class to display the hints if they are enabled and the site
     * is deployed in developer mode.
     */
    protected function _construct()
    {
        parent::_construct();
        if ($this->isDeveloperMode() && $this->hintsAreEnabled()) {
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
        return $this->_appState->getMode() === $this->_appState::MODE_DEVELOPER;
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
