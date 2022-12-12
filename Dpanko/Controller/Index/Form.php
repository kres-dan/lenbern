<?php
declare(strict_types=1);

namespace Amasty\Dpanko\Controller\Index;

use Exception;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use  Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Event\ManagerInterface as EventManagerInterface;
use Magento\Framework\Controller\Result;


class Form implements ActionInterface
{
    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;

    /**
     * @var CheckoutSession
     */
    private CheckoutSession $CheckoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    public ProductRepositoryInterface $ProductRepository;

    /**
     * @var EventManagerInterface
     */
    private EventManagerInterface $eventManager;

    /**
     * @var RequestInterface
     */
    public RequestInterface $request;

    /**
     * @var ProductInterface
     */
    public ProductInterface $product;

    /**
     * @param
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */

    public function __construct(
        RequestInterface           $request,
        CheckoutSession            $CheckoutSession,
        ProductRepositoryInterface $ProductRepository,
        ResultFactory              $resultFactory,
        ManagerInterface           $messageManager,
        EventManagerInterface      $eventManager,
    )
    {
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->CheckoutSession = $CheckoutSession;
        $this->ProductRepository = $ProductRepository;
        $this->messageManager = $messageManager;
        $this->eventManager = $eventManager;
    }

    public function execute()
    {

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('dpanko/index/index');
        $sku = $this->request->getParam('sku');
        if ($sku === null) {
            $this->messageManager->addWarningMessage('Введите sku');
            return $resultRedirect;
        }

        $qty = $this->request->getParam('qty');
        if ($qty === null) {
            $this->messageManager->addWarningMessage('Введите qty');
            return $resultRedirect;
        }
        $quote = $this->CheckoutSession->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }

        try {
            $product = $this->ProductRepository->get($sku);
            } catch (Exception $e) {
            echo "такого продукта не существует: " . $e->getMessage();
            return $resultRedirect;
        }

        $productType = $product->getTypeId();
        $warechousQty = $product->getExtensionAttributes()->getStockItem()->getQty();

        if ($productType === 'simple')
        {
            if ($qty <= $warechousQty) {
                $quote->addProduct($product, ['qty' => $qty]);
                $quote->save();
            } else {
                $this->messageManager->addWarningMessage('Введите меньшее qty');
                return $resultRedirect;
            }}
        else{
            $this->messageManager->addWarningMessage('Данный продукт не simple');
            return $resultRedirect;}
        }
}
