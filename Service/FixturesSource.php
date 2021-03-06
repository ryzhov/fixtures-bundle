<?php

namespace Ryzhov\Bundle\FixturesBundle\Service;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpKernel\Kernel;

class FixturesSource
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var CsvTransformer
     */
    private $transformer;

    /**
     * @param Kernel $kernel
     * @param CsvTransformer $transformer
     */
    public function __construct(Kernel $kernel, CsvTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->kernel = $kernel;
    }

    /**
     * @param string $class
     * @return string|boolean   False if bundle not found, bundle name otherwise
     */
    protected function getBundleNameForClass($class)
    {
        foreach ($this->kernel->getBundles() as $bundle) {
            if (0 === strpos($class, $bundle->getNamespace())) {
                return $bundle->getName();
            }
        }

        return false;
    }

    /**
     * @param string $class     Full class name
     * @param string $format    Fixtures file format i.e. extension
     * @return array            Array of fixtures
     * @throws \RuntimeException
     */
    public function getFixtureForModel($class, $format ='csv')
    {
        $resource = $this->kernel->locateResource(sprintf('@%s/Resources/fixtures/%s',
            $this->getBundleNameForClass($class),
            $this->transformEntityClassToFixturesFile($class, $format)
        ));
        
        if ('yml' === $format) {
            $fixtures = Yaml::parse(file_get_contents($resource));
        } elseif ('csv' === $format) {
            $fixtures = $this->transformer->process($resource);
        } else {
            throw new \RuntimeException(sprintf('unexpected: "%s" fixtures format', $format));
        }
        
        return $fixtures;
    }
    
    /**
     * @param string $class     Full class name
     * @param string $format    Fixtures file format i.e. extension
     * @return string
     */
    private function transformEntityClassToFixturesFile($class, $format)
    {
        return str_replace('\\', '__', strtolower($class)) . '.' . $format;
    }
}