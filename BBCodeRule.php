<?php

/**
 * Create a rule for parsing BBCode.
 * 
 * See examples on github or misplacednerd.com
 * 
 * @author Adam Holisky, adam.holisky@gmail.com
 * @version 1.0
 *
 */
abstract class BBCodeRule
{
	private $ruleText = "";
	private $varArr = array();
	
	/**
	 * Called when the output needs to be formatted. Access parameters through $this->get( $var ). MUST be overridden by the final class.
	 * 
	 * @return String of parsed output.
	 */
	abstract protected function formatOutput();

	/**
	 * Called when the code shoudl parse a rule given the $params
	 * 
	 * @param array $params Kev=>Value pair array of all parameters
	 * @return string Parsed string without any BBCode.
	 */
	public function parse( &$params )
	{
		foreach( $params as $key => $value )
		{
			$this->set( $key, $value );
		}

		return $this->formatOutput();
	}
	
	/**
	 * Sets the name of the rule, as it will appear in the text to be parsed. IE: "[animal type='dog']" should have the $rule name of "animal".
	 * 
	 * @param string $rule The text name of the rule, as it appears in text to be parsed.
	 */
	public function setRule( $rule )
	{
		$this->ruleText = $rule;
	}
	
	/**
	 * Returns the name of the rule, as it will appear in the text to be paresed.
	 */
	public function getRule()
	{
		return $this->ruleText;
	}

	/**
	 * Returns a variable (parameter) of the imported BBCode. 
	 * 
	 * @param string $var The name of the variable, as it appears in the text to be parsed.
	 * @return string Empty string if $var not found, otherwise value of $var
	 */
	public function get( $var )
	{
		if( isset($this->varArr[$var]) )
		{
			return $this->varArr[$var];
		}
		else
		{
			return "";
		}
	}
	
	/**
	 * Sets a variable (parameter) to be accessed later.
	 * 
	 * @param string $var The variable's name
	 * @param string $val The varialbe's value
	 */
	public function set( $var, $val )
	{
		$this->varArr[$var] = $val;
	}
}