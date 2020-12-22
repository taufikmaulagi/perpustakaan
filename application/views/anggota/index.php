<?php
    echo alert_flashdata('message');
    echo beginportlet('blue', 
        button('Tambah Baru',base_url('anggota/add'), ['color' => 'blue-hoki'])
    );
    $datatable = array();
    $no=1;
    foreach($anggota as $key => $val){
        array_push($datatable, [
            $no++,
            image($val['image'],'width:50%;display:block'),
            $val['nis'],
            $val['nama'],
            $val['jk'],
            $val['ttl'],
            $val['kelas'],
            button_icon(base_url('anggota/edit/'.$val['nis']), ['color' => 'yellow','icon' => 'pencil']).
            button_icon(base_url('anggota/delete/'.$val['nis']), ['color' => 'red', 'icon' => 'trash-o']),
        ]);
    }
    echo portlet(datatable(
        [
            '#', 'Foto', 'NIS', 'Nama Lengkap', 'JK', 'TTL', 'Kelas', 'Opsi'
        ], $datatable
    ));
    echo endportlet();