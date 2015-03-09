<?php
namespace Equilibrium\Service;

use Equilibrium\Exception\UnexpectedValueException;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Class Equilibrium
 * @package Application\Service
 */
class Equilibrium extends AbstractPlugin implements EquilibriumServiceInterface
{
    protected $strict = false;

    /**
     * calculate equilibrium of given numbers
     *
     * @param array $numbers
     * @return array
     * @throws UnexpectedValueException
     */
    public function calculate(array $numbers)
    {
        $count       = count($numbers);
        $left        = 0;
        $right       = array_sum($numbers);
        $equilibrium = array();
        for ($i = 0; $i < $count; $i++) {
            $right -= $numbers[$i];

            $this->strictValidation($numbers, $i);

            if ($left == $right) {
                $equilibrium[] = $i;
            }
            $left += $numbers[$i];
        }

        return $equilibrium;
    }

    /**
     * if strict true calculation will throw exception
     * @param bool $bool
     */
    public function setStrict($bool = false)
    {
        $this->strict = $bool;
    }

    /**
     * @return bool
     */
    public function getStrict()
    {
        return $this->strict;
    }

    /**
     * checks if value is valid under strict conditions
     * @param $value
     * @throws UnexpectedValueException
     * @return bool
     */
    public function strictValidation($value)
    {
        if ($this->getStrict() && !is_numeric($value)) {
            throw new UnexpectedValueException('Wrong input value', 409);
        }

        return true;
    }
}
