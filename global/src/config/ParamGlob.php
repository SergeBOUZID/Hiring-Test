<?php

/*
Objet permettant le chargement des parametres specifiques
*/
class ParamGlob extends \Framework\Kernel\Extend\ParamExtend
{
	//******************************************************************************
	//Methods
	//******************************************************************************
	
	//Methods setters
	//******************************************************************************
	public function run()
	{
		$this->setParam('/global/src/config/ParamGlob.yml');
	}
}