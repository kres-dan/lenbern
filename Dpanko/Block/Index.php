<?php
declare(strict_types=1);

namespace Amasty\Dpanko\Block;

use Magento\Framework\View\Element\Template;

use Magento\Framework\App\Config\ScopeConfigInterface;


class Index extends Template
{
    private const VALUE_FIELD_WELCOME_TEXT_PATH = 'dpanko/general/welcome_text';
    private const IS_ENABLED_FIELD_QTY_PATH = 'dpanko/general/enabled_qty';
    private const VALUE_FIELD_QTY_PATH = 'dpanko/general/field_qty';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    public function __construct(Template\Context $context, ScopeConfigInterface $scopeConfig, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_scopeConfig = $scopeConfig;
    }

    public function getWelcomeText()
    {
        $welcome_text = $this->_scopeConfig->getValue(self::VALUE_FIELD_WELCOME_TEXT_PATH);
        return $welcome_text;
    }

    public function getEnabledQty()
    {
        $enabledqty = $this->_scopeConfig->isSetFlag(self::IS_ENABLED_FIELD_QTY_PATH);
        return $enabledqty;
    }

    public function getFieldQty()
    {
        $fieldqty = $this->_scopeConfig->getValue(self::VALUE_FIELD_QTY_PATH);
        return $fieldqty;
    }
}