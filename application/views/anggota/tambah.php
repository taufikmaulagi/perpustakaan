<?php

    echo beginportlet('blue-hoki', 
        button('kembali',base_url('anggota'), ['color' => 'yellow', 'icon' => 'arrow-left'])
    );
    echo portlet(
        begin_form(base_url('anggota/add')).
            begin_form_body().
                '<div class="row">'.
                    '<div class="col-sm-8">'.
                        input_text('NIS','nis').
                        input_text('Nama','nama').
                        input_radio('Jenis Kelamin','jk', [['id' => 'L','nama' => 'Laki - Laki'], ['id' => 'P', 'nama' => 'Perempuan']]).
                        input_date('Tanggal Lahir','ttl').
                        input_text('Kelas','kelas').
                        '<div class="form-group">
                            <label>Image</label>
                            <input type="file" name="gambar" class="form-control">
                        </div>'.
                    '</div>'.
                '</div>'.
            end_form_body().
            begin_form_actions().
                input_submit('Simpan').
            end_form_actions().
        end_form()
    , TRUE);
    echo endportlet();