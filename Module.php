<?php
/**
 * Project: documents
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 17.12.15.
 */

namespace zantonijevic\documents;


/**
 * Module
 **/
class Module extends \yii\base\Module {
	public $controllerNamespace = 'backend\modules\controllers';
	public $defaultRoute = 'document';

	public function init() {
		parent::init();

		// custom initialization code goes here
	}
}