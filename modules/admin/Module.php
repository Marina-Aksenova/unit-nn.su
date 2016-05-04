<?php

namespace app\modules\admin;

use Yii;

class Module extends \yii\base\Module
{

	public function init()
	{
		parent::init();

		$this->layout = 'main';
	}

}