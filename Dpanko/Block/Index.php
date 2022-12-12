<?php
declare(strict_types=1);

namespace Amasty\Dpanko\Block;

use Magento\Framework\View\Element\Template;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\ManagerInterface as EventManadgerInterface;


class Index extends Template
{
    private const WELCOME = 'dpanko/general/welcome_text';
    private const QTY = 'dpanko/general/enabled_qty';
    private const QTYFIELD = 'dpanko/general/field_qty';
    private const promoSKU = 'dpanko/general/promoSKU';

    /**
     * @var string
     */
    private $classes;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;
    /**
     * @var EventManadgerInterface
     */

    private EventManadgerInterface $eventManadger;


    public function __construct(Template\Context $context, ScopeConfigInterface $scopeConfig, EventManadgerInterface $eventManadger, array $data = [])
    {


        parent::__construct($context, $data);
        $this->_scopeConfig = $scopeConfig;
        $this->eventManadger = $eventManadger;


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

    public function getpromoSKU()
    {
        $promoSKU = $this->_scopeConfig->getValue(self::promoSKU);
        $promoSKUObject = new \Magento\Framework\DataObject();
        $promoSKUObject->setName($promoSKU);

        $this->eventManadger->dispatch('amasty_dpanko_get_data', ['promoSKUObject' => $promoSKUObject]);

        return $promoSKUObject->getName();

    }

}