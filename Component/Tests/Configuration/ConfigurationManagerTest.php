<?php

namespace Gravity\Component\Tests\Configuration;

use Gravity\Component\Configuration\ConfigurationManager;

/**
 * Class ConfigurationManagerTest
 *
 * @package Gravity\Component\Tests\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigurationManagerTest extends \PHPUnit_Framework_TestCase
{
    protected function getEntityManager()
    {
        return $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods([
                'getRepository'
            ])
            ->getMock();
    }

    protected function getEntityRepository()
    {
         return $this->getMockBuilder('\Doctrine\ORM\EntityRespository')
            ->disableOriginalConstructor()
            ->setMethods([
                'find',
                'findBy'
            ])
            ->getMock();
    }

    protected function getFormFactory()
    {
        return $this->getMockBuilder('\Symfony\Component\Form\FormFactoryInterface')
            ->getMock();
    }

    public function testConstruction()
    {
        $mockEntityManager = $this->getEntityManager();
        $mockRepository = $this->getEntityRepository();

        $mockEntityManager->expects($this->once())
            ->method('getRepository')
            ->with('GravityCoreBundle:Config')
            ->will($this->returnValue($mockRepository));

        $mockFormFactory = $this->getFormFactory();

        $configManager = new ConfigurationManager($mockEntityManager, $mockFormFactory);
    }

    public function testSetNewSuccess()
    {
        $mockEntityManager = $this->getEntityManager();
        $mockRepository = $this->getEntityRepository();

        $mockEntityManager->expects($this->once())
            ->method('getRepository')
            ->with('GravityCoreBundle:Config')
            ->will($this->returnValue($mockRepository));

        $mockFormFactory = $this->getFormFactory();

        $configManager = new ConfigurationManager($mockEntityManager, $mockFormFactory);

        $newConfiguration = $this->getMock('\Gravity\Component\Configuration\ConfigurationInterface');

//        $configManager->set()
//        TODO: finish this off
    }
}
