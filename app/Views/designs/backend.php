<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
    
    $log_name = $this->Crud->read_field('id', $log_id, 'user', 'fullname');
    $log_role_id = $this->Crud->read_field('id', $log_id, 'user', 'role_id');
	$log_role = strtolower($this->Crud->read_field('id', $log_role_id, 'access_role', 'name'));
    $log_user_img_id = $this->Crud->read_field('id', $log_id, 'user', 'img_id');
    $log_user_img = $this->Crud->image($log_user_img_id, 'big');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="author" content="<?=app_name;?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?=site_url();?>assets/logo.png">
    <!-- Page Title  -->
    <title><?=$this->renderSection('title');?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?=site_url();?>assets/backend/css/main.css?v=<?=time();?>"">
    
    <link id="skin-default" rel="stylesheet" href="<?=site_url();?>assets/backend/css/skins/theme-blue.css">
    <link id="skin-default" rel="stylesheet" href="<?=site_url();?>assets/backend/css/theme.css?v=<?=time();?>">
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="<?=site_url('dashboard');?>" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img logo-img-lg" src="<?=site_url();?>assets/logo.png " srcset="<?=site_url();?>assets/logo.png 2x" width="" alt="logo">
                            <img class="logo-dark logo-img logo-img-lg" src="<?=site_url();?>assets/logo.png " srcset="<?=site_url();?>assets/logo.png 2x" width="" alt="logo-dark">
                        </a>
                    </div>
                    <div class="nk-menu-trigger me-n2">
                        <a href="javascript:;" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="javascript:;" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                </div>

                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <!-- Dynamic Menu Items --> 
                                <?php
                                    $menu = '';
                                    $modules = $this->Crud->read_single_order('parent', 0, 'access_module', 'priority', 'asc');
                                    if(!empty($modules)) {
                                        foreach($modules as $mod) {
                                            // get level 2
                                            $level2 = '';
                                            if($this->Crud->mod_read($log_role_id, $mod->link) == 1) {
                                                $mod_level2 = $this->Crud->read_single_order('parent', $mod->id, 'access_module', 'priority', 'asc');
                                                if(!empty($mod_level2)) {
                                                    $open = false;
                                                    foreach($mod_level2 as $mod2) {
                                                        if($this->Crud->mod_read($log_role_id, $mod2->link) == 1) {
                                                            // add parent to first
                                                            if(empty($level2)) {
                                                                // $level2 = '
                                                                //     <li>
                                                                //         <a href="'.site_url($mod->link).'">'.$mod->name.'</a>
                                                                //     </li>
                                                                // ';
                                                            }
                                                            if($page_active == $mod2->link){$open = true; $a_active = 'active';} else {$a_active = '';}
                                                            
                                                            // add the rest
                                                            $level2 .= '
                                                                <li class="nk-menu-item '.$a_active.'">
                                                                    <a href="'.site_url($mod2->link).'" class="nk-menu-link">'.$mod2->name.'</a>
                                                                </li>
                                                            '; 
                                                        }
                                                    }
                                                    
                                                    $level2 = '
                                                        <ul class="nk-menu-sub">
                                                            '.$level2.'
                                                        </ul>
                                                    ';
                                                }

                                                if($page_active == $mod->link){$a_active = 'active';} else {$a_active = '';}
                                                if($level2){
                                                    $topmenu = 'has-sub';
                                                    $submenu = 'nk-menu-toggle';
                                                    $dlink = 'javascript:;';
                                                    $menu_arrow = '<span class="arrow"><i class="arrow-icon"></i></span>';
                                                } else {
                                                    $topmenu = '';
                                                    $submenu = ''; 
                                                    $dlink = site_url($mod->link);
                                                    $menu_arrow = '';
                                                }

                                                $menu .= '
                                                    <li class="nk-menu-item '.$topmenu .' '.$a_active.'">
                                                        <a class="nk-menu-link '.$submenu.'" href="'.$dlink.'">
                                                            <span class="nk-menu-icon">
                                                                <em class="'.$mod->icon.'"></em>
                                                            </span>
                                                            <span class="nk-menu-text">'.$mod->name.'</span>
                                                            '.$menu_arrow.'
                                                        </a>
                                                        '.$level2.'
                                                    </li>
                                                ';
                                            }
                                        }
                                    }

                                    echo $menu;
                                ?>
                                
                                <!-- Modules and Roles -->
                                <?php if($log_role == 'developer') { ?>
                                <li class="nk-menu-item has-sub">
                                    <a class="nk-menu-link nk-menu-toggle" href="javascript:;">
                                        <span class="nk-menu-icon"><em class="icon ni ni-setting-alt-fill"></em></span>
                                        <span class="nk-menu-text">Access Roles</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item <?php if($page_active=='module') {echo 'active';} ?>">
                                            <a href="<?php echo site_url('settings/modules'); ?>" class="nk-menu-link">Modules</a>
                                        </li>
                                        <li class="nk-menu-item <?php if($page_active=='role') {echo 'active';} ?>">
                                            <a href="<?php echo site_url('settings/roles'); ?>" class="nk-menu-link">Roles</a>
                                        </li>
                                        <li class="nk-menu-item <?php if($page_active=='access') {echo 'active';} ?>">
                                            <a href="<?php echo site_url('settings/access'); ?>" class="nk-menu-link">Access CRUD</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="nk-wrap ">
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="javascript:;" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="<?=site_url('dashboard');?>" class="logo-link nk-sidebar-logo">
                                    <img class="logo-light logo-img logo-img-lg" src="<?=site_url();?>assets/logo.png?v=0" srcset="<?=site_url();?>assets/logo.png?v=0 2x" width="" alt="logo">
                                    <img class="logo-dark logo-img logo-img-lg" src="<?=site_url();?>assets/logo.png?v=0" srcset="<?=site_url();?>assets/logo.png?v=0 2x" width="" alt="logo-dark">
                                </a>
                            </div>
                            <div class="nk-header-search ms-3 ms-xl-0">
                                <!-- <em class="icon ni ni-search"></em>
                                <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search anything"> -->
                            </div>
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <!-- <li class="dropdown language-dropdown d-none d-sm-block me-n1">
                                        <a href="javascript:;" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="quick-icon border border-light">
                                                <img class="icon" src="<?=site_url();?>assets/backend/images/flags/english-sq.png" alt="">
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-s1">
                                            <ul class="language-list">
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="<?=site_url();?>assets/backend/images/flags/english.png" alt="" class="language-flag">
                                                        <span class="language-name">English</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="<?=site_url();?>assets/backend/images/flags/spanish.png" alt="" class="language-flag">
                                                        <span class="language-name">Español</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="<?=site_url();?>assets/backend/images/flags/french.png" alt="" class="language-flag">
                                                        <span class="language-name">Français</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="<?=site_url();?>assets/backend/images/flags/turkey.png" alt="" class="language-flag">
                                                        <span class="language-name">Türkçe</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li> -->

                                    <!-- <li class="dropdown chats-dropdown hide-mb-xs">
                                        <a href="javascript:;" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="icon-status icon-status-na"><em class="icon ni ni-comments"></em></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">Recent Chats</span>
                                                <a href="javascript:;">Setting</a>
                                            </div>
                                            <div class="dropdown-body">
                                                <ul class="chat-list">
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="javascript:;">
                                                            <div class="chat-media user-avatar">
                                                                <span>IH</span>
                                                                <span class="status dot dot-lg dot-gray"></span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Iliash Hossain</div>
                                                                    <span class="time">Now</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">You: Please confrim if you got my last messages.</div>
                                                                    <div class="status delivered">
                                                                        <em class="icon ni ni-check-circle-fill"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="chat-item is-unread">
                                                        <a class="chat-link" href="javascript:;">
                                                            <div class="chat-media user-avatar bg-pink">
                                                                <span>AB</span>
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Abu Bin Ishtiyak</div>
                                                                    <span class="time">4:49 AM</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">Hi, I am Ishtiyak, can you help me with this problem ?</div>
                                                                    <div class="status unread">
                                                                        <em class="icon ni ni-bullet-fill"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="javascript:;">
                                                            <div class="chat-media user-avatar">
                                                                <img src="<?=site_url();?>assets/backend/images/avatar/b-sm.jpg" alt="">
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">George Philips</div>
                                                                    <span class="time">6 Apr</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">Have you seens the claim from Rose?</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="html/lms/message.html">
                                                            <div class="chat-media user-avatar user-avatar-multiple">
                                                                <div class="user-avatar">
                                                                    <img src="<?=site_url();?>assets/backend/images/avatar/c-sm.jpg" alt="">
                                                                </div>
                                                                <div class="user-avatar">
                                                                    <span>AB</span>
                                                                </div>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Softnio Group</div>
                                                                    <span class="time">27 Mar</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">You: I just bought a new computer but i am having some problem</div>
                                                                    <div class="status sent">
                                                                        <em class="icon ni ni-check-circle"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="javascript:;">
                                                            <div class="chat-media user-avatar">
                                                                <img src="<?=site_url();?>assets/backend/images/avatar/a-sm.jpg" alt="">
                                                                <span class="status dot dot-lg dot-success"></span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Larry Hughes</div>
                                                                    <span class="time">3 Apr</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">Hi Frank! How is you doing?</div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="chat-item">
                                                        <a class="chat-link" href="javascript:;">
                                                            <div class="chat-media user-avatar bg-purple">
                                                                <span>TW</span>
                                                            </div>
                                                            <div class="chat-info">
                                                                <div class="chat-from">
                                                                    <div class="name">Tammy Wilson</div>
                                                                    <span class="time">27 Mar</span>
                                                                </div>
                                                                <div class="chat-context">
                                                                    <div class="text">You: I just bought a new computer but i am having some problem</div>
                                                                    <div class="status sent">
                                                                        <em class="icon ni ni-check-circle"></em>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-foot center">
                                                <a href="javascript:;">View All</a>
                                            </div>
                                        </div>
                                    </li> -->

                                    <li class="dropdown notification-dropdown">
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">Notifications</span>
                                                <a href="javascript:;">Mark All as Read</a>
                                            </div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                    <!-- <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                            <div class="dropdown-foot center">
                                                <a href="javascript:;">View All</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown user-dropdown">
                                        <a href="javascript:;" class="dropdown-toggle me-n1" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-xl-block">
                                                    <div class="user-status user-status-active"><?=ucwords($log_role);?></div>
                                                    <div class="user-name dropdown-indicator"><?=$log_name;?></div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <img alt="" height="40px" src="<?=site_url($log_user_img);?>" />
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?=$log_name;?></span>
                                                        <span class="sub-text"><?=ucwords($log_role);?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="<?=site_url('profile');?>"><em class="icon ni ni-user-alt"></em><span>Profile</span></a></li>
                                                    <!-- <li><a href="html/lms/admin-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a>
                                                    </li>
                                                    <li><a href="html/lms/admin-profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a>
                                                    </li> -->
                                                    <li><a class="dark-switch" href="javascript:;"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="<?=site_url('auth/logout');?>"><em class="icon ni ni-signout"></em><span>Sign out</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?=$this->renderSection('content');?>
                
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; <?=date('Y');?> <?=app_name;?> | All rights reserved.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-center fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div style="padding:10px;">
                    <a href="javascript:;" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                </div>
            
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
    
    <script src="<?=site_url();?>assets/backend/js/bundle.js"></script>
    <script src="<?=site_url();?>assets/backend/js/scripts.js"></script>
    <?php if($page_active == 'schedule'){?>
        <script src="<?php echo base_url(); ?>/assets/backend/js/libs/fullcalendar.js"></script>
        <script src="<?php echo base_url(); ?>/assets/backend/js/apps/calendar.js?v=<?=time();?>"></script>
    <?php } ?>
    <link rel="stylesheet" href="<?=site_url();?>assets/backend/css/editors/tinymce.css">
    <script src="<?=site_url();?>assets/backend/js/libs/editors/tinymce.js"></script>
    
    <link rel="stylesheet" href="<?=site_url();?>assets/backend/css/editors/summernote.css?ver=3.0.3">
    <script src="<?=site_url();?>assets/backend/js/libs/editors/summernote.js?ver=3.0.3"></script>
    <script src="<?=site_url();?>assets/backend/js/editors.js"></script>
    
    <?=$this->renderSection('scripts');?>

    <?php if(!empty($table_rec)){ ?>
        <!-- <script src="<?=site_url();?>assets/backend/vendors/datatables/jquery.dataTables.min.js"></script>
        <script src="<?=site_url();?>assets/backend/vendors/datatables/dataTables.bootstrap.min.js"></script>
        <script src="<?=site_url();?>assets/backend/js/pages/datatables.js"></script> -->
        <script type="text/javascript">
            $(document).ready(function() {
                //datatables
                var table = $('#dtable').DataTable({ 
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [<?php if(!empty($order_sort)){echo '['.$order_sort.']';} ?>], //Initial order.
                    "language": {
                        "processing": "<i class='anticon anticon-loading' aria-hidden='true'></i> Processing... please wait"
                    },
                    // "pagingType": "full",
            
                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        url: "<?php echo site_url($table_rec); ?>",
                        type: "POST",
                        complete: function() {
                            $.getScript('<?php echo site_url(); ?>assets/backend/js/jsmodal.js');
                        }
                    },
            
                    //Set column definition initialisation properties.
                    "columnDefs": [
                        { 
                            "targets": [<?php if(!empty($no_sort)){echo $no_sort;} ?>], //columns not sortable
                            "orderable": false, //set not orderable
                        },
                    ],
            
                });
            
            });
        </script>
    <?php } ?>
</body>
</html>