<?php

class Elevens_model extends CI_Model {

    function get_sidemenu(){

        $this->db->order_by('position','ASC');
        $res['menu'] = $this->db->get('menu')->result_array();
        $this->db->order_by('position','ASC');
        $res['sub'] = $this->db->get('menu_sub')->result_array();
        $this->db->order_by('position','ASC');
        $res['group'] = $this->db->get('menu_group')->result_array();
        
        return $res;
        
    }

    function get_detail_submenu($active_uri){
        
        $res['main'] = $this->db->get_where('menu_sub',['url' => $active_uri.'/'])->result_array();
        if(count($res['main'])<=0)
            $res['main'] = $this->db->get_where('menu', ['url' => $active_uri])->result_array();
        else
            $res['menu'] = $this->db->get_where('menu', ['id' => $res['main'][0]['menu']])->result_array();
        return $res;
    }

    function get_tahun_ajaran($args = array()){

        $this->db->select('id, nama, aktif');
        if(!empty($args['id']))
            $this->db->where('id', $args['id']);
        if(!empty($args['aktif']))
            $this->db->where('aktif', $args['aktif']);
        $this->db->where('deleted_at is NULL');
        return $this->db->get('tahun_ajaran')->result_array();

    }

}