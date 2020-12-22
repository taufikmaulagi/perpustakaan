<?php

require APPPATH.'libraries/Elevens.php';

class Dashboard extends Elevens {
    
    function __construct(){
        parent::__construct();
        $this->load->model('m_petugas');
        $this->load->library(array('form_validation'));
        
        if(!$this->session->userdata('username')){
            redirect('web');
        }
    }
    
    function index(){
        $data['title']="Dashboard";
        $data['content'] = 'dashboard/index';
        $data['anggota'] = $this->db->get('anggota')->num_rows();
        $data['buku'] = $this->db->get('buku')->num_rows();
        $data['pengembalian'] = $this->db->get('pengembalian')->num_rows();
        $data['peminjaman'] = $this->db->get('transaksi')->num_rows();
        $this->template($data);
    }
    
    function logout(){
        $this->session->unset_userdata('username');
        redirect('web');
    }
}