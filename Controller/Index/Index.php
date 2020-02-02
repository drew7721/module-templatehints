<?php
/**
 * Copyright © 2020
 * @copyright Alex Ghiban & JustinKase.ca - All rights reserved.
 * @license GPL-3.0-only
 * @see https://justinkase.ca or https://ghiban.com
 * @contact <alex@justinkase.ca>
 */

namespace JustinKase\LayoutHints\Controller\Index;

use JustinKase\LayoutHints\Api\WrapperInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Event\ManagerInterface as EventManagerInterface;
use Magento\Framework\App\Cache\Manager;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;

/**
 * Json Endpoint controller.
 *
 * This endpoint is responsible for controlling back end operations from the frontend.
 *
 * Functionality:
 *  - This will allow to clear the caches from the front-end
 *  - Allows to turn the hints module on/off from the front-end
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var EventManagerInterface
     */
    private $eventManager;
    /**
     * @var Manager
     */
    private $cacheManager;
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * Index constructor.
     * @param Context $context
     * @param EventManagerInterface $eventManager
     * @param Manager $cacheManager
     * @param ConfigInterface $config
     */
    public function __construct(
        Context $context,
        EventManagerInterface $eventManager,
        Manager $cacheManager,
        ConfigInterface $config
    ) {
        parent::__construct($context);
        $this->eventManager = $eventManager;
        $this->cacheManager = $cacheManager;
        $this->config = $config;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $result = "Hmm... something went wrong. Sorry.";
        $action = $this->_request->getParam('action');

        if ($action === 'clearCaches') {
            $caches = $this->cacheManager->getAvailableTypes();
            $this->eventManager->dispatch('adminhtml_cache_flush_all');
            $this->cacheManager->flush(
                $caches
            );
            $result = "Success Clearing All Caches!";
        }

        if ($action === 'hintsOff') {
            $this->config->saveConfig(WrapperInterface::JK_CONFIG_BLOCK_HINTS_STATUS, 0);
            $result = "Hints are OFF. Use Ctrl+Shift+C to clear caches.";
        }

        if ($action === 'hintsOn') {
            $this->config->saveConfig(WrapperInterface::JK_CONFIG_BLOCK_HINTS_STATUS, 1);
            $result = "Hints are ON. Use Ctrl+Shift+C to clear caches.";
        }

        /** @var Json $jsonResponse */
        $jsonResponse = $this->resultFactory->create($this->resultFactory::TYPE_JSON);
        $jsonResponse->setData([
            'result' => $result
        ]);

        return $jsonResponse;
    }
}
