<?php
namespace Equilibrium\Service;

use Equilibrium\Exception\UnexpectedValueException;

interface EquilibriumServiceInterface
{
    /**
     * calculates the result from given input numbers
     * @param array $numbers
     * @return mixed
     * @throws UnexpectedValueException
     */
    public function calculate(array $numbers);
}
