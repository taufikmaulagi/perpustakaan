<?php
require APPPATH.'libraries/Elevens.php';

class Buku extends Elevens {
    private $limit=20;
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('form_validation','upload'));
        $this->load->model('m_buku');
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
     
    function index(){
        $data['title']      = "Data Master Buku";
        $data['content']    = 'buku/index';
        $data['template']   = ['datatables'];
        $data['buku']=$this->m_buku->get()->result_array();
        if($this->uri->segment(3)=="delete_success")
            $this->session->set_flashdata(['message' => 'Buku Berhasil Dihapus']);
        else if($this->uri->segment(3)=="add_success")
            $this->session->set_flashdata(['message' => 'Buku Berhasil Disimpan']);
        else
            $data['message']='';
        $this->template($data);
    }
    
    
    function add(){
        $data['title']      = "Tambah Buku Baru";
        $data['content']    = 'buku/add';
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $kode=$this->input->post('kode'); 
            $cek=$this->m_buku->cek($kode); 
            if($cek->num_rows()>0){ 
                $this->session->set_flashdata(['message' => 'Kode Buku Sudah Ada']);
                $this->Template('buku/add',$data);
            } else { 
                $config['upload_path']      = './assets/image/';
                $config['allowed_types']    = 'gif|jpg|png';
                $config['max_size']	        = '1000';
                $config['max_width']        = '2000';
                $config['max_height']       = '1024';
                
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('gambar')){
                    $gambar = "default.png";
                }else{
                    $gambar = $this->upload->file_name;
                }
                
                $info=array(
                    'kode_buku'     => $this->input->post('kode'),
                    'judul'         => $this->input->post('judul'),
                    'pengarang'     => $this->input->post('pengarang'),
                    'klasifikasi'   => $this->input->post('klasifikasi'),
                );
                if(!empty($gambar)){
                    $info['image'] = $gambar;
                }
                $this->m_buku->add($info);
                redirect('buku/index/add_success');

            }
        }else{
            $data['message']="";
            $this->Template($data);
        }
    }
    
    function edit($id){
        $data['title']      = "Edit data Buku";
        $data['content']    = 'buku/edit';
        $this->_set_rules(true);
        if($this->form_validation->run()==true){
            $kode=$id;
            
            //setting konfiguras upload image
            $config['upload_path']      = './assets/image/';
	        $config['allowed_types']    = 'gif|jpg|png|jpeg';
            $config['max_size']	        = '1000';
            $config['max_width']        = '2000';
            $config['max_height']       = '1024';
                
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('gambar')){
                $gambar="";
                // echo $this->upload->display_errors();
            }else{
                $gambar=$this->upload->file_name;
            }
            
            $info=array(
                'judul'         => $this->input->post('judul'),
                'pengarang'     => $this->input->post('pengarang'),
                'klasifikasi'   => $this->input->post('klasifikasi')
            );
            if(!empty($gambar)){
                $info['image'] = $gambar;
            }
            // var_dump($this->input->post());
            $this->m_buku->update($kode,$info);
            
            $data['buku']=$this->m_buku->cek($id)->row_array();
            $this->session->set_flashdata(['message' => 'Data Berhasil Diupdate']);
            $this->Template($data);
        }else{
            $data['buku']=$this->m_buku->cek($id)->row_array();
            $this->Template($data);
        }
    }
    
    function delete($id){
        $kode=$id;
        $detail=$this->m_buku->cek($kode)->result();
	// foreach($detail as $det):
	//     unlink("./assets/image/".$det->image);
	// endforeach;
        $this->m_buku->hapus($kode);
        redirect(base_url('buku'));
    }
    
    private function _set_rules($edit=false){
        if($edit != true){
            $this->form_validation->set_rules('kode','Kode Buku','required|max_length[5]');
        }
        $this->form_validation->set_rules('judul','Judul Buku','required|max_length[100]');
        $this->form_validation->set_rules('pengarang','Pengarang','required|max_length[50]');
        $this->form_validation->set_rules('klasifikasi','Keterangan','required|max_length[255]');
    }
}