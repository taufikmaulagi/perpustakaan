<?php
    echo beginportlet('green', '');
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
        ]);
    }
    echo portlet(datatable(
        [
            '#', 'Gambar', 'Kode Buku', 'Judul', 'Pengarang', 'Keterangan'
        ], $datatable
    ));
    echo endportlet();

