<?php

declare(strict_types=1);

namespace Netlogix\Nxslack;

use Psr\Http\Message\RequestFactoryInterface;
use TYPO3\CMS\Core\Log\LogRecord;
use TYPO3\CMS\Core\Log\Writer\AbstractWriter;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SlackLogWriter extends AbstractWriter
{
    protected RequestFactoryInterface $requestFactory;

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->requestFactory = GeneralUtility::makeinstance(RequestFactoryInterface::class);
    }

    public function writeLog(LogRecord $record)
    {
        $blocks = [
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => sprintf("*%s:* \n%s", ConfigurationService::getMessageTitle(), $record->getMessage()),
                ],
            ],
        ];

        $this->requestFactory->request(
            'https://slack.com/api/chat.postMessage',
            'POST',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . ConfigurationService::getToken(),
                    'Content-type' => 'application/json; charset=utf-8',
                ],
                'json' => [
                    'channel' => ConfigurationService::getChannel(),
                    'blocks' => $blocks,
                ],
            ]
        );
    }
}
