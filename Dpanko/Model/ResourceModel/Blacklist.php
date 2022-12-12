<?php

namespace Amasty\Dpanko\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blacklist extends AbstractDb
{
    public const TABLE_NAME = 'amasty_dpanko_blacklist';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'sku_id');
    }
}