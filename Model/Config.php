<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /**
     * string
     */
    protected const WEBAPI_LOGS_IS_ENABLED_CONFIG_PATH = 'webapi_logs/log/enabled';

    /**
     * string
     */
    protected const WEBAPI_LOGS_LOG_SECRET_MODE = 'webapi_logs/log/secret_mode';

    /**
     * string
     */
    protected const WEBAPI_LOGS_LOG_SECRET_WORDS = 'webapi_logs/log/secret_words';

    /**
     * string
     */
    protected const WEBAPI_LOGS_LOG_CLEAN_OLDER_THAN_HOURS = 'webapi_logs/log/clean_older_than_hours';

    /**
     * string
     */
    protected const WEBAPI_LOGS_LOG_DISABLE_AJAX = 'webapi_logs/log/disable_ajax';

    /**
     * string
     */
    protected const WEBAPI_LOGS_WHITELIST_USERAGENTS = 'webapi_logs/whitelist/useragents';

    /**
     * string
     */
    protected const WEBAPI_LOGS_WHITELIST_IPS = 'webapi_logs/whitelist/ips';

    /**
     * string
     */
    protected const WEBAPI_LOGS_WHITELIST_URLS = 'webapi_logs/whitelist/urls';

    /**
     * string
     */
    protected const WEBAPI_LOGS_WHITELIST_METHOD = 'webapi_log/whitelist/method';


    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::WEBAPI_LOGS_IS_ENABLED_CONFIG_PATH,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function isSecretMode(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::WEBAPI_LOGS_LOG_SECRET_MODE,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return array
     */
    public function getSecrets(): array
    {
        $secrets = (string)$this->scopeConfig->getValue(
            self::WEBAPI_LOGS_LOG_SECRET_WORDS,
            ScopeInterface::SCOPE_WEBSITE
        );
        return preg_split('/\n|\r\n?/', $secrets);
    }

    /**
     * @return int
     */
    public function getCleanOlderThanHours(): int
    {
        return (int)$this->scopeConfig->getValue(
            self::WEBAPI_LOGS_LOG_CLEAN_OLDER_THAN_HOURS,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function isDisableAjax(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::WEBAPI_LOGS_LOG_DISABLE_AJAX,
            ScopeInterface::SCOPE_WEBSITE
        );
    }


    /**
     * @return array
     */
    public function getWhitelistedUserAgents(): array
    {
        $useragents = (string)$this->scopeConfig->getValue(
            self::WEBAPI_LOGS_WHITELIST_USERAGENTS,
            ScopeInterface::SCOPE_WEBSITE
        );
        return array_filter(preg_split('/\n|\r\n?/', $useragents));
    }

    /**
     * @return array
     */
    public function getWhitelistedIPs(): array
    {
        $ips = (string)$this->scopeConfig->getValue(
            self::WEBAPI_LOGS_WHITELIST_IPS,
            ScopeInterface::SCOPE_WEBSITE
        );
        return array_filter(preg_split('/\n|\r\n?/', $ips));
    }

    /**
     * @return array
     */
    public function getWhitelistedUrls(): array
    {
        $urls = (string)$this->scopeConfig->getValue(
            self::WEBAPI_LOGS_WHITELIST_URLS,
            ScopeInterface::SCOPE_WEBSITE
        );
        return array_filter(preg_split('/\n|\r\n?/', $urls));
    }

    /**
     * @return array
     */
    public function getWhitelistedMethods(): array
    {
        $methods = (string)$this->scopeConfig->getValue(
            self::WEBAPI_LOGS_WHITELIST_METHOD,
            ScopeInterface::SCOPE_WEBSITE
        );
        return array_filter(explode(',', $methods));
    }
}
