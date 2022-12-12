<?php
declare(strict_types=1);

namespace Amasty\Dpanko\Controller\Index;

use Exception;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Amasty\Dpanko\Model\BlacklistFactory;
use Amasty\Dpanko\Model\ResourceModel\Blacklist as BlacklistResource;


class Form implements ActionInterface
{
    /**
     * @var CheckoutSession
     */
    private CheckoutSession $CheckoutSession;
    /**
     * @var ProductRepositoryInterface
     */
    public ProductRepositoryInterface $ProductRepository;
    /**
     * @var BlacklistFactory
     */
    private BlacklistFactory $blacklist;

    /**
     * @var BlacklistResource
     */
    private BlacklistResource $blacklistResource;
    /**
     * @var RequestInterface
     */
    public RequestInterface $request;

    private const FORM_ACTION = ' ';
    public const COLUMN_SKU = 'sku';

    public function __construct(
        RequestInterface           $request,
        CheckoutSession            $CheckoutSession,
        ProductRepositoryInterface $ProductRepository,
        BlacklistFactory           $blacklistFactory,
        BlacklistResource          $blacklistResource,
        ManagerInterface           $messageManager,


    )
    {
        $this->request = $request;
        $this->CheckoutSession = $CheckoutSession;
        $this->ProductRepository = $ProductRepository;
        $this->blacklistFactory = $blacklistFactory;
        $this->blacklistResource = $blacklistResource;
        $this->messageManager = $messageManager;

    }


    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */


    public function getFormAction()
    {
        return (self::FORM_ACTION);
    }

    public function execute()
    {
        $sku = $this->request->getParam('sku');
        $qty = $this->request->getParam('qty');
        $product = $this->ProductRepository->get($sku);

        $productType = $product->getTypeId($product);
        $quote = $this->CheckoutSession->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }
        if ($productType === 'simple') {
            $quote->addProduct($product, ['qty' => $qty]);
            try {
                $quote->save();
            } catch (Exception $e) {
                echo "нет достаточного qty: " . $e->getMessage();
            }
        } else
            $this->messageManager->addError(__("Данный продукт не simple"));


        $blacklist = $this->blacklistFactory->create();
        $blacklistQty = $blacklist->getQty();
        $this->blacklistResource->load($blacklist, $sku, self::COLUMN_SKU
        );


        try {
            $productType = $product->getTypeId($product);
        } catch (Exception $e) {
            echo "такого продукта не существует: " . $e->getMessage();
        }
        if (count($blacklist->getData()) > 0) {
            $item = $quote->getItemByProduct($product);

            if ($item) {
                if ($item->getSku() == $sku) {
                    $sumQty = $item->getQty() + $qty;
                    if ($sumQty > $blacklistQty) {
                        $sumQty = $blacklistQty - $item->getQty();
                    }
                } else {
                    $sumQty = $qty;
                }
                if ($sumQty > $blacklistQty) {
                    $this->addProductToCart($quote, $product, $blacklistQty,
                        'Товар был добавлен в количестве: ' . $blacklistQty);
                } elseif ($sumQty <= 0) {
                    $this->messageManager->addSuccessMessage(__('Товар не добавлен'));
                    return;
                } else {
                    $this->addProductToCart($quote, $product, $sumQty,
                        'Товар добавлен в количестве: ' . $sumQty);
                }
            } else {
                if ($qty > $blacklistQty) {
                    $this->addProductToCart($quote, $product, $blacklistQty,
                        'Товар  добавлен в количестве: ' . $blacklistQty);
                } elseif ($qty <= 0) {
                    $this->messageManager->addSuccessMessage(__('Товар не добавлен'));
                    return;
                } else {
                    $this->addProductToCart($quote, $product, $qty,
                        'Товар добавлен в количестве: ' . $qty);
                }
            }
        } else {
            if ($qty <= 0) {
                $this->messageManager->addSuccessMessage(__('Товар не добавлен'));
                return;
            } else {
                $this->addProductToCart($quote, $product, $qty,
                    'Товар  добавлен в количестве: ' . $qty);
            }
        }
    }

    private function addProductToCart($quote, $product, $qty)
    {
        $quote->addProduct($product, $qty);
        $quote->save();
    }
}