<?php

class Log
{
	public function info($msg)
	{
		echo date('Y-m-d H:i:s') . ' ' . $msg . "<br />";
	}
}