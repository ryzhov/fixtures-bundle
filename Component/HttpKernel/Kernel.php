<?php

/**
 * @author Aleksandr N. Ryzhov <a.n.ryzhov@gmail.com>
 */

namespace Ryzhov\Bundle\FixturesBundle\Component\HttpKernel;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;

abstract class Kernel extends BaseKernel
{
    /**
     * @param string $class     Full class name
     * @return boolean|string   Bundle name or false if class out of the kernel bundles
     */
    public function getBundleNameForClass($class)
    {
        foreach ($this->getBundles() as $bundle) {
            if (0 === strpos($class, $bundle->getNamespace())) {
                return $bundle->getName();
            }
        }

        return false;
    }
}
