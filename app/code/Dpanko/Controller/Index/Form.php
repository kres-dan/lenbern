<?php
declare(strict_types=1);

namespace Amasty\Dpanko\Controller\Index;

use Exception;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use  Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;


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
    public RequestInterface $request;



    public function __construct(
        RequestInterface           $request,
        CheckoutSession            $CheckoutSession,
        ProductRepositoryInterface $ProductRepository,
        ResultFactory              $resultFactory,
        ManagerInterface           $messageManager,


    )
    {
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->CheckoutSession = $CheckoutSession;
        $this->ProductRepository = $ProductRepository;
        $this->messageManager = $messageManager;


    }


    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException

     */


    /**
     * @param
     */
    public \Magento\Catalog\Api\Data\ProductInterface $product;

    public function execute()
    {


        $sku = $this->request->getParam('sku');
        $qty = $this->request->getParam('qty');
        $quote = $this->CheckoutSession->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }
        $product = $this->ProductRepository->get($sku);

        try {
            $productType = $product->getTypeId($product);
        } catch (Exception $e) {
            echo "такого продукта не существует: " . $e->getMessage();
        }

        $productType = $product->getTypeId($product);
        if ($productType === 'simple') {
            $quote->addProduct($product, ['qty' => $qty]);
            try {
                $quote->save();
            } catch (Exception $e) {
                echo "нет достаточного qty: " . $e->getMessage();
            }
        } else
            $this->messageManager->addError(__("Данный продукт не simple"));


    }


}