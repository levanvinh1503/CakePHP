<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\I18n\Time;

/**
 * FunctionLb component
 */
class FunctionLbComponent extends Component
{
	/**
	 * Get the current time and format datetime
	 * 
	 * @return string
	 */
    public function getCurrentTime()
    {
    	//Get the current time
        $dateNow = Time::now();
        //Format time
        return $dateNow->i18nFormat(DATE_TIME);
    }

    /**
     * Converts characters to HTML entities
     * 
     * @param  string $stringInput
     * @param  string $destinationEncoding
     * 
     * @return string
     */
    public function convertEntity($stringInput, $destinationEncoding = 'UTF-8')
    {
    	//Converts characters to HTML entities
    	$stringEntity = htmlentities($stringInput, ENT_COMPAT, $destinationEncoding);

    	return htmlentities($stringEntity, ENT_COMPAT, $destinationEncoding);
    }
}
