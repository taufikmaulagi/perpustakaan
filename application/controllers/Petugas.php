<?php
require APPPATH.'libraries/Elevens.php';

class Petugas extends Elevens {

    function __construct(){
        parent::__construct();
        $this->load->model('m_petugas');
        $this->load->library(array('form_validation'));
    }

    function index(){
        $data['title']="Data Petugas";
        $data['petugas']=$this->m_petugas->semua()->result_array();
        if($this->uri->segment(3)=="delete_success")
            $this->session->set_flashdata(['message' => 'Data Berhasil Dihapus']);
        else if($this->uri->segment(3)=="add_success")
            $this->session->set_flashdata(['message' => 'Data Berhasil Disimpan']);
        else
            $data['message']='';
        $data['content'] = 'dashboard/petugas';
        $data['template'] = ['datatables'];
        $this->Template($data);
    }
    
    function add(){
        $data['title']="Tambah Petugas";
        $data['content'] = 'dashboard/tambahpetugas';
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $user=$this->input->post('user');
            $cek=$this->m_petugas->cekKode($user);
            if($cek->num_rows()>0){
                $this->session->set_flashdata(['message' => 'username tidak tersedia']);
                $this->Template($data);
            }else{
                $info=array(
                    'user'=>$this->input->post('user'),
                    'password'=>md5($this->input->post('password'))
                );
                $this->m_petugas->simpan($info);
                redirect(base_url('petugas'));
            }
        }else{
            $data['message']="";
            $this->Template($data);
        }
    }
    
    function edit($id){
        $data['title']="Update data Petugas";
        $data['content'] = 'dashboard/editpetugas';
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $info=array(
                'user'=>$this->input->post('user'),
                'password'=>md5($this->input->post('password'))
            );
            $this->m_petugas->update($id,$info);
            $data['petugas']=$this->m_petugas->cekId($id)->row_array();
            $this->session->set_flashdata(['message' => 'Data Berhasil Diupdate']);
            $this->Template($data);
        }else{
            $data['message']="";
            $data['petugas']=$this->m_petugas->cekId($id)->row_array();
            $this->Template($data);
        }
    }
    
    function delete($id){
        $kode=$id;
        $this->m_petugas->hapus($kode);
        redirect('petugas');
    }
    
    function _set_rules(){
        $this->form_validation->set_rules('user','username','required|trim');
        $this->form_validation->set_rules('password','password','required|trim');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
    }
    
}