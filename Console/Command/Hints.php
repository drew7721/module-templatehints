<?php
/**
 * Copyright © 2020
 * @copyright Alex Ghiban & JustinKase.ca - All rights reserved.
 * @license GPL-3.0-only
 * @see https://justinkase.ca or https://ghiban.com
 * @contact <alex@justinkase.ca>
 */

namespace JustinKase\LayoutHints\Console\Command;

use JustinKase\LayoutHints\Api\WrapperInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Hints
 *
 * Console command class that disables the hints.
 *
 * The class to enable the hints is virtual, see di.xml file.
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 */
class Hints extends Command
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var int
     */
    private $setState;

    /**
     * EnableHints constructor.
     *
     * @param ConfigInterface $config
     * @param string|null $name
     * @param string|null $description
     * @param int $setState
     */
    public function __construct(
        ConfigInterface $config,
        string $name = 'justinkase:hints:off',
        string $description = 'Disable Hints',
        int $setState = 0
    ) {
        parent::__construct($name);
        $this->setDescription($description);
        $this->config = $config;
        $this->setState = $setState;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config->saveConfig(
            WrapperInterface::JK_CONFIG_BLOCK_HINTS_STATUS,
            $this->setState
        );
        $status = ($this->setState === 0) ? "Disabled" : "Enabled";
        $output->writeln("<info>{$status} JK template hints.</info>");
    }
}
