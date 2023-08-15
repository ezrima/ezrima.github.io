<?php
class AboutUs extends Trongate {


	function index()
	{
		$data['view_module'] = 'AboutUs';
		$data['view_file'] = 'intro';
		$this->template('public', $data);
	}
}