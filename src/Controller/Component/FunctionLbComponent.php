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

    /**
     * Burn data to csv file
     * 
     * @param  array $arrayData
     * 
     * @return void
     */
    public function writeCsv($arrayData)
    {
        ini_set('max_execution_time', 600);
        //create a file
        $fileName = "export_".date("Y.m.d_h.m.s").".csv";
        //open a file
        $csvWrite = fopen(''.WWW_ROOT.'export.csv', 'w');
        //Column headings
        $headerRow = ["ID", "Name", "Email", "Address"];
        fputcsv($csvWrite, $headerRow, ',');

        //Loop to create CSV file rows
        foreach ($arrayData as $keyData => $itemData)
        {
            //Array indexes correspond to the field names in your db table(s)
            $lineItem = [trim($itemData['id']), trim($itemData['name']), trim($itemData['email']), trim($itemData['address'])];
            fputcsv($csvWrite, $lineItem);
        }
        //close a file
        fclose($csvWrite);
        $csvRead = fopen(''.WWW_ROOT.'export.csv', 'r');

        file_put_contents($fileName, $csvRead);
        //save file
        header("Content-disposition: attachment; filename=".$fileName."");
        header("Content-type: application/csv");
        readfile($fileName);
    }

    /**
     * Check vaidate maxlenght 
     * 
     * @param  object $connectDb
     * @param  string $tableDb
     * @param  string $maxLenght
     * @param  string $columnTable
     * 
     * @return string
     */
    public function validateLenght($connectDb, $tableDb, $maxLenght, $columnTable)
    {
        $messageValidate = "";
        //Query
        $queryDb = $connectDb->execute("SELECT  `" . $columnTable . "`, `index` FROM `" . $tableDb . "` WHERE CHAR_LENGTH(`" . $columnTable . "`) > " . $maxLenght . " ORDER BY `" . $columnTable . "` ASC");
        //Array result
        $resultData = $queryDb->fetchAll('assoc');
        if (!empty($resultData)) {
            foreach ($resultData as $keyErr => $valueErr) {
                $messageValidate .= "Line: " . $valueErr['index'] . " " . ucfirst($columnTable) ." (" . $valueErr[$columnTable] . ") Chiều dài ký tự > " . $maxLenght . ", yêu cầu <= " . $maxLenght . " ký tự <br/>";
            }
        }

        return $messageValidate;
    }

    /**
     * Check vaidate duplicate data 
     * 
     * @param  object $connectDb
     * @param  string $tableDb
     * @param  string $columnTable
     * 
     * @return string
     */
    public function validateDuplicate($connectDb, $tableDb, $columnTable)
    {
        $messageValidate = "";
        //Query
        $queryDb = $connectDb->execute("SELECT `index`, `" . $columnTable . "` FROM " . $tableDb . " GROUP BY `" . $columnTable . "` HAVING COUNT(`" . $columnTable . "`) > 1 ORDER BY `index` ASC");
        //Array result
        $resultData = $queryDb->fetchAll('assoc');
        if (!empty($resultData)) {
            foreach ($resultData as $keyErr => $valueErr) {
                $messageValidate .= "Line: " . $valueErr['index'] . " " . ucfirst($columnTable) . " (" . $valueErr[$columnTable] . ") đã trùng <br/>";
            }
        }

        return $messageValidate;
    }

    /**
     * Check vaidate number 
     * 
     * @param  object $connectDb
     * @param  string $tableDb
     * @param  string $columnTable
     * 
     * @return string
     */
    public function validateNumeric($connectDb, $tableDb, $columnTable)
    {
        $messageValidate = "";
        //Query
        $queryDb = $connectDb->execute("SELECT `" . $columnTable . "`, `index` FROM `" . $tableDb . "` WHERE NOT CONCAT('', `" . $columnTable . "` * 1) = `" . $columnTable . "` ORDER BY `index` ASC");
        //Array result
        $resultData = $queryDb->fetchAll('assoc');
        if (!empty($resultData)) {
            foreach ($resultData as $keyErr => $valueErr) {
                $messageValidate .= "Line: " . $valueErr['index'] . " " . ucfirst($columnTable) . " (" . $valueErr[$columnTable] . ") phải là kí tự số<br/>";
            }
        }

        return $messageValidate;
    }

    /**
     * Check vaidate format email 
     * 
     * @param  object $connectDb
     * @param  string $tableDb
     * @param  string $columnTable
     * 
     * @return string
     */
    public function validateEmail($connectDb, $tableDb, $columnTable)
    {
        $messageValidate = "";
        //Query
        $queryDb = $connectDb->execute("SELECT  `" . $columnTable . "`, `index` FROM `" . $tableDb . "` WHERE NOT `" . $columnTable . "` LIKE '%_@__%.__%' ORDER BY `index` ASC");
        //Array result
        $resultData = $queryDb->fetchAll('assoc');
        if (!empty($resultData)) {
            foreach ($resultData as $keyErr => $valueErr) {
                $messageValidate .= "Line: " . $valueErr['index'] . " " . ucfirst($columnTable) . " (" . $valueErr[$columnTable] . ") không đúng format email <br/>";
            }
        }
        return $messageValidate;
    }
}
