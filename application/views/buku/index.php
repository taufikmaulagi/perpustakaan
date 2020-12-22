<?php
    echo alert_flashdata('message');
    echo beginportlet('blue', 
        button('Tambah Baru',base_url('buku/add'), ['color' => 'blue-hoki'])
    );
    $datatable = array();
    $no=1;
    foreach($buku as $key => $val){
        array_push($datatable, [
            $no++,
            image($val['image'],'width:50%;display:block'),
            $val['kode_buku'],
            $val['judul'],
            $val['pengarang'],
            $val['klasifikasi'],
            button_icon(base_url('buku/edit/'.$val['kode_buku']), ['color' => 'yellow','icon' => 'pencil']).
            button_icon(base_url('buku/delete/'.$val['kode_buku']), ['color' => 'red', 'icon' => 'trash-o']),
        ]);
    }
    echo portlet(datatable(
        [
            '#', 'Gambar', 'Kode Buku', 'Judul', 'Pengarang', 'Keterangan', 'Opsi'
        ], $datatable
    ));
    echo endportlet();
