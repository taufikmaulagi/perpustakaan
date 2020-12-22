<?php
    echo alert_flashdata('message');
    echo beginportlet('blue-hoki', 
        button('kembali',base_url('buku'), ['color' => 'yellow', 'icon' => 'arrow-left'])
    );
    echo portlet(
        begin_form(base_url('buku/edit/'.$buku['kode_buku']), 'multipart/form-data').
            begin_form_body().
                '<div class="row">'.
                    '<div class="col-sm-8">'.
                        input_text_disable('Kode','kode',$buku['kode_buku']).
                        input_text('Judul','judul',$buku['judul']).
                        input_text('Pengarang','pengarang',$buku['pengarang']).
                        input_textarea('Keterangan','klasifikasi',$buku['klasifikasi']).
                        '<div class="form-group">
                            <label class="col-lg-2 control-label">Image</label>
                            <div class="col-lg-10">
                                <img src="'.base_url('./assets/image/'.$buku['image']).'" height="200px" width="200px"> 
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-2 control-label"></label>
                            <div class="col-lg-5">
                                <input type="file" name="gambar" class="form-control">
                            </div>
                        </div>'.
                    '</div>'.
                '</div>'.
            end_form_body().
            begin_form_actions().
                input_submit('Simpan Perubahan').
            end_form_actions().
        end_form()
    , TRUE);
    echo endportlet();