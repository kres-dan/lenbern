<?php

declare(strict_types=1);

namespace Amasty\Dpanko\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\CatalogInventory\Model\Stock\StockItemRepository as StockItem;
use Magento\Catalog\Model\Product as Product;

class Index implements ActionInterface
{

    private const IS_MODULE_ENABLED_CONFIG_PATH = 'dpanko/general/enabled';

    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $ScopeConfig;

    /**
     * @var CheckoutSession
     */
    private CheckoutSession $CheckoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $ProductRepository;

    public function __construct(
        ResultFactory              $resultFactory,
        ScopeConfigInterface       $scopeConfig,
        CheckoutSession            $CheckoutSession,
        ProductRepositoryInterface $ProductRepository,
    )
    {
        $this->resultFactory = $resultFactory;
        $this->ScopeConfig = $scopeConfig;
        $this->CheckoutSession = $CheckoutSession;
        $this->ProductRepository = $ProductRepository;
    }

    public function execute()
    {
        $isEnabled = $this->ScopeConfig->isSetFlag(self::IS_MODULE_ENABLED_CONFIG_PATH);
        if (!$isEnabled)
        {
            echo "Модуль выключен";
            exit();
        }
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
