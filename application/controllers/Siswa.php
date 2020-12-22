<?php

require APPPATH.'libraries/Elevens.php';

class Siswa extends Elevens {

    function __construct(){
        parent::__construct();
        // $this->model('siswa_model','siswa_m');
    }

    function index(){
        $data['title'] = 'Siswa';
        $data['content'] = 'siswa/index';
        $data['template'] = ['datatables'];
        $this->template($data);
    }

    function tambah(){
        $data['title'] = 'Tambah Siswa';
        $data['content'] = 'siswa/add';
        $data['template'] = ['datatables'];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nis','Nama','required');
        if($this->form_validation->run()){
            echo 'Hai';
        }
        $this->template($data);
    }

}