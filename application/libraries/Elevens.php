<?php

class Elevens extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('elevens_model','el');
    }

    public function template($data, $template='template'){
        $active_uri = explode('/',$this->uri->segment(1))[0];
        if(empty($data['title']))
            $data['title'] = 'Title Belum Diatur';
        $data['sidemenu'] = $this->el->get_sidemenu();
        $data['breadcrumbs'] = $this->el->get_detail_submenu($active_uri);
        if(empty($data['template']))
            $data['template'] = array();
        if(empty($data['content']))
            $data['content'] = 'errors/no_view';
        $data['tahun_ajaran']   = $this->el->get_tahun_ajaran();
        $this->__init_tahun_ajaran();
        $this->load->view($template.'/head', $data);
        $this->load->view($template.'/nav');
        $this->load->view($template.'/side');
        $this->load->view($template.'/foot');
    }

    public function model($model, $alias){
        $this->load->model($model, $alias);
    }

    public function helper($helper){
        $this->load->helper($helper);
    }

    public function post($args){
        $this->input->post($args);
    }

    public function get($args){
        $this->input->get($args);
    }

    private function __init_tahun_ajaran(){
        if(empty($this->session->userdata('tahun_ajaran_aktif'))){
            $res['tahun_ajaran'] = $this->el->get_tahun_ajaran(['aktif' => 'Y']);
            $this->session->set_userdata(
                [
                    'tahun_ajaran_aktif'    => $res['tahun_ajaran'][0]['nama'],
                    'tahun_ajaran_aktif_id' => $res['tahun_ajaran'][0]['id']
                ]
            );
        }
    }

}