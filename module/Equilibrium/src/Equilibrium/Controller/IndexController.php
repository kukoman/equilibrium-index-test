<?php
namespace Equilibrium\Controller;

use Equilibrium\Exception\UnexpectedValueException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        // actually there is a much better solution to this whole problem
        // but I think the purpose of this test was to test different behaviours
        // see module.config.php:29
        if ($this->params()->fromRoute('mode')) {
            $this->equilibrium()->setStrict(true);
        }

        $result = [];
        try {
            // try to calculate equilibrium
            // split comma separated values
            $values = explode(',', $this->params()->fromRoute('values'));

            // using plugin
            $result = $this->equilibrium()->calculate($values);
        } catch (UnexpectedValueException $e) {
            $this->getResponse()->setStatusCode(409);
        }

        return new ViewModel([
            'equilibrium' => $result,
        ]);
    }
}
