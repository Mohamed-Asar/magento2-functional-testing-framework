<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\AcceptanceTestFramework\ObjectManager;

use Magento\AcceptanceTestFramework\ObjectManager\Config\Config as ObjectManagerConfig;

/**
 * Class Config
 * Filesystem configuration loader. Loads configuration from XML files, split by scopes
 *
 * @internal
 */
class Config extends ObjectManagerConfig
{
    /**
     * Class reflections.
     *
     * @var \ReflectionClass[]
     */
    protected $nonSharedRefClasses = [];

    /**
     * Check whether type is shared
     *
     * @param string $type
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function isShared($type)
    {
        if (isset($this->nonShared[$type])) {
            return false;
        }

        if (isset($this->virtualTypes[$type])) {
            return true;
        }

        if (!isset($this->nonSharedRefClasses[$type])) {
            $this->nonSharedRefClasses[$type] = new \ReflectionClass($type);
        }
        foreach ($this->nonShared as $noneShared => $flag) {
            if ($this->nonSharedRefClasses[$type]->isSubclassOf($noneShared)) {
                return false;
            }
        }

        return true;
    }
}
