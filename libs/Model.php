<?php

class Model
{
	private $db;

	public function __construct()
	{
		$db = Db::getInstance();
 		$this->db = $db->getConnection();
	}

	public function getListByUrlList($urlList)
	{
		$urlList = array_map('prepareStr', $urlList);
		$keywordStr = implode(',', $urlList);
		$query = "SELECT * FROM url_alias WHERE keyword IN ($keywordStr)";
		$res = $this->db->prepare($query);

		$res->execute();

		return $res->fetchAll();
	}

	public function updateProduct($item)
	{
		/*$query = "UPDATE raskrutka 
			SET title = ?, description = ? 
			WHERE url = ?";
		$res = $this->db->prepare($query);
		
		$res->execute([
			$item['title'],
			$item['text'],
			$item['fullUrl']
		]);*/

		$query = "UPDATE product_description 
			SET name = ?, meta_description = ?,  description = ?
			WHERE product_id = ?";
		$res = $this->db->prepare($query);
		
		return $res->execute([
			$item['h1'],
			$item['description'],
			$item['text'],
			$item['id']
		]);
	}

	public function updateCategory($item)
	{
		$query = "UPDATE raskrutka 
			SET title = ?, description = ? 
			WHERE url = ?";
		$res = $this->db->prepare($query);
		
		$res->execute([
			$item['title'],
			$item['text'],
			$item['fullUrl']
		]);

		$query = "UPDATE category_description 
			SET name = ?, meta_description = ? 
			WHERE category_id = ?";
		$res = $this->db->prepare($query);
		
		return $res->execute([
			$item['h1'],
			$item['description'],
			$item['id']
		]);
	}
}