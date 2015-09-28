<?php  
class StringFormat
{
	public static function formatTimestampt($outputFormat, $inputFormat)
	{
		$format = date($outputFormat, strtotime($inputFormat));
		return $format;
	}
}


?>