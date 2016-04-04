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
require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";

log::add('sigfox', 'debug', 'Event : ' . init('data') . ' pour ' . init('id'));

if (init('api') != config::byKey('api') || config::byKey('api') == '') {
	connection::failed();
	echo 'Clef API non valide, vous n\'etes pas autorisé à effectuer cette action (jeeApi)';
	die();
}

$eqLogic = sigfox::byLogicalId(init('id'), 'sigfox');
if (!is_object($eqLogic)) {
	echo 'Id inconnu ' . init('id');
	die();
}

$cmd = sigfoxCmd::byEqLogicIdAndLogicalId($eqLogic->getId(),'data');
if (!is_object($cmd)) {
	echo 'Commande inconnue';
	die();
}

log::add('sigfox', 'debug', 'Event : ' . init('data') . ' pour ' . init('id'));

$eqLogic->setConfiguration('time', date('d/m/y H:i:s',init('time')));
$eqLogic->setConfiguration('rssi', init('rssi'));
$eqLogic->save();
$cmd->event(init('data'));
$cmd->setConfiguration('value',init('data'));
$cmd->save();

?>
