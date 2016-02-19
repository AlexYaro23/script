<?php

class FileReader
{
	private $filepath;
	private $data = [];

	public function __construct($filepath)
	{
		if (!file_exists($filepath)) {
			throw new Exception($filepath . " doesn't exists", 1);
			
		}

		$this->filepath = $filepath;
	}

	public function read()
	{
		$this->data = file($this->filepath);

		return count($this->data);
	}

	public function getSeoData()
	{
		$seoData = [];
		foreach ($this->data as $key => $row) {
			$data = str_getcsv($row);
			$item = [
				'url' => $this->getLastUrlSegment($data[0]),
				'fullUrl' => $this->getRelativeUrl($data[0]),
				'title' => $data[1],
				'h1' => $data[2],
				'description' => $data[3],
				'text' => $data[4]	
			];
			if ($this->validateItem($item)) {
				array_push($seoData, $item);
			}
		}

		return $seoData;
	}

	private function getLastUrlSegment($url)
	{
		$arr = explode('/', rtrim($url, '/'));
		return end($arr);
	}

	private function getRelativeUrl($url)
	{
		return str_replace('http://техника.od.ua/', '', $url);
	}

	private function validateItem($item)
	{
		if (
			empty($item['url']) ||
			empty($item['title']) || 
			empty($item['h1']) ||
			empty($item['description']) ||
			empty($item['text'])
		) {
			return false;
		}

		return true;
	}
}