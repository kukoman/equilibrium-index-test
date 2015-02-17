<?php
namespace Equilibrium\Service;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Class Equilibrium
 * @package Application\Service
 */
class Equilibrium extends AbstractPlugin
{
    protected $strict = false;

    /**
     * calculate equilibrium of given numbers
     *
     * @param array $numbers
     * @return array
     * @throws \Exception
     */
    public function calculate(array $numbers)
    {
        $count       = count($numbers);
        $left        = 0;
        $right       = array_sum($numbers);
        $equilibrium = array();
        for ($i = 0; $i < $count; $i++) {
            $right -= $numbers[$i];

            if($this->getStrict() && !is_numeric($numbers[$i])) {
                throw new \Exception('Wrong input argument', 409);
            }

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
}
