<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Plugin;

use GhostUnicorns\WebapiLogs\Model\Config;
use GhostUnicorns\WebapiLogs\Model\LogHandle;
use GhostUnicorns\WebapiLogs\Model\Whitelist;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Webapi\Controller\Rest;

class FrontControllerDispatchBefore
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var LogHandle
     */
    private $logHandle;

    /**
     * @var Whitelist
     */
    private $whitelist;

    /**
     * @param Config $config
     * @param DateTime $date
     * @param LogHandle $logHandle
     * @param Whitelist $whitelist
     */
    public function __construct(
        Config $config,
        DateTime $date,
        LogHandle $logHandle,
        Whitelist $whitelist
    ) {
        $this->config = $config;
        $this->date = $date;
        $this->logHandle = $logHandle;
        $this->whitelist = $whitelist;
    }

    /**
     * @param Rest $subject
     * @param RequestInterface $request
     * @return array
     */
    public function beforeDispatch(Rest $subject, RequestInterface $request)
    {
        if ($this->config->isEnabled() && $this->whitelist->shouldLog($request)) {
            $requestMethod = $request->getMethod();
            $requestorIp = $request->getClientIp();
            $requestorUseragent = $request->getHeader('User-Agent');
            $requestPath = $request->getUriString();
            $requestHeaders = $request->getHeaders()->toString();
            $requestBody = $request->getContent();
            $requestDateTime = $this->date->gmtDate();

            $this->logHandle->before(
                $requestMethod,
                $requestorIp,
                $requestorUseragent,
                $requestPath,
                $requestHeaders,
                $requestBody,
                $requestDateTime
            );
        }
        return [$request];
    }
}
