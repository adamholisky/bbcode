<?php

/**
 * Parse BBCode. General steps:
 *   1. Create an instance of this class
 *   2. Add some rules
 *   3. Parse some text
 *   
 * Will only parse code in the form of: [tag param="data" param="data" ... ]
 *  
 * See examples on github or misplacednerd.com
 * 
 * @author Adam Holisky, adam@holisky.com
 * @version 1.0
 * 
 */
class BBCodeParser
{
	private $arrRules;

	function __construct( )
	{
		$arrRules = array();
	}

	/**
	 * Adds a rule to parse
	 *
	 * @param string $rule Name of the rule, as it will appear in text
	 * @param function $callback Name of the function to execute upon processing
	 */
	public function addRule( $rule )
	{
		$this->arrRules[ $rule->getRule() ] = $rule;
	}

	/**
	 * Parses $string's bbcode according to the rules previously entered.
	 *
	 * @param string $string The string to parse
	 * @return string The parsted string
	 */
	public function parse( $string )
	{
		$parsedString = $string;

		foreach( $this->arrRules as $ruleText => $rule )
		{
			$numHits = preg_match_all( "#\[".$ruleText."(.*?)\]#s", $string, $out );

			if( $numHits > 0 )
			{
				$x = 0;

				foreach( $out[1] as $match )
				{
					$numParams = preg_match_all('#\s*([^=]+)="([^"]*)"#', $match, $paramsRaw);
					$params = array_combine( $paramsRaw[1], $paramsRaw[2] );
					$replacementString = $rule->parse( $params );
						
					$parsedString = str_replace( $out[0][$x], $replacementString, $parsedString );
						
					$x++;
				}
			}
			else
			{
				// Code not found
			}
		}

		return $parsedString;
	}
}