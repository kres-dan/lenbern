<?php
declare(strict_types=1);

namespace Amasty\Dpanko\Block\Email;

use Magento\Framework\View\Element\Template;

class wish extends Template
{


    public function execute()
    {
        $text = 'Хорошего дня';
        return $text;

    }
}