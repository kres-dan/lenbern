<?php
declare(strict_types=1);

namespace Amasty\Dpanko\Block;

use Magento\Framework\View\Element\Template;

use Magento\Framework\App\Config\ScopeConfigInterface;


class Index extends Template
{
    private const WELCOME = 'dpanko/general/welcome_text';
    private const QTY = 'dpanko/general/enabled_qty';
    private const QTYFIELD = 'dpanko/general/field_qty';

    /**
     * @var string
     */
    private $classes;

    /**
     * @var ScopeConfigInterface
     */

    private ScopeConfigInterface $scopeConfig;

    public function __construct(Template\Context $context, ScopeConfigInterface $scopeConfig, array $data = [])
    {


        parent::__construct($context, $data);
        $this->_scopeConfig = $scopeConfig;


    }


    public function getClasses(): string
    {
        return $this->classes;

    }


    public function welcomeText()
    {
        $welcome_text = $this->_scopeConfig->getValue(self::WELCOME);
        return $welcome_text;
    }

    public function enabledQTY()
    {
        $enabledqty = $this->_scopeConfig->isSetFlag(self::QTY);

        return $enabledqty;
    }

    public function fieldQTY()
    {
        $fieldqty = $this->_scopeConfig->getValue(self::QTYFIELD);
        return $fieldqty;
    }


}