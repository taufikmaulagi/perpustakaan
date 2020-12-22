<?php

require APPPATH.'libraries/Elevens.php';

class Pengaturan extends Elevens {

    public function set_tahun_ajaran($id){
        $this->load->model('Elevens_model','el');
        $res['tahun_ajaran'] = $this->db->get_where('tahun_ajaran', ['id' => $id])->result_array();
        if(count($res['tahun_ajaran'])<=0)
            return 0;
        $this->session->set_userdata([
            'tahun_ajaran_aktif_id' => $id,
            'tahun_ajaran_aktif'    => $res['tahun_ajaran'][0]['nama']
        ]);
    }

}