<?php

    echo beginportlet('blue-hoki', 
        button('kembali',base_url('anggota'), ['color' => 'yellow', 'icon' => 'arrow-left'])
    );
    echo portlet(
        begin_form(base_url('anggota/add')).
            begin_form_body().
                '<div class="row">'.
                    '<div class="col-sm-8">'.
                        input_text('NIS','nis', $anggota['nis']).
                        input_text('Nama','nama', $anggota['nama']).
                        input_radio('Jenis Kelamin','jk', [['id' => 'L','nama' => 'Laki - Laki'], ['id' => 'P', 'nama' => 'Perempuan']], $anggota['jk']).
                        input_date('Tanggal Lahir','ttl', $anggota['ttl']).
                        input_text('Kelas','kelas', $anggota['kelas']).
                        '<div class="form-group">
                            <label class="col-lg-2 control-label">Image</label>
                            <div class="col-lg-10">
                                <img src="'.base_url('./assets/image/'.$anggota['image']).'" height="200px" width="200px"> 
                            </div>
                        </div>
                        <input type="file" name="gambar" class="form-control">'.
                    '</div>'.
                '</div>'.
            end_form_body().
            begin_form_actions().
                input_submit('Simpan').
            end_form_actions().
        end_form()
    , TRUE);
    echo endportlet();