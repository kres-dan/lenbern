<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Developer\Model\View\Asset\PreProcessor;

use Magento\Developer\Model\Config\Source\WorkflowType;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\State;
use Magento\Framework\View\Asset\PreProcessor;
use Magento\Framework\View\Asset\PreProcessor\AlternativeSourceInterface;
use Magento\Framework\View\Asset\PreProcessorInterface;

/**
 * Selection of the strategy for assets pre-processing
 *
 * @api
 * @since 100.0.2
 */
class PreprocessorStrategy implements PreProcessorInterface
{
    /**
     * @var FrontendCompilation
     */
    private $frontendCompilation;

    /**
     * @var AlternativeSourceInterface
     */
    private $alternativeSource;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var State
     */
    private $state;

    /**
     * @param AlternativeSourceInterface $alternativeSource
     * @param FrontendCompilation $frontendCompilation
     * @param ScopeConfigInterface $scopeConfig
     * @param State|null $state
     */
    public function __construct(
        AlternativeSourceInterface $alternativeSource,
        FrontendCompilation $frontendCompilation,
        ScopeConfigInterface $scopeConfig,
        ?State $state = null
    ) {
        $this->frontendCompilation = $frontendCompilation;
        $this->alternativeSource = $alternativeSource;
        $this->scopeConfig = $scopeConfig;
        $this->state = $state ?? ObjectManager::getInstance()->get(State::class);
    }

    /**
     * Transform content and/or content type for the specified pre-processing chain object
     *
     * @param PreProcessor\Chain $chain
     *
     * @return void
     */
    public function process(PreProcessor\Chain $chain)
    {
        $isClientSideCompilation =
            $this->state->getMode() !== State::MODE_PRODUCTION
            && WorkflowType::CLIENT_SIDE_COMPILATION === $this->scopeConfig->getValue(WorkflowType::CONFIG_NAME_PATH);

        if ($isClientSideCompilation) {
            $this->frontendCompilation->process($chain);
        } else {
            $this->alternativeSource->process($chain);
        }
    }
}
