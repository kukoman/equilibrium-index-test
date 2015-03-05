<?php
namespace Equilibrium\Service;

interface EquilibriumServiceInterface
{
    /**
     * calculates the result from given input numbers
     * @param array $numbers
     * @return mixed
     */
    public function calculate(array $numbers);
}
