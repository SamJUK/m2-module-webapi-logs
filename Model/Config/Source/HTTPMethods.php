<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\WebapiLogs\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class HTTPMethods implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => 'GET',
                'value' => 'get'
            ],
            [
                'label' => 'POST',
                'value' => 'post'
            ],
            [
                'label' => 'PUT',
                'value' => 'put'
            ],
            [
                'label' => 'DELETE',
                'value' => 'delete'
            ],
            [
                'label' => 'PATCH',
                'value' => 'patch'
            ]
        ];
    }
}
