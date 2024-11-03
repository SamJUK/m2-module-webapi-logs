<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model;

use Magento\Framework\App\RequestInterface;

class Whitelist
{

    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config,
    ) {
        $this->config = $config;
    }

    public function shouldLog(
        RequestInterface $request
    ): bool {
        if (
            ($this->config->isDisableAjax() && $request->isXmlHttpRequest())
            || !$this->isWhitelistedMethod($request)
            || !$this->isWhitelistedUserAgent($request)
            || !$this->isWhitelistedURL($request)
            || !$this->isWhitelistedIP($request)
        ) {
            return false;
        }

        return true;
    }

    private function isWhitelistedIP($request)
    {
        // No values, means this check is disabled.
        if (!$this->config->getWhitelistedIPs()) {
            return true;
        }

        // Note: We are assuming the ingress proxy is cleansing / resetting the
        // X_FORWARDED_FOR header. Otherwise the Client IP could be spoofed.
        $ipSegments = explode(',', $request->getClientIp());
        $clientIp = array_slice($ipSegments, 0, 1);

        return in_array(
            $clientIp,
            $this->config->getWhitelistedIPs(),
            true
        );
    }

    private function isWhitelistedUrl($request)
    {
        foreach($this->config->getWhitelistedUrls() as $urlSegment) {
            if (str_contains($request->getUriString(), $urlSegment)) {
                return true;
            }
        }
        // Zero filter urls, means this check is disabled. So class it as whitelisted.
        return count($this->config->getWhitelistedUrls()) < 1;
    }

    private function isWhitelistedUserAgent($request)
    {
        // No values, means this check is disabled.
        if (!$this->config->getWhitelistedUserAgents()) {
            return true;
        }

        return in_array(
            $request->getHeader('User-Agent'),
            $this->config->getWhitelistedUserAgents(),
            true
        );
    }

    private function isWhitelistedMethod($request)
    {
        // No values, means this check is disabled.
        if (!$this->config->getWhitelistedMethods()) {
            return true;
        }

        return in_array(
            $request->getMethod(),
             $this->config->getWhitelistedMethods(),
             true
        );
    }

}