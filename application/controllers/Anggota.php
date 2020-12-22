<?php
require APPPATH.'libraries/Elevens.php';

class Anggota extends Elevens {
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('form_validation','upload'));
        $this->load->model('m_anggota');
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
    
    function index(){
        $data['anggota']=$this->m_anggota->get()->result_array();
        $data['title']="Data Anggota";
        if($this->uri->segment(3)=="delete_success")
            $this->session->set_flashdata(['message' => 'Data Berhasil Dihapus']);
        else if($this->uri->segment(3)=="add_success")
            $this->session->set_flashdata(['message' => 'Data Berhasil Disimpan']);
        else
            $data['message']='';
        $data['content'] = 'anggota/index';
        $data['template'] = ['datatables'];
        $this->Template($data);
    }
    
    
    function edit($id){
        $data['title']  = "Edit Data Anggota";
        $data['content'] = 'anggota/edit'; 
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $nis=$this->input->post('nis');
            //setting konfiguras upload image
            $config['upload_path'] = './assets/image/';
	        $config['allowed_types'] = 'gif|jpg|png';
	    // $config['max_size']	= '1000';
	    // $config['max_width']  = '2000';
	    // $config['max_height']  = '1024';
                
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('gambar')){
                $gambar="default.png";
            }else{
                $gambar=$this->upload->file_name;
            }
            
            $info=array(
                'nama'=>$this->input->post('nama'),
                'kelas'=>$this->input->post('kelas'),
                'ttl'=>$this->input->post('ttl'),
                'jk'=>$this->input->post('jk'),
                'image'=>$gambar
            );
            //update data angggota
            $this->m_anggota->update($nis,$info);
            
            //tampilkan pesan
            $this->session->set_flashdata(['message' => 'Data Berhasi Berhasil Diupdate']);
            
            //tampilkan data anggota 
            $data['anggota']=$this->m_anggota->cek($id)->row_array();
            $this->Template($data);
        }else{
            $data['anggota']=$this->m_anggota->cek($id)->row_array();
            $data['message']="";
            $this->Template($data);
        }
    }
    
    
    function add(){
        $data['title']="Tambah Data Anggota";
        $ata['content'] = 'anggota/tambah';
        $this->_set_rules();
        if($this->form_validation->run()==true){
            $nis=$this->input->post('nis');
            $cek=$this->m_anggota->cek($nis);
            if($cek->num_rows()>0){
                $this->session->set_flashdata(['message' => 'NIS sudah digunakan']);
                $this->Template($data);
            }else{
                //setting konfiguras upload image
                $config['upload_path'] = './assets/image/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']	= '1000';
                $config['max_width']  = '2000';
                $config['max_height']  = '1024';
                
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('gambar')){
                    $gambar="default.png";
                }else{
                    $gambar=$this->upload->file_name;
                }
                
                $info=array(
                    'nis'=>$this->input->post('nis'),
                    'nama'=>$this->input->post('nama'),
                    'jk'=>$this->input->post('jk'),
                    'ttl'=>$this->input->post('ttl'),
                    'kelas'=>$this->input->post('kelas'),
                    'image'=>$gambar
                );
                $this->m_anggota->simpan($info);
                redirect('anggota/index/add_success');
            }
        }else{
            $data['message']="";
            $data['content'] = 'anggota/tambah';
            $this->Template($data);
        }
    }
    
    
    function delete($id){
        $kode=$id;
        $detail=$this->m_anggota->cek($kode)->result();
	// foreach($detail as $det):
	//     unlink("assets/img/anggota/".$det->image);
	// endforeach;
        $this->m_anggota->hapus($kode);
        redirect(base_url('anggota'));
    }
    
    function cari(){
        $data['title']="Pencarian";
        $cari=$this->input->post('cari');
        $cek=$this->m_anggota->cari($cari);
        if($cek->num_rows()>0){
            $data['message']="";
            $data['anggota']=$cek->result();
            $this->template->display('anggota/cari',$data);
        }else{
            $data['message']="<div class='alert alert-success'>Data tidak ditemukan</div>";
            $data['anggota']=$cek->result();
            $this->template->display('anggota/cari',$data);
        }
    }
    
    function _set_rules($edit=false){
        $this->form_validation->set_rules('nis','NIS','required|max_length[10]');
        $this->form_validation->set_rules('nama','Nama','required|max_length[50]');
        $this->form_validation->set_rules('jk','Jenis Kelamin','required|max_length[2]');
        $this->form_validation->set_rules('ttl','Tanggal Lahir','required');
        $this->form_validation->set_rules('kelas','Kelas','required|max_length[10]');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
    }
}