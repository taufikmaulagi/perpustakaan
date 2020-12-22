<style type="text/css">
    .big-box h2 {
    text-align: center;
    width: 100%;
    font-size: 1.8em;
    letter-spacing: 2px;
    font-weight: 700;
    text-transform: uppercase;
    cursor:pointer;
}
.modal-dialog {
    width: 100%;
    height: 100%;
    padding: 0;
    margin:0;
}
.modal-content {
    height: 100%;
    border-radius: 0;
    color:#333;
    overflow:auto;
}
.close {
    color:black ! important;
    opacity:1.0;
}
</style>
<section class="panel panel-primary">
    <header class="panel-heading">
        <b><?=strtoupper($title)?> | VIEW</b>
    </header>
    <div class="m">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <button class="btn btn-primary btn-sm" id="addrow" onclick="add_row()"><i class="fa fa-plus" class="m-r"></i> ADD ROW </button>
                <button class="btn btn-info btn-sm" onclick="generate_view()"><i class="fa fa-download" class="m-r"></i> GENERATE </button>
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#controller_data_modal"><i class="fa fa-star" class="m-r"></i> CONTROLLER DATA </button>
            </div>
            <div class="col-sm-6" align="right">
                <select class="form-control input-sm" onchange="_set_table(this)" style="width:40%">
                    <?php
                        foreach ($tables as $key => $val) {
                            $selected = "";
                            if($val['table'] == $table_active)
                                $selected = "selected='selected'";
                                echo "<option value='".$val['table']."' ".$selected.">".strtoupper($val['table'])."</option>";
                            }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered m-b-none table-hover" id="cg_table">
            <thead>
                <tr>
                    <th width="150px"> Parameter </th>
                    <th width="150px">Query</th>
                    <th>Value</th>
                    <th width="5px">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <tr id="baris1">
                    <td>
                        <input type="text" class="form-control" name="parameter" placeholder="-- NONE --" id="param1">
                    </td>
                    <td>
                        <select class="form-control" onchange="change_value(1)" id="query1">
                            <option value="SELECT">SELECT</option>
                            <option value="JOIN">JOIN</option>
                            <option value="WHERE">WHERE</option>
                            <option value="ORDER_BY">ORDER BY</option>
                        </select>
                    </td>
                    <td id="value1">
                        <select id="select_list1" name="select_list1[]" multiple="multiple" style="width: 100%;"></select>
                    </td>
                    <td>
                        <button class="btn btn-info btn-sm"><i class="fa fa-heart"></i></button>
                    </td>
                </tr>         
            </tbody>
        </table>
    </div>
</section>
<div class="modal fade" id="generate_view">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- header-->
            <div class="modal-header">
                <button class="close" data-dismiss="modal"><span>&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><b>GENERATE VIEW</b></h4>
            </div>
            <!--body-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <b>Model</b><br/>
                        <textarea id="model_gv" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="col-sm-4">
                        <b>Controller</b><br/>
                        <textarea id="controller_gv" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="col-sm-4">
                        <b>View</b><br/>
                        <textarea id="view_gv" class="form-control" rows="10"></textarea>
                    </div>
                </div>
                <div class="row m-t">
                    <div class="col-sm-6">
                        <b>ADD</b><br/>
                        <textarea id="add_gv" class="form-control" rows="20"></textarea>
                    </div>
                    <div class="col-sm-6">
                        <b>EDIT</b><br/>
                        <textarea id="edit_gv" class="form-control" rows="20"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var id = 1;
    var join_list = [];
    var join = '';
    var tempR = '';
    var tempRE = '';
    var tempUpload = '';
    var tempIns = '';
    var tempUp = '';
    var addView = '&lt?php\n'+

                    "echo beginportlet('blue-hoki', \n"+
                        "\tbutton('kembali',base_url('<?=$table_active?>'), ['color' => 'yellow', 'icon' => 'arrow-left'])\n"+
                    ");\n"+
                    "echo portlet(\n"+
                    "begin_form(base_url('<?=$table_active?>/add')).\n"+
                        "\tbegin_form_body().\n";
    var editView = '&lt?php\n'+

                    "echo beginportlet('blue-hoki', \n"+
                        "\tbutton('kembali',base_url('<?=$table_active?>'), ['color' => 'yellow', 'icon' => 'arrow-left'])\n"+
                    ");\n"+
                    "echo portlet(\n"+
                    "begin_form(base_url('<?=$table_active?>/edit/')).\n"+
                        "\tbegin_form_body().\n"+
                    "\tinput_hidden('id', $<?=$table_active?>['id']).\n";
    $(document).ready(function(){
        $.ajax({
            url : "<?=base_url('assistant/get_desc/').$table_active?>",
            success : function(data){
                data = JSON.parse(data);
                $.each(data, function(i, item){
                    var rules = [];
                    var rules_edit = [];
                    if(item.null == 'NO'){
                        rules.push('required');
                        rules_edit.push('required');
                    }
                    if(item.key != ''){
                        rules.push('is_unique['+item.field+']');
                        rules_edit.push('is_unique['+item.field+'.\'.$id.\']');
                    }
                    if(item.rules[0] == 'int' || item.rules[0] == 'smallint' || item.rules[0] == 'mediumint' || item.rules[0] == 'int' || item.rules[0] == 'bigint'){
                        rules.push('numeric');
                        rules_edit.push('numeric');
                    } else if(item.rules[0] == 'varchar'){
                        rules.push('max_length['+item.rules[1]+']');
                        rules_edit.push('max_length['+item.rules[1]+']');
                    }
                    item.field = item.field.split('.')[1];
                    if(item.field == 'foto_profile' || item.field == 'gambar' || item.field == 'file' || item.field == 'foto'){
                        tempUpload += '\t\t$name_file = \'\';\n'+
                                        '\t\tif(isset($_FILES[\''+item.field+'\'][\'name\']) && !empty($_FILES[\''+item.field+'\'][\'name\'])){\n'+
                                            '\t\t\t$config[\'upload_path\']          = \'./assets/images/\';\n'+
                                            '\t\t\t$config[\'allowed_types\']        = \'jpg|png\';\n'+
                                            '\t\t\t$config[\'file_name\']            = uniqid();\n'+
                                            '\t\t\t$config[\'overwrite\']            = true;\n'+
                                            '\t\t\t$config[\'max_size\']             = 1024; // 1MB\n'+
                                            '\t\t\t// $config[\'max_width\']            = 1024;\n'+
                                            '\t\t\t// $config[\'max_height\']           = 768;\n'+
                                            '\t\t\t$this->load->library(\'upload\', $config);\n'+
                                            '\t\t\tif ($this->upload->do_upload(\''+item.field+'\')) {\n'+
                                            '\t\t\t\t$name_file = $this->upload->data("file_name");\n'+
                                            '\t\t\t\t//if(!empty($name_file)){\n'+
                                            '\t\t\t\t//$res[\''+item.field+'\'] = $this-><?=$table_active?>_m->get()[0];\n'+
                                            '\t\t\t\t//if(!empty($res[\''+item.field+'\'][\'keterangan\'])){\n'+
                                            '\t\t\t\t//$this->pengaturan_m->update_fe([\'fe\' => [\'keterangan\' => $name_file], \'id\' => $res[\''+item.field+'\'][\'id\']]);\n'+
                                            
                                            '\t\t\t\t// unlink(\'./assets/img/\'.$res[\''+item.field+'\'][\'keterangan\']);\n'+
                                            '\t\t\t\t//redirect(base_url(\'pengaturan/frontend\'));'+
                                            '\t\t\t\t//}\n'+
                                            '\t\t\t\t//}\n'+
                                            '\t\t\t} else {\n'+
                                            '\t\t\t\tvar_dump($this->upload->display_errors());\n'+
                                            '\t\t\t}\n'+
                                        '\t\t}\n';
                    }
                    if(item.field == 'foto_profile' || item.field == 'gambar' || item.field == 'file' || item.field == 'foto'){
                        tempUp = '\t\tif(!empty($name_file)){\n'+
                                    '\t\t\t$args[\''+item.field+'\'] = $name_file;\n'+
                                '\t\t}\n';
                        addView += '\t<div class="form-group">\n'+
                                    '\t\t<label>'+item.field.charAt(0).toUpperCase() + item.field.slice(1)+'</label>\n\t\t<br/>\n';
                        addView += '\t\t<div class="image-input image-input-outline" id="kt_image_1">\n'+
                                    '\t\t\t<div class="image-input-wrapper" style="background-image: url(../assets/media/defaultfp.png)"></div>\n'+
                                    '\t\t\t<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">\n'+
                                    '\t\t\t\t<i class="fa fa-pen icon-sm text-muted"></i>\n'+
                                    '\t\t\t\t<input type="file" name="'+item.field+'" accept=".png, .jpg, .jpeg"/>\n'+
                                    '\t\t\t\t<input type="hidden" name="profile_avatar_remove"/>\n'+
                                    '\t\t\t</label>\n'+
                                    '\t\t\t<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">\n'+
                                    '\t\t\t\t<i class="ki ki-bold-close icon-xs text-muted"></i>\n'+
                                    '\t\t\t</span>\n'+
                                    '\t\t</div>\n';
                        addView += '\t\t<span class="text-danger">&lt;?=form_error(\''+item.field+'\');?&gt;</span>\n\t</div>\n';

                        editView += '\t<div class="form-group">\n'+
                                    '\t\t<label>'+item.field.charAt(0).toUpperCase() + item.field.slice(1)+'</label>\n\t\t<br/>\n';
                        editView += '\t\t<div class="image-input image-input-outline" id="kt_image_1">\n'+
                                    '\t\t\t<div class="image-input-wrapper" style="background-image: url(../../assets/media/&lt;?=$<?=$table_active?>[\''+item.field+'\'] ? $table_active?>[\''+item.field+'\'] : \'defaultfp.png\' ?&gt;)"></div>\n'+
                                    '\t\t\t<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">\n'+
                                    '\t\t\t\t<i class="fa fa-pen icon-sm text-muted"></i>\n'+
                                    '\t\t\t\t<input type="file" name="'+item.field+'" accept=".png, .jpg, .jpeg"/>\n'+
                                    '\t\t\t\t<input type="hidden" name="profile_avatar_remove"/>\n'+
                                    '\t\t\t</label>\n'+
                                    '\t\t\t<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">\n'+
                                    '\t\t\t\t<i class="ki ki-bold-close icon-xs text-muted"></i>\n'+
                                    '\t\t\t</span>\n'+
                                    '\t\t</div>\n';
                        editView += '\t\t<span class="text-danger">&lt;?=form_error(\''+item.field+'\');?&gt;</span>\n\t</div>\n';
                    } else {
                       if(item.field != 'id' && item.field != 'created_at' && item.field != 'updated_at' && item.field != 'deleted_at' && item.field != 'created_at' && item.field != 'date_created' && item.field != 'status'){
                            var tempif = item.field.split('_');
                            var tiflabel = item.field.charAt(0).toUpperCase() + item.field.slice(1);
                            if(tempif.length > 1){
                                tiflabel = tempif[0].charAt(0).toUpperCase()+tempif[0].slice(1)+' '+tempif[1].charAt(0).toUpperCase()+tempif[1].slice(1);
                            }
                            if(item.field == 'password'){
                                addView += "\t\tinput_password('Password','password').\n";
                                editView += "\t\tinput_password('Password','password',$<?=$table_active?>[\''+item.field+'\']).\n";
                            } else if(item.rules[0] == 'int' || item.rules[0] == 'smallint' || item.rules[0] == 'mediumint' || item.rules[0] == 'int' || item.rules[0] == 'bigint'){
                                addView += "\t\tinput_number('"+tiflabel+"','"+item.field+"').\n";
                                editView += "\t\tinput_number('"+tiflabel+"','"+item.field+"',$<?=$table_active?>[\''+item.field+'\']).\n";
                            } else if(item.rules[0] == 'varchar'){
                                if(item.rules[1] >= 100){
                                    addView += "\t\tinput_textarea('"+tiflabel+"','"+item.field+"').\n";
                                    editView += "\t\tinput_textarea('"+tiflabel+"','"+item.field+"',$<?=$table_active?>[\''+item.field+'\']).\n";
                                } else {
                                    addView += "\t\tinput_text('"+tiflabel+"','"+item.field+"').\n";
                                    editView += "\t\tinput_text('"+tiflabel+"','"+item.field+"',$<?=$table_active?>[\''+item.field+'\']).\n";
                                }
                            } else if(item.rules[0] == 'enum'){
                                item.option = JSON.parse(item.option);
                                if(item.option.length <= 3){
                                    addView += "\t\tinput_radio('"+tiflabel+"','"+item.field+"',[['id' => 'L','nama' => 'Laki-Laki'],['id' => 'P','nama' => 'Perempuan']]).\n";
                                    editView += "\t\tinput_radio('"+tiflabel+"','"+item.field+"',[['id' => 'L','nama' => 'Laki-Laki'],['id' => 'P','nama' => 'Perempuan']],$<?=$table_active?>[\''+item.field+'\']).\n";
                                } else {
                                    addView += '\t\t<select class="form-control" name="'+item.field+'">\n';
                                    for(var i=0;i<item.option.length;i++){
                                        addView += '\t\t<option value="'+item.option[i]+'" &lt;?=!empty($this->input->post(\''+item.field+'\')) && $this->input->post(\''+item.field+'\') == \''+item.option[i]+'\' ? \'selected="selected"\' : \'\'; ?&gt;>'+item.option[i]+'</option>\n';
                                    }
                                    addView += '\t\t</select>\n';

                                    editView += '\t\t<select class="form-control" name="'+item.field+'">\n';
                                    for(var i=0;i<item.option.length;i++){
                                        editView += '\t\t<option value="'+item.option[i]+'" &lt;?=((!empty($this->input->post(\''+item.field+'\')) && $this->input->post(\''+item.field+'\') == \''+item.option[i]+'\')) || ($<?=$table_active?>[\''+item.field+'\'] == \''+item.option[i]+'\' && empty($this->input->post(\''+item.field+'\'))) ? \'selected="selected"\' : \'\'?&gt;>'+item.option[i]+'</option>\n';
                                    }
                                    editView += '\t\t</select>\n';
                                }
                            } else if(item.rules[0] == 'date'){
                                addView += '\t\t<div class="form-group row">\n'+
                                            '\t\t\t<div class="input-group date">\n'+
                                            '\t\t\t\t<input type="text" name="tanggal_lahir" class="form-control" readonly  placeholder="Pilih '+tiflabel+'" id="kt_datepicker_2" value="&lt;?=!empty($this->input->post(\''+item.field+'\')) ? date(\'m/d/Y\', strtotime($this->input->post(\''+item.field+'\'))) : \'\'?&gt;" />\n'+
                                            '\t\t\t\t<div class="input-group-append">\n'+
                                            '\t\t\t\t\t<span class="input-group-text">\n'+
                                            '\t\t\t\t\t\t<i class="la la-calendar-check-o"></i>\n'+
                                            '\t\t\t\t\t</span>\n'+
                                            '\t\t\t\t</div>\n'+
                                            '\t\t\t</div>\n'+
                                        '\t\t</div>\n';
                                editView += '\t\t<div class="form-group row">\n'+
                                            '\t\t\t<div class="input-group date">\n'+
                                            '\t\t\t\t<input type="text" name="tanggal_lahir" class="form-control" readonly  placeholder="Pilih '+tiflabel+'" id="kt_datepicker_2" value="&lt;?=!empty($this->input->post(\''+item.field+'\')) ? date(\'m/d/Y\', strtotime($this->input->post(\''+item.field+'\'))) : date(\'m/d/Y\', strtotime($$<?=$table_active?>[\''+item.field+'\']))?&gt;" />\n'+
                                            '\t\t\t\t<div class="input-group-append">\n'+
                                            '\t\t\t\t\t<span class="input-group-text">\n'+
                                            '\t\t\t\t\t\t<i class="la la-calendar-check-o"></i>\n'+
                                            '\t\t\t\t\t</span>\n'+
                                            '\t\t\t\t</div>\n'+
                                            '\t\t\t</div>\n'+
                                        '\t\t</div>\n';
                            } else if(item.rules[0] == 'time'){
                                addView += '\t\t<input type="time" class="form-control" name="'+item.field+'" value="&lt;?=$this->input->post(\''+item.field+'\')?&gt;">\n';
                                editView += '\t\t<input type="time" class="form-control" name="'+item.field+'" value="&lt;?=!empty($this->input->post(\''+item.field+'\')) ? $this->input->post(\''+item.field+'\') : $<?=$table_active?>[\''+item.field+'\']?&gt;">\n';
                            }
                            addView += '\t\t<span class="text-danger">&lt;?=form_error(\''+item.field+'\');?&gt;</span>\n\t</div>\n';
                            editView += '\t\t<span class="text-danger">&lt;?=form_error(\''+item.field+'\');?&gt;</span>\n\t</div>\n';
                            tempIns += '\t\t\t\''+item.field+'\' => $this->input->post(\''+item.field+'\'),\n';
                            var txss = '|trim|xss_clean';
                            var txss_edit = '|trim|xss_clean';
                            if(rules.length <= 0){
                                txss = 'trim|xss_clean';
                            }

                            if(rules_edit.length <= 0){
                                txss_edit = 'trim|xss_clean';
                            }
                            tempR += '\t$this->form_validation->set_rules(\''+item.field+'\',\''+item.field.charAt(0).toUpperCase() + item.field.slice(1)+'\',\''+rules.join('|')+txss+'\');\n';
                            tempRE += '\t$this->form_validation->set_rules(\''+item.field+'\',\''+item.field.charAt(0).toUpperCase() + item.field.slice(1)+'\',\''+rules_edit.join('|')+txss+'\');\n';
                        }
                    }
                });
            addView += '\t<div class="form-group">\n'+
                        '\t\t<button type="submit" class="btn btn-primary btn-s-xs"><i class="fa fa-check m-r"></i>Selesai</button>\n'+
                        '\t</div>\n';
            editView += '\t<div class="form-group">\n'+
                        '\t\t<button type="submit" class="btn btn-primary btn-s-xs"><i class="fa fa-check m-r"></i>Simpan Perubahan</button>\n'+
                        '\t</div>\n';
            }
        });
        update_select_list(1);
    });

    function update_select_list(id){
        $.ajax({
            url: "<?=base_url('assistant/get_desc/').$table_active?>"+"?join="+join,
            success: function(data){
                data = JSON.parse(data);
                var htmlOption = '';
                $.each(data, function(i, item){
                    htmlOption+='<option value="'+item.field+'">'+item.field+'</option>';
                });
                $('#select_list'+id).append(htmlOption);
                $('#where_list'+id).append(htmlOption);
                $('#order_by_list'+id).append(htmlOption);
                $('#select_list'+id).select2();
            }
        });
    }

    function update_join_list(id, join=''){
        $.ajax({
            url:"<?=base_url('assistant/get_all_table?except=').$table_active?>",
            success: function(data){
                data = JSON.parse(data);
                var htmlOption = '';
                $.each(data, function(i, item){
                    htmlOption+='<option value="'+item.table+'">'+item.table+'</option>';
                });
                $('#join_list'+id).append(htmlOption);
            }
        });
        $.ajax({
            url:"<?=base_url('assistant/get_desc/').$table_active?>",
            success: function(data){
                data = JSON.parse(data);
                var htmlOption = '';
                $.each(data, function(i, item){
                    htmlOption+='<option value="'+item.field+'">'+item.field+'</option>';
                });
                $('#field_utama'+id).append(htmlOption);
            }
        });
    }

    function _set_table(option) {
        location.replace("<?php echo base_url('assistant?table=') ?>" + option.value);
    }

    function add_row(){
        id++;
        $('#cg_table').append('<tr id="baris'+id+'">'+
                    '<td>'+
                        '<input type="text" class="form-control" name="parameter" placeholder="-- NONE --" id="param'+id+'">'+
                    '</td>'+
                    '<td>'+
                        '<select class="form-control" onchange="change_value('+id+')" id="query'+id+'">'+
                            '<option value="SELECT">SELECT</option>'+
                            '<option value="JOIN">JOIN</option>'+
                            '<option value="WHERE">WHERE</option>'+
                            '<option value="ORDER_BY">ORDER BY</option>'+
                        '</select>'+
                    '</td>'+
                    '<td id="value'+id+'">'+
                        '<select id="select_list'+id+'" name="select_list1[]" multiple="multiple" style="width: 100%"></select>'+
                    '</td>'+
                    '<td>'+
                        '<button class="btn btn-danger btn-sm" onclick="delete_row('+id+')"><i class="fa fa-trash-o"></i></button>'+
                    '</td>'+
                '</tr>');
        update_select_list(id);
    }

    function delete_row(var_id){
        var idval = $('#query'+var_id).val();
        if(idval == 'JOIN'){
            if($('#join_list'+var_id).val()!=''){
                if(join_list.indexOf($('#join_list'+var_id).val())>=0){
                    delete join_list[join_list.indexOf($('#join_list'+var_id).val())];
                }
            }
        }
        $('#baris'+var_id).remove();
        id--;
    }

    function change_value(id){
        var idval = $('#query'+id).val();
        if(idval == 'SELECT'){
            $('#value'+id).html('<select id="select_list'+id+'" name="select_list'+id+'[]" multiple="multiple" style="width: 100%"></select>');
            update_select_list(id);
        } else if(idval == 'JOIN'){
            $('#value'+id).html('<div class="row">'+
                                    '<div class="col-sm-6">'+
                                        '<select class="form-control" id="join_list'+id+'" name="join_list'+id+'" onchange="generate_field(this, '+id+')"><option value="">- Pilih Table -</option></select>'+
                                    '</div>'+
                                    '<div class="col-sm-3">'+
                                        '<select class="form-control" id="field_utama'+id+'" onchange="update_join('+id+')"><option value="">- Pilih Field Utama -</option></select>'+
                                    '</div>'+
                                    '<div class="col-sm-3">'+
                                        '<select class="form-control" id="field_kedua'+id+'" onchange="update_join('+id+')"><option value="">- Pilih Field Kedua -</option></select>'+
                                    '</div>'+
                                '</div>');
            update_join_list(id);
        } else if(idval == 'WHERE'){
            $('#value'+id).html('<div class="row">'+
                                    '<div class="col-sm-9">'+
                                        '<select class="form-control" id="where_list'+id+'" name="where_list'+id+'"><option value="">- Pilih Field -</option></select>'+
                                    '</div>'+
                                    '<div class="col-sm-3">'+
                                        '<input type="text" class="form-control" id="where_text'+id+'">'+
                                    '</div>'+
                                '</div>');
            update_select_list(id);
        } else if(idval == 'ORDER_BY'){
            $('#value'+id).html('<div class="row">'+
                                    '<div class="col-sm-9">'+
                                        '<select class="form-control" id="order_by_list'+id+'" name="order_by_list'+id+'"><option value="">- Pilih Field -</option></select>'+
                                    '</div>'+
                                    '<div class="col-sm-3">'+
                                        '<select class="form-control" id="order_by_text'+id+'" name="order_by_text'+id+'"><option value="DESC">DESC</option><option value="ASC">ASC</option></select>'+
                                    '</div>'+
                                '</div>');
            update_select_list(id);
        } 
    }

    function generate_field(option, id=0){
        $.ajax({
            url:"<?=base_url('assistant/get_desc/')?>"+option.value,
            success: function(data){
                data = JSON.parse(data);
                var htmlOption = '';
                $.each(data, function(i, item){
                    htmlOption+='<option value="'+item.field+'">'+item.field+'</option>';
                });
                if(id!=0){
                    $('#field_kedua'+id).append(htmlOption);
                } else {
                    $('#cd_field').html('<option value="">- Pilih Field -</option>');
                    $('#cd_field').append(htmlOption);
                }
            }
        });
    }

    function update_join(id){
        var tableTemp = $('#join_list'+id).val();
        if($('#field_utama'+id).val() != '' && $('#field_kedua'+id).val() != ''){
            if(join_list.indexOf(tableTemp)<0){
                join += '|'+tableTemp;
                join_list.push(tableTemp);
            }
        }
    }

    function generate_view(){

        var modelView = 'function get($args=array()){\n';
        var tableView = '<table class="table table-bordered table-striped table-hover" id="datatable">\n';
        var paramArr = [];
        for(var i=1;i<=id;i++){
            var gv_query = $('#query'+i).val();
            var gv_param = $('#param'+i).val();
            var tempMV = '';
            if(gv_query == 'SELECT'){
                gv_select_list = $('#select_list'+i).val();
                var tempdata = [];
                var tempitem = [];
                var tableBody = '';
                $.each(gv_select_list, function(j, item){
                    var item = item.split('.');
                    var new_item = '';
                    var fix_th = '';                    
                    $.each(tempitem, function(k, i_item){
                        if(i_item[1]==item[1]){
                            new_item = item[0]+'.'+item[1]+' as '+item[0]+'_'+item[1];
                            fix_th = item[0]+'_'+item[1];
                        }
                    });
                    tempitem.push(item);
                    if(new_item == ''){
                        new_item = item[0]+'.'+item[1];
                        fix_th = item[1];
                    }

                    // if(tempitem.length == 1){
                    //     tableView += '\t<thead>\n'+
                    //                     '\t\t<tr>\n'+
                    //                     '\t\t\t<th>#</th>\n'+
                    //                     '\t\t\t<th>'+tiflabel+'</th>\n';

                    //     tableBody += '\t<tbody>\n'+
                    //                     '\t\t&lt;?php\n'+
                    //                     '\t\t\t$no=1;\n'+
                    //                     '\t\t\tforeach($<?=$table_active?> as $key => $val):\n'+
                    //                     '\t\t?&gt;\n'+
                    //                     '\t\t<tr>\n'+
                    //                     '\t\t\t<td>&lt;?=$no++?&gt;</td>\n'+
                    //                     '\t\t\t<td>&lt;?=$val[\''+fix_th+'\']?&gt;</td>\n';

                    //     tableView += '\t\t\t<th>Opsi</th>\n'+
                    //                     '\t\t</tr>\n'+
                    //                     '\t</thead>\n';

                    //     tableBody +=    '\t\t\t<td><a href="&lt;?=base_url(\'<?=$table_active?>/edit\')?&gt;"?><button class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></button></a><button class="btn btn-warning btn-sm m-l" onCLick="delete_data(\'&lt;?=base_url(\'<?=$table_active?>/delete/\'.$val[\'id\'])?&gt;\')"><i class="fa fa-trash-o"></i>><i class="fa fa-pencil"></i></button></td>\n'+
                    //                     '\t\t</tr>\n'+
                    //                     '\t\t&lt;?php\n'+
                    //                     '\t\t\tendforeach;\n'+
                    //                     '\t\t?&gt;\n'+
                    //                     '\t</tbody>\n';

                    // } else 
                    var tempif = fix_th.split('_');
                    var tiflabel = fix_th.charAt(0).toUpperCase() + fix_th.slice(1);
                    if(tempif.length > 1){
                        tiflabel = tempif[0].charAt(0).toUpperCase()+tempif[0].slice(1)+' '+tempif[1].charAt(0).toUpperCase()+tempif[1].slice(1);
                    }
                    // if(fix_th != 'id'){
                        if(j == 0){
                            tableView += '\t<thead>\n'+
                                            '\t\t<tr>\n'+
                                            '\t\t\t<th>#</th>\n'+
                                            '\t\t\t<th>'+tiflabel+'</th>\n';

                            tableBody += '\t<tbody>\n'+
                                            '\t\t&lt;?php\n'+
                                            '\t\t\t$no=1;\n'+
                                            '\t\t\tforeach($<?=$table_active?> as $key => $val):\n'+
                                            '\t\t?&gt;\n'+
                                            '\t\t<tr>\n'+
                                            '\t\t\t<td>&lt;?=$no++?&gt;</td>\n'+
                                            '\t\t\t<td>&lt;?=$val[\''+fix_th+'\']?&gt;</td>\n';

                        } else if(j == gv_select_list.length-1){
                            tableView += '\t\t\t<th>'+tiflabel+'</th>\n'+
                                        '\t\t\t<th>Opsi</th>\n'+
                                            '\t\t</tr>\n'+
                                            '\t</thead>\n';

                            tableBody += '\t\t\t<td>&lt;?=$val[\''+fix_th+'\']?&gt;</td>\n'+
                                         '\t\t\t<th><a href="&lt;?=base_url(\'<?=$table_active?>/edit/\'.$val[\'id\'])?&gt;"?><button class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></button></a><button class="btn btn-danger btn-sm m-l" onCLick="delete_data(\'&lt;?=base_url(\'<?=$table_active?>/delete/\'.$val[\'id\'])?&gt;\')"><i class="fa fa-trash-o"></i></button></td>\n'+
                                            '\t\t</tr>\n'+
                                            '\t\t&lt;?php\n'+
                                            '\t\t\tendforeach;\n'+
                                            '\t\t?&gt;\n'+
                                            '\t</tbody>\n';
                        } else {
                            tableBody += '\t\t\t<td>&lt;?=$val[\''+fix_th+'\']?&gt;</td>\n';
                            tableView += '\t\t\t<th>'+tiflabel+'</th>\n';
                        }
                    // }
                    tempdata.push(new_item);
                });
                tableView += tableBody;
                gv_select_list = tempdata;
                tempMV += '\t$this->db->select(\''+gv_select_list.join(', ')+'\');\n';
            } else if(gv_query == 'JOIN'){
                gv_join_list = $('#join_list'+i).val();
                gv_field_utama = $('#field_utama'+i).val();
                gv_field_kedua = $('#field_kedua'+i).val();
                tempMV += '\t$this->db->join(\''+gv_join_list+'\',\''+gv_field_utama+' = '+gv_field_kedua+'\');\n';
            } else if(gv_query == 'WHERE'){
                gv_where_list = $('#where_list'+i).val();
                gv_where_text = $('#where_text'+i).val();
                tempMV += '\t$this->db->where(\''+gv_where_list+'\',\''+gv_where_text+'\');\n';
            } else if(gv_query == 'ORDER_BY'){
                gv_order_by_list = $('#order_by_list'+i).val();
                gv_order_by_text = $('#order_by_text'+i).val();
                tempMV += '\t$this->db->order_by(\''+gv_order_by_list+'\',\''+gv_order_by_text+'\');\n';
            }
            if(gv_param != ''){
                paramArr.push({name: gv_param, text: tempMV});
            } else {
                modelView += tempMV;
            }
        }
        var temp_gv_name = '';
        var args_controller = '';
        if(paramArr.length > 0){
            temp_gv_name = paramArr[0].name;
        }
        for(var i=0;i<paramArr.length;i++){

            if(i == 0 || paramArr[i-1].name != temp_gv_name){
                modelView += '\tif(!empty($args[\''+temp_gv_name+'\'])){\n'+
                                '\t'+paramArr[i].text;
                if(i == paramArr.length-1)
                    modelView += '\t}\n';
                if(i == 0)
                    args_controller += '\t\t\''+temp_gv_name+'\' => $this->input->get(\''+temp_gv_name+'\'),\n';    
                continue;
            }
            if(temp_gv_name != paramArr[i].name){
                modelView += '\t}\n';
                temp_gv_name = paramArr[i].name;
                args_controller += '\t\t\''+temp_gv_name+'\' => $this->input->get(\''+temp_gv_name+'\'),\n';
                i--;
                continue;
            } else if(i == paramArr.length-1){
                modelView += '\t'+paramArr[i].text;
                modelView += '\t}\n';
                continue;
            }
            modelView += '\t'+paramArr[i].text;
            
        }
        modelView += '\treturn $this->db->get(\'<?=$table_active?>\')->result_array();\n}';
        modelView += '\n\nfunction add($args=array()){\n'+
                        '\t$this->db->insert(\'<?=$table_active?>\', $args);\n'+
                        '\treturn $this->db->affected_rows();\n'+
                        '}\n';
        modelView += '\n\nfunction update($args, $id){\n'+
                        '\t$this->db->update(\'<?=$table_active?>\', $args, [\'id\' => $id]);\n'+
                        '\treturn $this->db->affected_rows();\n'+
                        '}\n';
        modelView += '\n\nfunction delete($id){\n'+
                        '\t$this->db->update(\'<?=$table_active?>\', [\'status\' => \'OFF\'], [\'id\' => $args[\'id\']]);\n'+
                        '\treturn $this->db->affected_rows();\n'+
                        '}\n';

        var controllerView = 'function index(){\n';
        controllerView +=   '\t$data = [\n'+
                            '\t\t\'title\' => \'Data <?=$table_active?>\',\n'+
                            '\t\t\'main_title\' => \'\',\n'+
                            '\t\t\'muted_title\' => \'\',\n'+
                            '\t\t\'breadcrumbs\' => \'\',\n'+
                            '\t\t\'content\' => \'<?=$table_active?>/index\',\n'+
                            '\t\t\'templates\' => [\'datatables\']\n'+
                            '\t];\n';
        if(args_controller!=''){
            controllerView += '\t$args = [\n';
            controllerView += args_controller;
            controllerView += '\t];\n';
        }
        controllerView += '\t$data[\'<?=$table_active?>\'] = $this-><?=$table_active?>_m->get($args);\n';
        controllerView += '\t$this->load->view(\'template\',$data);\n}';

        //ADD

        controllerView += '\n\nfunction add(){\n';
        controllerView += '\t$this->load->library(\'form_validation\');\n';
        controllerView += tempR;
        controllerView += '\tif($this->form_validation->run()){\n';
        controllerView += tempUpload;
        controllerView += '\t\t$args = [\n'+tempIns+'\t\t];\n'+
                            '\t\t$this-><?=$table_active?>_m->add($args);\n'+
                            '\t\tredirect(\'<?=$table_active?>/index\');\n'+
                            '\t} else {\n';
        controllerView += '\t\t$data = [\n'+
                            '\t\t\t\'title\' => \'Tambah <?=$table_active?>\',\n'+
                            '\t\t\t\'main_title\' => \'\',\n'+
                            '\t\t\t\'muted_title\' => \'\',\n'+
                            '\t\t\t\'breadcrumbs\' => \'\',\n'+
                            '\t\t\t\'content\' => \'<?=$table_active?>/add\',\n'+
                            '\t\t\t\'templates\' => [\'datepicker\']\n'+
                            '\t\t];\n';
        controllerView += '\t\t$this->load->view(\'template\',$data);\n\t}\n';
        controllerView+= '}';

        //EDIT

        controllerView += '\n\nfunction edit($id=null){\n';
        controllerView += '\t$this->load->library(\'form_validation\');\n';
        controllerView += tempRE;
        controllerView += '\tif($this->form_validation->run()){\n';
        controllerView += tempUpload;
        controllerView += '\t\t$id = $this->input->post(\'id\');\n';
        controllerView += '\t\t$args = [\n'+tempIns+'\t\t];\n';
        controllerView += tempUp;
        controllerView += '\t\t$this-><?=$table_active?>_m->update($args, $id);\n'+
                            '\t\tredirect(\'<?=$table_active?>/index\');\n'+
                            '\t} else {\n';
        controllerView += '\t\t$data = [\n'+
                            '\t\t\t\'title\' => \'Edit <?=$table_active?>\',\n'+
                            '\t\t\t\'main_title\' => \'\',\n'+
                            '\t\t\t\'muted_title\' => \'\',\n'+
                            '\t\t\t\'breadcrumbs\' => \'\',\n'+
                            '\t\t\t\'content\' => \'siswa/edit\',\n'+
                            '\t\t\t\'templates\' => [\'datepicker\']\n'+
                            '\t\t];\n';
        controllerView += '\t\t$data[\'<?=$table_active?>\'] = $this-><?=$table_active?>_m->get([\'id\' => $id]);\n';
        controllerView += '\t\tif($id == null || count($data[\'<?=$table_active?>\'])<1){\n'+
                            '\t\t\tredirect(base_url(\'<?=$table_active?>\'));\n'+
                            '\t\t}\n';
        controllerView += '\t\t$data[\'<?=$table_active?>\'] = $data[\'<?=$table_active?>\'][0];\n';
        controllerView += '\t\t$this->load->view(\'template\',$data);\n\t}\n';
        controllerView+= '}';
        controllerView += '\n\nfunction delete($id){\n';
        controllerView += '\tif(!empty($id)){\n';
        controllerView += '\t\t$this-><?=$table_active?>_m->delete($id);\n'+
                            '\t\t//hredirect(\'<?=$table_active?>/index\');\n'+
                            '\t}\n';               
        controllerView+= '}';

        addView += '</form>';
        editView += '</form>';
        $('#add_gv').html(addView);
        $('#edit_gv').html(editView);
        $('#model_gv').html(modelView);
        $('#controller_gv').html(controllerView);
        tableView += '</table>';
        $('#view_gv').html(tableView);
        $('#generate_view').modal('show');

    }

</script>