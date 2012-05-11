<?php

require_once APPPATH . '../system/libraries/Pagination.php';

class MY_Pagination extends CI_Pagination
{

	var $full_tag_open  = '<div class="pagination"><ul>';
	var $full_tag_close = '</ul></div>';

	var $first_link      = '&lt;&lt;';
	var $first_tag_open  = '<li>';
	var $first_tag_close = '</li>';

	var $prev_link       = '&lt;';
	var $prev_tag_open   = '<li>';
	var $prev_tag_close  = '</li>';

	var $last_link       = '&gt;&gt;';
	var $last_tag_open   = '<li>';
	var $last_tag_close  = '</li>';

	var $next_link       = '&gt;';
	var $next_tag_open   = '<li>';
	var $next_tag_close  = '</li>';

	var $cur_tag_open    = '<li class="active"><a href="#">';
	var $cur_tag_close   = '</a></li>';

	var $num_tag_open    = '<li>';
	var $num_tag_close   = '</li>';

	var $num_links            = 5;
	var $page_query_string    = true;
	var $query_string_segment = 's';

	public function __construct($params = array())
	{
		parent::__construct($params);
	}

	public function create_links()
	{
		$str = parent::create_links();

		$str = str_replace('?&amp;', '?', $str);

		return $str;
	}
}

