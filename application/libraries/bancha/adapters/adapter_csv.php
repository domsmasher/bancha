<?php
/**
 * CSV Adapter Class
 *
 * ...
 *
 * @package		Bancha
 * @author		Nicholas Valbusa - info@squallstar.it - @squallstar
 * @copyright	Copyright (c) 2011, Squallstar
 * @license		GNU/GPL (General Public License)
 * @link		http://squallstar.it
 *
 */

Class Adapter_csv implements Adapter
{
	/**
	 * @var array Defines all the accepted mimes of the adapter
	 */
	private $_mimes;

	public function __construct()
	{
		$this->mimes = array(
			'text/csv', 'text/comma-separated-values'	
		);
	}

	/**
	 * @var array Returns all the accepted mimes of the adapter
	 */
	public function get_mimes()
	{
		return $this->_mimes;
	}

	public function parse_stream($stream, $to_record = TRUE, $type = '')
	{
		$data = $this->_csv_to_array($stream);
		
		if (!$to_record)
		{
			return $data;
		} else {
			if (count($data))
			{
				$records = array();
				foreach ($data as $row)
				{
					$record = new Record($type);
					if ($type != '')
					{
						$record->set_data($row);
					} else {
						foreach ($row as $key => $val)
						{
							$record->set($key, $val);
						}
					}
					$records[]= $record;
				}
				return $records;
			}
		}
	}

	private function _csv_to_array($input, $delimiter=';') 
	{
	    $header = null; 
	    $data = array(); 
	    $csvData = str_getcsv($input, "\n"); 
	    
	    foreach($csvData as $csvLine){ 
	        if(is_null($header)) $header = explode($delimiter, $csvLine); 
	        else{ 
	            
	            $items = explode($delimiter, $csvLine); 
	            
	            for($n = 0, $m = count($header); $n < $m; $n++){ 
	            	if (isset($items[$n]))
	            	{
	                	$prepareData[$header[$n]] = $items[$n]; 
	            	}
	            } 
	            
	            $data[] = $prepareData; 
	        } 
	    } 
	    
	    return $data; 
	}
}