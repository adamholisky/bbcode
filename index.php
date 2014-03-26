<?php
include "BBCode.php";

class BBCodeCat extends BBCodeRule
{
	protected function formatOutput()
	{
		$claws = $this->get("claws") == "yes" ? "with claws" : "without claws";
		return $this->get("name")." is a ".$this->get("color")." ".$this->get("type")." ".$claws.".";
	}
	
	function __construct()
	{
		$this->setRule( "cat" );
	}
}

class BBCodeDog extends BBCodeRule
{
	protected function formatOutput()
	{
		return $this->get("name")." is a ".$this->get("color")." ".$this->get("type")." who is ".$this->get("behavior").".";
	}

	function __construct()
	{
		$this->setRule( "dog" );
	}
}

$theString = <<<EOF
[cat name="Max" type="Russian Blue" color="gray" claws="yes"]<br />
[cat name="Nala" type="Domestic Shorthair" color="white" claws="no"]<br />
[dog name="Rupert" type="Mut" color="brown/black" behavior="mostly good"]<br />
EOF;

$code = new BBCodeParser();

$code->addRule( new BBCodeCat() );
$code->addRule( new BBCodeDog() );

echo $code->parse( $theString );