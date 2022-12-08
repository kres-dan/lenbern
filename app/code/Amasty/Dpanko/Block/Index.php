<?php
declare(strict_types=1);

namespace Amasty\Dpanko\Block;

use Magento\Framework\View\Element\Template;

class Index extends Template
{
    /**
     * @var string
     */
    private $classes;

    public function __construct(Template\Context $context, string $classes, array $data = [])
    {

        parent::__construct($context, $data);
        $this->classes = $classes;
    }

    public function getClasses(): string
    {
        return $this->classes;
    }

}