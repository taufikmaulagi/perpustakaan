<?php

    echo beginportlet('blue-hoki', 
        button('kembali',base_url('buku'), ['color' => 'yellow', 'icon' => 'arrow-left'])
    );
    echo portlet(
        begin_form(base_url('buku/add')).
            begin_form_body().
                '<div class="row">'.
                    '<div class="col-sm-8">'.
                        input_text('Kode','kode').
                        input_text('Judul','judul').
                        input_text('Pengarang','pengarang').
                        input_textarea('Keterangan','klasifikasi').
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