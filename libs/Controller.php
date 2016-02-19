<?php

class Controller
{
	private $model;
	private $data;
	private $log;

	public function __construct()
	{
		$this->model = new Model();
		$this->log = new Log();

		$this->log->info('Script start');
	}

	public function readFile($filepath)
	{
		try {
			$filereader = new FileReader($filepath);
			$rows = $filereader->read();

			$this->log->info('Read rows: ' . $rows);

			$this->data = $filereader->getSeoData();

			$this->log->info('Validated rows: ' . count($this->data));
		} catch (Exception $e) {
			$this->log->info('File read error');
			$this->log->info($e->getMessage());
			die();
		}
	}

	public function fillDataWithIdAndType()
	{
		$urls = $this->getUrlList();
		$additionalData = $this->model->getListByUrlList($urls);
		if (count($additionalData) < 1) {
			$this->log->info('No data in DB found for urls in file');
		}
		$additionalData = $this->groupBy($additionalData, 'keyword');

		foreach ($this->data as $key => $row) {
			if (isset($additionalData[$row['url']])) {
				$this->data[$key]['id'] = $this->parseId($additionalData[$row['url']]['query']);
				$this->data[$key]['type'] = $this->parseType($additionalData[$row['url']]['query']);
			} else {
				unset($this->data[$key]);
			}
		}
	}

	public function updateSeo()
	{
		$this->log->info('Rows found in db: ' . count($this->data));
		$x = 0;
		foreach ($this->data as $item) {
			if ($item['type'] == 'product') {
				if ($this->model->updateProduct($item)) {
					$x++;
				}
			} elseif ($item['type'] == 'category') {
				if ($this->model->updateCategory($item)) {
					$x++;
				}
			}
		}

		$this->log->info('Rows added: ' . $x);
	}

	private function getUrlList()
	{
		$urlList = [];
		foreach ($this->data as $key => $value) {
			array_push($urlList, $value['url']);
		}

		return $urlList;
	}

	private function groupBy($arr, $key)
	{
		$data = [];
		foreach ($arr as $value) {
			if (isset($value[$key])) {
				$data[$value[$key]] = $value;
			}
		}

		return $data;
	}

	private function parseId($str)
	{
		$arr = explode('=', $str);

		return isset($arr[1]) ? $arr[1] : null;
	}

	private function parseType($str)
	{
		if (strpos($str, 'product') !== false) {
			return 'product';
		} elseif (strpos($str, 'category') !== false) {
			return 'category';
		}

		return null;
	}
}