<?php

declare(strict_types=1);

namespace Amasty\DpankoExtend\Plugin\Block\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Controller\Cart\Add;


class ChangeMagentoCartAdd
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;


    public function __construct(
        ProductRepositoryInterface $productRepository,

    )
    {
        $this->productRepository = $productRepository;

    }

    public function beforeExecute(Add $subject)
    {
        $data = $subject->getRequest()->getParams();
        $sku = $data['sku'];
        $product = $this->productRepository->get($sku);

        $productId = $product->getId();
        $dataAdd = ['product' => $productId];
        $data = array_merge($data, $dataAdd);
        $subject->getRequest()->setParams($data);
    }
}