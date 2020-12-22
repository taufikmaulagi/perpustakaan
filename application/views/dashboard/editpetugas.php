<?php

    echo beginportlet('blue-hoki', 
        button('kembali',base_url('petugas'), ['color' => 'yellow', 'icon' => 'arrow-left'])
    );
    echo portlet(
        begin_form(base_url('petugas/edit/'.$petugas['id_petugas'])).
            begin_form_body().
                '<div class="row">'.
                    '<div class="col-sm-8">'.
                        input_text('Username','user', $petugas['user']).
                        input_password('Password','password', $petugas['password']).
                    '</div>'.
                '</div>'.
            end_form_body().
            begin_form_actions().
                input_submit('Simpan Perubahan').
            end_form_actions().
        end_form()
    , TRUE);
    echo endportlet();