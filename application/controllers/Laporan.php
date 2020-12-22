<?php 

require APPPATH.'libraries/Elevens.php';

class Laporan extends Elevens {
    
    function __construct(){
        parent::__construct();
        $this->load->model('m_laporan');
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
    
    function anggota(){
        $data['title']="Data Anggota";
        $data['anggota']=$this->m_laporan->semuaAnggota()->result_array();
        $data['content'] = 'laporan/anggota';
        $data['template'] = ['datatables'];
        $this->Template($data);
    }
    
    function buku(){
        $data['title']="Data Buku";
        $data['buku']=$this->m_laporan->semuaBuku()->result_array();
        $data['content'] = 'laporan/buku';
        $data['template'] = ['datatables'];
        $this->Template($data);
    }
    
    function peminjaman(){
        $data['title']="Laporan Peminjaman";
        $data['content'] = 'laporan/peminjaman';
        $data['template'] = ['datatables'];
        $this->Template($data);
    }
    
    function cari_pinjaman(){
        $data['title']="Detail Peminjaman";
        $tanggal1=$this->input->post('tanggal1');
        $tanggal2=$this->input->post('tanggal2');
        $data['lap']=$this->m_laporan->detailpeminjaman($tanggal1,$tanggal2)->result_array();
        $this->load->view('laporan/cari_pinjaman',$data);
    }
    
    function detail_pinjam($id){
        $data['title']=$id;
        $data['pinjam']=$this->m_laporan->detail_pinjam($id)->row_array();
        $data['detail']=$this->m_laporan->detail_pinjam($id)->result_array();
        $data['content']='laporan/detail_pinjam';
        $this->Template($data);
    }
    
    function pengembalian(){
        $data['title']="Data Pengembalian";
        $data['content'] = 'laporan/pengembalian';
        $this->Template($data);
    }
    
    function cari_pengembalian(){
        $data['title']="Detail Pengembalian";
        $tanggal1=$this->input->post('tanggal1');
        $tanggal2=$this->input->post('tanggal2');
        $data['lap']=$this->m_laporan->detailpengembalian($tanggal1,$tanggal2)->result_array();
        $this->load->view('laporan/cari_pengembalian',$data);
    }
}