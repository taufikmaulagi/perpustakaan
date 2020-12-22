<?php

class CG_Model extends CI_Model {

	function get_all_table(){
		$args = [
			'except' => $this->input->get('except')
		];

		$res['tables'] = $this->db->query('show tables')->result_array();
		$data = array();
		foreach ($res['tables'] as $key => $value) {
			$tempData['table'] = $value['Tables_in_'.'elevens'];
			if(!empty($args['except'])){
				if($tempData['table'] == $args['except'])
					continue;
			}
			array_push($data, $tempData);
		}
		return $data;
	}

	function get_desc($table){
		$args = [
			'join' => $this->input->get('join')
		];

		$res['desc'] = $this->db->query('desc '.$table)->result_array();
		$data = [];
		foreach ($res['desc'] as $key => $value) {
			$tempData['field'] = $table.'.'.$value['Field'];
			$tempData['type'] = $value['Type'];
			$tempData['rules'] = explode('^', str_replace(['(',')',' '], '^', $tempData['type']));
			$tempData['input'] = 'text';
			$tempData['option'] = '';
			$tempData['key'] = $value['Key'];
			$tempData['null'] = $value['Null'];
			if(in_array($tempData['rules'][0], ['smallint','tinyint','mediumint','int','bigint'])){
				$tempData['input'] = 'number';
			} else if($tempData['rules'][0] != 'enum' && !empty($tempData['rules'][1]) && $tempData['rules'][1]>100){
				$tempData['input'] = 'textarea';
			} else if($tempData['rules'][0] == 'enum'){
				$tempEnum = str_replace(['enum'], '', $tempData['type']);
				$tempEnum = explode(',', str_replace(['(',')',' ','\''], '', $tempEnum));
				if(count($tempEnum)<=3){
					$tempData['input'] = 'radio';
					$tempData['option'] = json_encode($tempEnum);
				} else {
					$tempData['input'] = 'dropdown';
					$tempData['option'] = json_encode($tempEnum);
				}

			}
			array_push($data, $tempData);
		}

		if(!empty($args['join'])){
			$args['join'] = explode('|', $args['join']);
			if(count($args['join'])>0){
				foreach ($args['join'] as $value) {
					if(empty($value))
						continue;
					$res['desc'] = $this->db->query('desc '.$value)->result_array();
					foreach ($res['desc'] as $k_desc => $v_desc) {
						$tempData['field'] = $value.'.'.$v_desc['Field'];
						$tempData['type'] = $v_desc['Type'];
						array_push($data, $tempData);				
					}
				}
			}
		}

		return $data;
	}

}