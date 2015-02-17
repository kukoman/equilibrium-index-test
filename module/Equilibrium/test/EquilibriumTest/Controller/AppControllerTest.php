<?php
namespace EquilibriumTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class AppControllerTest
 * @package EquilibriumTest\Controller
 * @group equilibrium
 * @group controller
 */
class AppControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
            include '/var/www/zf2test/config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/equilibrium-index/2,1,7,3');
        $this->assertResponseStatusCode(200);
//
        $this->assertModuleName('Equilibrium');
        $this->assertControllerName('Equilibrium\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('equilibrium');
    }

    public function testStrictCorrect()
    {
        $this->dispatch('/equilibrium-index/2,1,7,3/strict');
        $this->assertResponseStatusCode(200);
    }

    public function testStrictRoute409()
    {
        $this->dispatch('/equilibrium-index/2,1,7,3a/strict');
        $this->assertResponseStatusCode(409);
    }

    public function testNotStrictRouteWrongParams()
    {
        $this->dispatch('/equilibrium-index/2,1,7,3a');
        $this->assertResponseStatusCode(200);
    }
}
