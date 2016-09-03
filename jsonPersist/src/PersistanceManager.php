<?php
namespace TJM\JsonPersist;

class PersistanceManager{
	protected $collections = [];
	protected $dir;
	public function __construct($dir){
		$this->dir = $dir;
	}
	public function &getCollection($name){
		return $this->getCollectionReference($name);
	}
	protected function getCollectionPath($name){
		return $this->dir . '/' . $name . '.json';
	}
	protected function &getCollectionReference($name){
		if(!isset($this->collections[$name])){
			$filePath = $this->getCollectionPath($name);
			if(file_exists($filePath)){
				$this->collections[$name] = json_decode(file_get_contents($filePath), true);
			}else{
				$this->collections[$name] = [];
			}
		}
		return $this->collections[$name];
	}
	public function persistCollection($name){
		$collection = $this->getCollectionReference($name);
		return file_put_contents($this->getCollectionPath($name), json_encode($collection));
	}
}
