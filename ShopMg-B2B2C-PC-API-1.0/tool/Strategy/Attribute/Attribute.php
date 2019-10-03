<?php
declare(strict_types = 1);

namespace Tool\Strategy\Attribute;

trait Attribute
{
	private $receive = [];
	
	private $freightData = 0;
	
	public function setReceive(array $receive) :void{
		$this->receive = $receive;
	}
	
	public function setFreightData($freightData) :void{
		
		$this->freightData = $freightData;
	}
	
}