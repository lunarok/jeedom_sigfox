<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class sigfox extends eqLogic {

  public function preUpdate() {
    if ($this->getConfiguration('device') == '') {
      throw new Exception(__('L\'adresse ne peut être vide',__FILE__));
    }
  }

  public function preSave() {
    $this->setLogicalId($this->getConfiguration('device'));
  }


  public function postUpdate() {
    $cmd = sigfoxCmd::byEqLogicIdAndLogicalId($this->getId(),'data');
    if (!is_object($cmd)) {
      $cmd = new sigfoxCmd();
      $cmd->setLogicalId('data');
      $cmd->setIsVisible(1);
      $cmd->setName(__('Data', __FILE__));
    }
    $cmd->setType('info');
    $cmd->setSubType('string');
    $cmd->setEqLogic_id($this->getId());
    $cmd->save();
  }

}

class sigfoxCmd extends cmd {
  public function execute($_options = null) {


    switch ($this->getType()) {
      case 'info' :
      return $this->getConfiguration('value');
      break;
    }
    return true;
  }
}

?>
