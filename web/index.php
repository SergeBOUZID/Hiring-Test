<?php
/**
 * Short description :
 * The only page where is return by user call.
 * 
 * Long description :
 * This page must be the only entrance for user call.
 * All elements are include to construct the answer of the user.
 * This mechanism is coupled with the url rewriting.
 *
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

// Start session
session_start();

// Global define
define('PARAM_KERNEL_PATH_ROOT', dirname(dirname(__FILE__)));
define('PARAM_KERNEL_PATH_PARAM', 'global/config/Param.yml');

// Set boot
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/Bootstrap.php');

// Get Kernel
$Kernel = \Framework\Kernel\Kernel::getInstance();

// Launch process
$Kernel->run();
 