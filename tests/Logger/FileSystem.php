<?php 
namespace Test\Logger;


class FileSystem
{
	public static function read($file)
	{
		return file_get_contents($file);
	}

	public static function write($file, $data)
	{
		file_put_contents($file, $data);	
	}
}