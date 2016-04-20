<?php 
/**
 * Short description :
 * The file permit to boot all system elements to construct the answer of the user call.
 * 
 * @copyright Copyright (c) 2015 BOUZID Serge
 * @author Serge BOUZID
 * @version 1.0
 */

// Load library system
require_once(PARAM_KERNEL_PATH_ROOT.'/library/Framework.php'); //Genesis system
require_once(PARAM_KERNEL_PATH_ROOT.'/library/FrameworkUse.php'); //Genesis system
require_once(PARAM_KERNEL_PATH_ROOT.'/library/Singleton.php'); //Genesis system
require_once(PARAM_KERNEL_PATH_ROOT.'/library/Data.php'); //Genesis system
require_once(PARAM_KERNEL_PATH_ROOT.'/library/ToolboxNameSpace.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/library/ToolboxRand.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/library/ToolboxString.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/library/SpliterPath.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/library/SpliterUrl.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/library/SpliterArg.php');

// Load kernel system
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/Kernel.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/ParamLoader.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/ComponentLoader.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/Route.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/RouteFactory.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/Service.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/ServiceFactory.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/SaveManager.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/ViewEngine.php');

// Load kernel handle
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/handle/FrameworkHandle.php');//Genesis system

// Load kernel extend
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/extend/FrameworkExtend.php'); //Genesis system
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/extend/ParamExtend.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/extend/Controller.php');
require_once(PARAM_KERNEL_PATH_ROOT.'/kernel/extend/Model.php');


 