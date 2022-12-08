<?php
declare(strict_types=1);

namespace Amasty\DpankoExtend\Plugin\Block\Index;

use Amasty\Dpanko\Block\Index;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Event\ObserverInterface;

class ChangeAction
{
    public function aftergetFormAction(Index $subject, $product, $params)
    {
        $product = (int)$this->getRequest()->getParam('sku');
        if ($product) {
            $store = $this->_objectManager->get(
                \Magento\Store\Model\StoreManagerInterface::class
            )->getStore()->get();
            try {
                return $this->productRepository->getById($product, false, $store);
            } catch (NoSuchEntityException $e) {
                return false;
            }
        }
        return false;
    }
}

use Amasty\BaharOleg\Block\Form;

class ChangeFormAction
{
    const NEW_ACTION_FORM_URL = 'checkout/cart/add';

    public function afterGetFormAction(Form $subject): string
    {
        return $subject->getUrl(self::NEW_ACTION_FORM_URL);
    }

}