<?php

namespace Ryzhov\Bundle\FixturesBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ryzhov\Bundle\FixturesBundle\Service\FixturesSource;

abstract class LoadData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var FixturesSource
     */
    protected $fixturesSource;
    
    /**
     * @param FixturesSource $fixturesSource
     * @return self
     */
    public function __construct(FixturesSource $fixturesSource)
    {
        $this->fixturesSource = $fixturesSource;
        return $this;
    }
}