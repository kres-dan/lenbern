<?php
namespace Amasty\Dpanko\Controller\Index\Index;

/**
 * Interceptor class for @see \Amasty\Dpanko\Controller\Index\Index
 */
class Interceptor extends \Amasty\Dpanko\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Controller\ResultFactory $resultFactory, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Checkout\Model\Session $CheckoutSession, \Magento\Catalog\Api\ProductRepositoryInterface $ProductRepository, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $ProductCollectionFactory)
    {
        $this->___init();
        parent::__construct($resultFactory, $scopeConfig, $CheckoutSession, $ProductRepository, $ProductCollectionFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
