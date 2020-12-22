<?php

// pengganti {$ci}
// $ci =& get_instance(); 

function beginportlet($color='blue', $action){
    //sisipin ini bawah title buat caption
    //<div class="caption">{$title}</div>
    return '<div class="portlet box '.$color.'">
				<div class="portlet-title">
                    <div class="actions">
                        '.$action.'
					</div>
				</div>';
}

function portlet($content, $is_form = FALSE){
    $form = $is_form != FALSE ? $form='form' : '';
    return '<div class="portlet-body '.$form.'">
            '.$content.'
        </div>';
}

function endportlet(){
    return '</div>';
}

function button($text, $href='javascript:;', $args=array()){
    $size = !empty($args['size']) ? $args['size'] : 'xs';
    $icon = !empty($args['icon']) ? $args['icon'] : 'plus';
    $color = !empty($args['color']) ? $args['color'] : 'blue';
    return '<a href="'.$href.'" class="btn '.$size.' '.$color.'">
                <i class="fa fa-'.$icon.'"></i>&nbsp;&nbsp;'.$text.'
            </a>';
}

function button_icon($href='javascript:;', $args=array()){
    $size = !empty($args['size']) ? $args['size'] : 'xs';
    $icon = !empty($args['icon']) ? $args['icon'] : 'plus';
    $color = !empty($args['color']) ? $args['color'] : 'blue';
    return '<a href="'.$href.'" class="btn btn-xs '.$size.' '.$color.'">
                <i class="fa fa-'.$icon.'"></i>
            </a>';
}

function datatable($head, $record){
    $table = '';
    $table.='<table class="table table-striped table-hover table-condensed" id="datatable">';
    $table.='<thead>';
    $table.='<tr>';
    foreach($head as $key => $val){
        $table.='<th>'.$val.'</th>';
    }
    $table.='</tr>';
    $table.='</thead>';
    $table.='<tbody>';
    foreach($record as $key => $val){
        $table.='<tr>';
        foreach($val as $vkey => $vval){
            $table.='<td width="5%" style="white-space:nowrap">'.$vval.'</td>';
        }
        $table.='</tr>';
    }
    $table.='</tbody>';
    $table.='</table>';
    return $table;
}

function begin_form($action, $enctype="", $method="post"){
    return '<form action="'.$action.'" method="'.$method.'" enctype="'.$enctype.'" autocomplete="off">';
}

function end_form(){
    return "</form>";
}

function input_text($label, $name, $value=''){
    $ci =& get_instance(); 
    $value = !empty($ci->input->post($name)) ? $ci->input->post($name) : $value;
    return '<div class="form-group">
            <label> '.$label.' </label>
            <input type="text" name="'.$name.'" class="form-control" placeholder="Masukan '.$label.' disini . ." value="'.$value.'">
            <span class="help-block text-danger">'.form_error($name).'</span>
        </div>';
}

function input_text_disable($label, $name, $value=''){
    $ci =& get_instance(); 
    $value = !empty($ci->input->post($name)) ? $ci->input->post($name) : $value;
    return '<div class="form-group">
            <label> '.$label.' </label>
            <input type="text" name="'.$name.'" class="form-control" placeholder="Masukan '.$label.' disini . ." value="'.$value.'" disabled>
            <span class="help-block text-danger">'.form_error($name).'</span>
        </div>';
}

function input_hidden($name, $value=''){
    return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
}

function input_number($label, $name, $value=''){
    $ci =& get_instance(); 
    $value = !empty($ci->input->post($name)) ? $ci->input->post($name) : $value;
    return '<div class="form-group">
            <label> '.$label.' </label>
            <input type="number" name="'.$name.'" class="form-control" placeholder="Masukan '.$label.' disini . ." value="'.$value.'">
            <span class="help-block text-danger">'.form_error($name).'</span>
        </div>';
}

function input_password($label, $name, $value=''){
    $ci =& get_instance(); 
    $value = !empty($ci->input->post($name)) ? $ci->input->post($name) : $value;
    return '<div class="form-group">
            <label> '.$label.' </label>
            <input type="password" name="'.$name.'" class="form-control" placeholder="Masukan '.$label.' disini . ." value="'.$value.'">
            <span class="help-block text-danger">'.form_error($name).'</span>
        </div>';
}

function input_textarea($label, $name, $value=''){
    $ci =& get_instance(); 
    $value = !empty($ci->input->post($name)) ? $ci->input->post($name) : $value;
    return '<div class="form-group">
            <label> '.$label.' </label>
            <textarea name="'.$name.'" class="form-control" placeholder="Masukan '.$label.' disini . .">'.$value.'</textarea>
            <span class="help-block text-danger">'.form_error($name).'</span>
        </div>';
}

function input_radio($label, $name, $data, $value=''){
    $option = '';
    $ci =& get_instance(); 
    foreach($data as $key => $val){
        if(empty($ci->input->post($name))){
            $checked = !empty($value) && $value == $val['id'] ? 'checked' : '';
        } else {
            $checked = $ci->input->post($name) == $val['id'] ? 'checked' : '';
        }
        $option.= '<label>';
        $option.= '<input type="radio" name="'.$name.'" value="'.$val['id'].'" '.$checked.'> '.$val['nama'].'</br/>';
        $option.= '</label>';
    }
    return '<div class="form-group">
            <label> '.$label.' </label><br/>
            <div class="radio-list">'
                .$option.
            '</div>
            <span class="help-block text-danger">'.form_error($name).'</span>
        </div>';
}

function input_date($label, $name, $value='', $start='2000-03-01'){
    $ci =& get_instance(); 
    $value = !empty($ci->input->post($name)) ? $ci->input->post($name) : $value;
    return '<div class="form-group">
            <label> '.$label.' </label><br/>
            <div class="input-group input-medium date date-picker" data-date="'.$start.'" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
				<input type="text" class="form-control" name="'.$name.'" value="'.$value.'" readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div>
            <span class="help-block text-danger">'.form_error($name).'</span>
        </div>';
}

function input_select($label, $name, $data, $value=''){
    $ci =& get_instance();
    $option = '';
    foreach($data as $key => $val){
        if(empty($ci->input->post($name))){
            $selected = !empty($value) && $value == $val['id'] ? 'selected="selected"' : '';
        } else {
            $selected = $ci->input->post($name) == $val['id'] ? 'selected="selected"' : '';
        }
        $option.= '<option value="'.$val['id'].'" '.$selected.'> '.$val['nama'].'</option>';
    }
    return '<div class="form-group">
            <label> '.$label.' </label><br/>
            <select name="'.$name.'" class="form-control">'
                .$option.
            '</select>
            <span class="help-block text-danger">'.form_error($name).'</span>
        </div>';
}

function begin_form_body(){
    return '<div class="form-body">';
}

function end_form_body(){
    return '</div>';
}

function begin_form_actions(){
    return '<div class="form-actions">';
}

function end_form_actions(){
    return '</div>';
}

function input_submit($value, $color="blue"){
    return '<button type="submit" class="btn '.$color.'"><i class="fa fa-check"></i>&nbsp;&nbsp;'.$value.'</button>';
}

function image($img, $style='width:20%', $loc="assets/image/", $default="default.png"){
    if(empty($img)){
        $img = $default;
    }
    return '<img src="'.base_url($loc.$img).'" style="'.$style.'">';
}

function alert_flashdata($flashdata){
    $ci =& get_instance();
    if(!empty($ci->session->flashdata($flashdata))){
        echo '<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                '.$ci->session->flashdata($flashdata).'
            </div>';
    }
}