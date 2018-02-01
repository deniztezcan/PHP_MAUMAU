<?php
/**
 * PHP_MAUMAU - A non-interactive PHP version of the game mau mau (pesten)
 *
 * @package 	PHP_MAUMAU
 * @author      Deniz Tezcan <howdy@deniztezcan.me>
 * @link        https://github.com/deniztezcan/PHP_MAUMAU
 */

include_once "Application.php";

$application = new Application();
$application->startGame();