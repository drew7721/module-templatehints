<?php
namespace JustinKase\LayoutHints\Console\Command;

use JustinKase\LayoutHints\Plugin\WrapperInterface;
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
class Hints extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Magento\Framework\App\Config\ConfigResource\ConfigInterface
     */
    private $config;

    /**
     * @var int
     */
    private $setState;

    /**
     * EnableHints constructor.
     *
     * @param \Magento\Framework\App\Config\ConfigResource\ConfigInterface $config
     * @param string|null $name
     * @param string|null $description
     * @param int $setState
     */
    public function __construct(
        \Magento\Framework\App\Config\ConfigResource\ConfigInterface $config,
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
