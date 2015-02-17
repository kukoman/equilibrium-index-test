<?php
namespace EquilibriumTest\Service;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class EquilibriumServiceTest
 * @package EquilibriumTest\Service
 * @group equilibrium
 * @group service
 */
class EquilibriumServiceTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    /**
     * @var \Equilibrium\Service\Equilibrium
     */
    protected $service;

    public function setUp()
    {
        $this->setApplicationConfig(
            include APP_CONFIG_DIR . '/application.config.php'
        );
        parent::setUp();

        $this->service = $this->getApplicationServiceLocator()->get('Equilibrium');
    }

    /**
     * just some IMBA example
     *
     * @return array
     */
    public function validValues()
    {
        return [
            [[2, 1, 7, 3]],
            [['2', 1, '7', 3]]
        ];
    }

    /**
     * just some IMBA example
     *
     * @return array
     */
    public function invalidValues()
    {
        return [
            [[12, 3, 4]],
            [[12, 3, '4a']],
            [[12, 3, null, -1]],
            [[12, 3, -1]],
        ];
    }

    public function testServiceInstance()
    {
        $this->assertInstanceOf('Equilibrium\Service\Equilibrium',
            $this->service);
    }

    /**
     * @dataProvider invalidValues
     */
    public function testInvalidValues($value)
    {
        $result = $this->service->calculate($value);
        $this->assertInternalType('array', $result);
        $this->assertTrue(!$result, 'failed to calculate eq.');
    }

    public function testInvalidValuesWithException()
    {
        $this->setExpectedException('Exception');
        $this->service->setStrict(true);
        $this->service->calculate(['1', '2a']);
    }

    /**
     * @dataProvider validValues
     */
    public function testValidValues($value)
    {
        $result = $this->service->calculate($value);
        $this->assertInternalType('array', $result);
        $this->assertNotEmpty($result, 'failed to calculate eq.');
    }

    public function testStrictGetSet()
    {
        $this->service->setStrict(true);
        $this->assertSame(true, $this->service->getStrict());
        $this->service->setStrict(false);
        $this->assertSame(false, $this->service->getStrict());
    }

    /**
     * @group current
     */
    public function testTotallyUselessMock()
    {
        $eqMock = $this->getMockBuilder('Equilibrium\Service\Equilibrium')
            ->disableOriginalConstructor()
            ->setMethods(['getStrict'])
            ->getMock();

        $input = ['1', '2'];
        $eqMock->expects($this->atLeastOnce())
            ->method('getStrict')
            ->will($this->returnValue(false));

        $eqMock->calculate($input);
    }
}
