<?php

declare(strict_types=1);

namespace Netlogix\Nxslack;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ConfigurationService
{
    public const TOKEN = 'token';

    public const CHANNEL = 'channel';

    public const MESSAGE_TITLE = 'message_title';

    /**
     * @return mixed
     */
    protected static function getExtensionConfiguration(string $path)
    {
        return GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('nxslack', $path);
    }

    public static function getToken(): ?string
    {
        return self::getExtensionConfiguration(self::TOKEN);
    }

    public static function getChannel(): ?string
    {
        return self::getExtensionConfiguration(self::CHANNEL);
    }

    public static function getMessageTitle(): ?string
    {
        return self::getExtensionConfiguration(self::MESSAGE_TITLE);
    }
}
