<?php
namespace TJM\JsonPersist\Tests;
use PHPUnit_Framework_TestCase;
use TJM\JsonPersist\PersistanceManager;

require_once(__DIR__ . '/../vendor/autoload.php');

class Test extends PHPUnit_Framework_TestCase{
	protected $dataDir = __DIR__ . '/data';
	protected $manager;
	protected function setUp(){
		if(!is_dir($this->dataDir)){
			mkdir($this->dataDir);
		}
		$this->manager = new PersistanceManager($this->dataDir);
	}
	public function testFileCreation(){
		$path = $this->dataDir . '/test.json';
		if(file_exists($path)){
			unlink($path);
		}
		$this->manager->persistCollection('test');
		$this->assertTrue(file_exists($path), 'test.json should be created when persisting collection.');
	}
	public function testPersistData(){
		$path = $this->dataDir . '/test.json';
		if(file_exists($path)){
			unlink($path);
		}
		$collection = &$this->manager->getCollection('test');
		$collection[] = ['name'=> 'foo', 'password'=> 'bar'];
		$collection[] = ['name'=> 'biz', 'password'=> 'baz'];
		$this->manager->persistCollection('test');
		$this->assertEquals($collection, json_decode(file_get_contents($path), true), 'test.json should have data matching collection.');
	}
}
