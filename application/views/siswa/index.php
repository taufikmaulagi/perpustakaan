<?php
    $kelas = [
        ['id' => 1, 'nama' => 2]
    ];
    echo beginportlet('blue', 
        button('Tambah Baru',base_url('siswa/tambah'), ['color' => 'blue-hoki'])
    );
    $siswa = [
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],
        ['nama' => 'Taufik Maulana', 'ttl' => 'tasik, 1997-01-20', 'jenis_kelamin' => 'L'],

    ];
    $datatable = array();
    // $no=1;
    foreach($siswa as $key => $val){
        array_push($datatable, [
            button_icon(base_url('siswa/edit'), ['color' => 'yellow','icon' => 'pencil']).' '.
            button_icon(base_url('siswa/hapus'), ['color' => 'red', 'icon' => 'trash-o']),
            $val['nama'], 
            $val['ttl'], 
            $val['jenis_kelamin']
        ]);
    }
    echo portlet(datatable(
        [
            'Opsi', 'Nama Lengkap', 'Tempat, Tanggal Lahir', 'Jenis kelamin'
        ], $datatable
    ));
    echo endportlet();