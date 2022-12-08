<?php

declare(strict_types=1);

namespace Amasty\Dpanko\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Index implements ActionInterface
{

    private const EBABLED = 'dpanko/general/enabled';


    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;


    /**
     * @var ScopeConfigInterface
     */

    private ScopeConfigInterface $ScopeConfig;


    public function __construct(
        ResultFactory        $resultFactory,
        ScopeConfigInterface $scopeConfig,
    )
    {
        $this->resultFactory = $resultFactory;
        $this->ScopeConfig = $scopeConfig;
    }


    public function execute()
    {


        $isEnabled = $this->ScopeConfig->isSetFlag(self::EBABLED);
        if (!$isEnabled) {
            echo "Модуль выключен";
            exit();
        }
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }

}
