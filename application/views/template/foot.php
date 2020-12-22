<div class="page-footer">
	<div class="page-footer-inner">
		 2020 &copy; <a href="#" target="_blank">Elevens</a> . Made With <i class="icon-heart"></i>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?=base_url()?>assets/global/plugins/respond.min.js"></script>
<script src="<?=base_url()?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<script src="<?=base_url()?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?=base_url()?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="<?=base_url()?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>

<?php foreach($template as $key => $val):
    if($val == 'datatables'){
        echo '<script type="text/javascript" src="'.base_url().'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>';
        echo '<script type="text/javascript" src="'.base_url().'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>';
        echo '<script src="'.base_url().'assets/admin/pages/scripts/table-advanced.js"></script>';
        echo '<script>TableAdvanced.init();</script>';
    }
endforeach; ?>
<script type="text/javascript" src="<?=base_url()?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url()?>assets/admin/pages/scripts/components-pickers.js"></script>

<script>

    function change_tahun_ajaran(id){
        $.ajax({
            url : "<?=base_url('pengaturan/set_tahun_ajaran/')?>"+id,
        });
        location.reload();
    }

    jQuery(document).ready(function() {    
        Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
        ComponentsPickers.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>