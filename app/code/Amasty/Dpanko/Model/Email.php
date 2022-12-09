<?php
declare(strict_types=1);

namespace Amasty\Dpanko\Model;

use Magento\Framework\Mail\Template\FactoryInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Search\ViewModel\ConfigProvider;


class Email
{
    /**
     * @var ConfigProvider
     */
    private ConfigProvider $configProvider;

    /**
     * @var TransportBuilder
     */
    private TransportBuilder $transportBuilder;


    /**
     * @var BlacklistRepository
     */
    private BlacklistRepository $blacklistRepository;

    /**
     * @var FactoryInterface
     */
    private FactoryInterface $templateFactory;

    public function __construct(
        ConfigProvider      $configProvider,
        TransportBuilder    $transportBuilder,
        BlacklistRepository $blacklistRepository,
        FactoryInterface    $templateFactory
    )
    {
        $this->configProvider = $configProvider;
        $this->transportBuilder = $transportBuilder;
        $this->blacklistRepository = $blacklistRepository;
        $this->templateFactory = $templateFactory;
    }

    public function Send()
    {
        $id = 1;
        $blacklist = $this->blacklistRepository->getBlacklistById($id);

        $this->transportBuilder->setTemplateIdentifier(
            'dpanko_template'
        )->setTemplateOptions(
            [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => 1,

            ]
        )->setFromByScope(
            'general'
        )->setReplyTo(
            'pankodanil@gmail.com',
            'Daniel'
        )->setTemplateVars([
            'qty' => $blacklist->getQty(),


        ])->addTo(
            'example@gmail.com',
            'Alex'
        );
        $transport = $this->transportBuilder->getTransport();
        $transport->sendMessage();

    }


}