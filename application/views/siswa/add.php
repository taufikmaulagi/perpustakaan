<?php

    echo beginportlet('blue-hoki', 
        button('kembali',base_url('siswa'), ['color' => 'yellow', 'icon' => 'arrow-left'])
    );
    echo portlet(
        begin_form(base_url('siswa/tambah')).
            begin_form_body().
                input_text('Nomor Induk Siswa','nis').
                input_text('Nama Lengkap','nama').
                '<div class="row">'.
                    '<div class="col-sm-6">'.
                        input_text('Tempat Lahir','tempat_lahir').
                    '</div>'.
                    '<div class="col-sm-6">'.
                        input_date('Tanggal Lahir','tanggal_lahir').
                    '</div>'.
                '</div>'.
                input_radio('Jenis kelamin','jenis_kelamin', [
                    ['id' => 'L', 'nama' => 'Laki - Laki'],
                    ['id' => 'P', 'nama' => 'Perempuan']
                ]).
                input_select('Jenis kelamin','jenis_kelamin', [
                    ['id' => 'L', 'nama' => 'Laki - Laki'],
                    ['id' => 'P', 'nama' => 'Perempuan']
                ]).
                input_textarea('Alamat','alamat').
            end_form_body().
            begin_form_actions().
                input_submit('Simpan').
            end_form_actions().
        end_form()
    , TRUE);
    echo endportlet();