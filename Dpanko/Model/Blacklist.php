<?php

namespace Amasty\Dpanko\Model;

use Magento\Framework\Model\AbstractModel;

class Blacklist extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Amasty\Dpanko\Model\ResourceModel\Blacklist::class);
    }

}