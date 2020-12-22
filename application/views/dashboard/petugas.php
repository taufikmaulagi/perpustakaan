<?php
    echo alert_flashdata('message');
    echo beginportlet('blue', 
        button('Tambah Baru',base_url('petugas/add'), ['color' => 'blue-hoki'])
    );
    $datatable = array();
    $no=1;
    foreach($petugas as $key => $val){
        array_push($datatable, [
            $no++,
            $val['user'],
            button_icon(base_url('petugas/edit/'.$val['id_petugas']), ['color' => 'yellow','icon' => 'pencil']).
            button_icon(base_url('petugas/delete/'.$val['id_petugas']), ['color' => 'red', 'icon' => 'trash-o']),
        ]);
    }
    echo portlet(datatable(
        [
            '#', 'Username', 'Opsi'
        ], $datatable
    ));
    echo endportlet();