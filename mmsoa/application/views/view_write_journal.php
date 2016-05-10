<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-发布坐班日志</title>
    <?php $this->load->view('view_keyword'); ?>
    
    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">
    
    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/iCheck/custom.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/simditor/simditor.css' ?>" rel="stylesheet">
    
    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">
        
    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/plugins/summernote/summernote.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/plugins/summernote/summernote-bs3.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

</head>

<body onload="startTime()">
    <div id="wrapper">
        <?php $this->load->view('view_nav'); ?>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php $this->load->view('view_header'); ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2 id="time"></h2>
                    <ol class="breadcrumb">
                        <li>
                            MOA
                        </li>
                        <li>
                            	坐班日志
                        </li>
                        <li>
                            <strong>发布</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>多媒体组长坐班日志 </h5>
                            </div>
                            <div class="ibox-content">
                                <form class="form-horizontal">
                                
                                	<div class="form-group">
	                                	<div class="col-sm-3">
	                                    	<label class="col-sm-11 col-sm-offset-1 control-label">组别</label>
                                    	</div>
										<div class="col-sm-7">
										    <label class="radio-inline" style="font-size: 14px;">
										        <input type="radio" checked="" value="1" id="group_A" name="group_radio"> A 组</label>
										    <label class="radio-inline" style="font-size: 14px;">
										        <input type="radio" value="2" id="group_B" name="group_radio"> B 组</label>
										</div>
									</div>
									
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="form-group">
                                    	<div class="col-sm-3">
                                    		</br>
                                    		</br>
	                                    	<label class="col-sm-11 col-sm-offset-1 control-label">早检情况</label>
                                    	</div>
										<div class="col-sm-7">
										    <textarea name="journal_morning" id="text_morning" class="form-control" placeholder="请输入早检情况" style="height: 100px;"></textarea>
										</div>
									</div>
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="form-group">
                                    	<div class="col-sm-3">
                                    		</br>
                                    		</br>
	                                    	<label class="col-sm-11 col-sm-offset-1 control-label">午检情况</label>
                                    	</div>
										<div class="col-sm-7">
										    <textarea name="journal_noon" id="text_noon" class="form-control" placeholder="请输入午检情况" style="height: 100px;"></textarea>
										</div>
									</div>
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="form-group">
                                    	<div class="col-sm-3">
                                    		</br>
                                    		</br>
	                                    	<label class="col-sm-11 col-sm-offset-1 control-label">晚检情况</label>
                                    	</div>
										<div class="col-sm-7">
										    <textarea name="journal_evening" id="text_evening" class="form-control" placeholder="请输入晚检情况" style="height: 100px;"></textarea>
										</div>
									</div>
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="form-group">
	                                    <div class="col-sm-3">
                                    		</br>
                                    		</br>
                                    		</br>
	                                    	<label class="col-sm-11 col-sm-offset-1 control-label">优秀助理</label>
                                    	</div>
										<div class="col-sm-7">
											<div class="input-group">
												<select id="select_best" data-placeholder="请选择优秀助理" class="chosen-select" multiple style="width:594px;" tabindex="4">
													<?php for ($i = 0; $i < count($wid_list); $i++) { ?>
														<option value="<?php echo $wid_list[$i]; ?>" hassubinfo="true"><?php echo $name_list[$i]; ?></option>
													<?php } ?>
	                                        	</select>
											</div>
											<div>
											    <textarea name="journal_best" id="text_best" class="form-control" placeholder="请输入优秀助理的表现" style="height: 100px;"></textarea>
											</div>
                                    	</div>
									</div>
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="form-group">
	                                    <div class="col-sm-3">
                                    		</br>
                                    		</br>
                                    		</br>
	                                    	<label class="col-sm-11 col-sm-offset-1 control-label">异常助理</label>
                                    	</div>
										<div class="col-sm-7">
											<div class="input-group">
												<select id="select_bad" data-placeholder="请选择异常助理" class="chosen-select" multiple style="width:594px;" tabindex="4">
		                                            <?php for ($i = 0; $i < count($wid_list); $i++) { ?>
														<option value="<?php echo $wid_list[$i]; ?>" hassubinfo="true"><?php echo $name_list[$i]; ?></option>
													<?php } ?>
	                                        	</select>
											</div>
											<div>
											    <textarea name="journal_bad" id="text_bad" class="form-control" placeholder="请输入异常助理的表现" style="height: 100px;"></textarea>
											</div>
                                    	</div>
									</div>
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="form-group">
	                                    <div class="col-sm-3">
                                    		</br>
                                    		</br>
	                                    	<label class="col-sm-11 col-sm-offset-1 control-label">总结</label>
                                    	</div>
										<div class="col-sm-7">
										    <textarea name="journal_summary" id="text_summary" class="form-control" placeholder="请输入坐班总结" style="height: 100px;"></textarea>
										</div>
									</div>
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-5">
                                            <button class="btn btn-primary" type="submit" id="submit_journal" 
                                            data-toggle="modal" data-target="#myModal">发布</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('view_footer'); ?>
        </div>
    </div>
    
    <?php $this->load->view('view_modal'); ?>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/journal_in.js' ?>"></script>
    
    <!-- nav item active -->
	<script>
		$(document).ready(function () {
			$("#active-journal").addClass("active");
			$("#active-writeJournal").addClass("active");
			$("#mini").attr("href", "writeJournal#");
		});
	</script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>
    
    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>

    <!-- iCheck -->
    <script src="<?=base_url().'assets/js/plugins/iCheck/icheck.min.js' ?>"></script>
    
    <!-- Chosen -->
    <script src="<?=base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>
    
    <!-- simditor -->
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/simditor/module.js' ?>"></script>
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/simditor/uploader.js' ?>"></script>
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/simditor/hotkeys.js' ?>"></script>
    <script type="text/javascript" src="<?=base_url().'assets/js/plugins/simditor/simditor.js' ?>"></script>
    
    <!-- SUMMERNOTE -->
    <script src="<?=base_url().'assets/js/plugins/summernote/summernote.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/summernote/summernote-zh-CN.js' ?>"></script>
    
    <script>
    
        $(document).ready(function () {
            /* Radio */
            $('#group_A').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('#group_B').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            
            
        });

        /* Chosen */
        var config = {
                '.chosen-select': {
                    // 实现中间字符的模糊查询
                	search_contains: true,
                	no_results_text: "没有找到"
                },
                '.chosen-select-deselect': {
                    allow_single_deselect: true
                },
                '.chosen-select-no-single': {
                    disable_search_threshold: 10
                },
                '.chosen-select-no-results': {
                    no_results_text: 'Oops, nothing found!'
                },
                '.chosen-select-width': {
                    width: "95%"
                }
            }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        
    </script>

</body>

</html>
