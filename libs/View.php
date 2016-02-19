<?php

class View
{
	public function header()
	{
		echo "<!DOCTYPE html>
				<html lang='en'>
  				<head>
    				<meta charset='utf-8'>
    
  				</head>
  				<body>
    				<h1>Add SEO stuff</h1>
		";
	}

	public function footer()
	{
		echo "</body></html>";
	}

	public function form()
	{
		echo '<form method="post" enctype="multipart/form-data">
    				Select file to upload:
    				<input type="file" name="file">
    				<input type="submit" value="Upload" name="submit">
			  </form>';
	}

	public function back()
	{
		echo '<div><a href="' . $_SERVER['REQUEST_URI'] . '">Go back</a></div>';
	}
}