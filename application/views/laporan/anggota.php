<?php
    echo beginportlet('green','');
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
            $val['kelas']
        ]);
    }
    echo portlet(datatable(
        [
            '#', 'Foto', 'NIS', 'Nama Lengkap', 'JK', 'TTL', 'Kelas'
        ], $datatable
    ));
    echo endportlet();