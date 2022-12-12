<?php
declare(strict_types=1);

namespace Amasty\DpankoExtend\Block;

class Index extends \Amasty\Dpanko\Controller\Index\Index
{
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()) {
            return parent::execute();
        } else {
            echo 'Только зарегистрированные(залогиненные) клиенты имеют сюда доступ';
        }
    }
}