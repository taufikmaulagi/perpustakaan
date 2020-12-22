<?php

require APPPATH.'libraries/Elevens.php';

class Assistant extends Elevens {

    function __construct(){
		parent::__construct();
		$this->load->model('CG_Model','cgm');
	}

	function index(){

		$data['tables'] = $this->cgm->get_all_table();
		$data['table_active'] = $this->input->get('table');
		if(empty($data['table_active'])){
			$data['table_active'] = $data['tables'][0]['table'];
		}
		$data['title'] = 'Simple GENERATOR TABLE '.$data['table_active'];
		$data['content'] = 'cg';
		$data['breadcrumbs'] = [
			['CRUD GENERATOR', '#'],
			[strtoupper($data['table_active']), '#']
		];
		$data['template'] = [
			'select2'
		];
		$this->template($data);
	}

	function get_desc($table){

		$data['desc'] = $this->cgm->get_desc($table);
		echo json_encode($data['desc']);

	}

	function get_all_table(){

		$data['table'] = $this->cgm->get_all_table();
		echo json_encode($data['table']);

	}

}