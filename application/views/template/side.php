<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				
				<li class="start ">
					<a href="<?=base_url()?>">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
                    </a>
                </li>
                <?php foreach($sidemenu['group'] as $gkey => $gval) :
                    echo '<li class="heading">
                            <h3 class="uppercase">'.$gval['title'].'</h3>
                        </li>';
                    foreach($sidemenu['menu'] as $mkey => $mval):
                        $subm_count = array_count_values(array_column($sidemenu['sub'], 'menu'))[$mval['id']];
                        $m_arrow = '';
                        $m_open = '';
                        $m_active = '';
                        if(!empty($breadcrumbs['menu'])){
                            if($breadcrumbs['menu'][0]['id'] == $mval['id']){
                                $m_open = 'open active';
                                $m_active = 'open';
                            }
                        } else {
                            if(!empty($breadcrumbs['main'])){
                                if(!empty($this->uri->segment(1)) && $breadcrumbs['main'][0]['id'] == $mval['id']){
                                    $m_open = 'open active';
                                }
                            }
                        }
                        if($subm_count > 0)
                            $m_arrow = '<span class="arrow '.$m_active.'"></span>';
                        echo '<li class="'.$m_open.'">
                                <a href="javascript:;">
                                <i class="'.$mval['icon'].'"></i>
                                <span class="title">'.$mval['title'].'</span>
                                    '.$m_arrow.'
                                </a>';
                            if($subm_count > 0){
                                echo '<ul class="sub-menu">';
                                foreach($sidemenu['sub'] as $skey => $sval){
                                    $m_open = '';
                                    if(!empty($breadcrumbs['main'])){
                                        if($breadcrumbs['main'][0]['id'] == $sval['id'])
                                            $m_open = 'open';
                                    }
                                    if($sval['menu'] == $mval['id']){
                                        echo '<li class="'.$m_open.'">
                                                <a href="'.base_url($sval['url']).'">'.$sval['title'].'</a>
                                            </li>';
                                    }
                                }
                                echo '</ul>';
                            }
                        echo '</li>';
                    endforeach;
                endforeach; ?>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			<?=$title?> <small><?=(ENVIRONMENT === 'development') ? 'Page Rendered In {elapsed_time} S' : ''?></small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="<?=base_url()?>">Home</a>
						<i class="fa fa-angle-right"></i>
                    </li>
                    <?php if($breadcrumbs && !empty($this->uri->segment(1))):
                        if(!empty($breadcrumbs['menu'])){
                            $bc_more = '';
                            if(!empty($breadcrumbs['main']))
                                $bc_more = '<i class="fa fa-angle-right"></i>';
                            echo '<li>
                                    <i class="'.$breadcrumbs['menu'][0]['icon'].'"></i>
                                    <a href="">'.$breadcrumbs['menu'][0]['title'].'</a>
                                    '.$bc_more.'
                                </li>';
                            if(!empty($breadcrumbs['main'])){
                                echo '<li>
                                    <a href="'.base_url($breadcrumbs['main'][0]['url']).'">'.$breadcrumbs['main'][0]['title'].'</a>
                                </li>';    
                            }
                        } else {
                            if(!empty($breadcrumbs['main'])){
                                echo '<li>
                                        <i class="'.$breadcrumbs['main'][0]['icon'].'"></i>
                                        <a href="'.base_url($breadcrumbs['main'][0]['url']).'">'.$breadcrumbs['main'][0]['title'].'</a>
                                    </li>';
                            }
                        }
                    endif; ?>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height green dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						<i class="icon-calendar"></i>&nbsp;&nbsp; Tahun Ajaran : <?=$this->session->userdata('tahun_ajaran_aktif')?> <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
                            <?php foreach($tahun_ajaran as $key => $val):
                                echo '<li onclick="change_tahun_ajaran('.$val['id'].')"><a href="javascript:void(0)"> '.$val['nama'].' </a></li>';
                            endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<?php $this->load->view($content)?>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>