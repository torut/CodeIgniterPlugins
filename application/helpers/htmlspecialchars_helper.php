<?php

if ( ! function_exists('hsc'))
{
	function hsc($str)
	{
		return htmlspecialchars($str);
	}
}
