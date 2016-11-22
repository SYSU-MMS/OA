<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>MOA-查看故障汇总</title>
    <?php $this->load->view('view_keyword'); ?>

    <link href="<?=base_url().'assets/images/moa.ico' ?>" rel="shortcut icon">

    <link href="<?=base_url().'assets/css/bootstrap.min.css?v=3.4.0' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/chosen/chosen.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/dataTables/dataTables.bootstrap.css' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/animate.css' ?>" rel="stylesheet">
    <link href="<?=base_url().'assets/css/style.css?v=2.2.0' ?>" rel="stylesheet">

    <link href="<?=base_url().'assets/css/plugins/datetimepicker/bootstrap-datetimepicker.css' ?>" rel="stylesheet">

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
                            工作审查
                        </li>
                        <li>
                            <strong>故障汇总</strong>
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
                                <h5>查看故障情况</h5>
                                <span style="float: right;">
                                  <button type="button" data-toggle="modal" data-target="#myModal"
                                        name="new-problem-button" class="btn-xm btn-info calculate" onclick="newProblemButton();">
                                  新建故障条目
                                  </button>
                                </span>
                            </div>
                            <div class="ibox-content">
                                <div id="table_container">
                                    <table class="table table-striped table-bordered table-hover users-dataTable">
                                        <thead>
                                            <tr>
                                                <th>序号</th>
                                                <th>课室</th>
                                                <th>故障描述</th>
                                                <th>发生时间</th>
                                                <th>发现人</th>
                                                <th>解决时间</th>
                                                <th>解决人</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < count($problem_list); $i++) {
                                                $problem = $problem_list[$i];
                                            ?>
                                                <tr>
                                                    <td><?php echo $i + 1; ?></td>
                                                    <td><?php echo $problem->room ?></td>
                                                    <td><?php echo $problem->description ?></td>
                                                    <td><?php echo $problem->found_time ?></td>
                                                    <td><?php echo $problem->founder_name ?></td>
                                                    <td><?php
                                                        if($problem->solved_time == NULL)
                                                            echo "<span style=\"color:red;\">待解决</span>";
                                                        else
                                                            echo $problem->solved_time;
                                                    ?></td>
                                                    <td><?php
                                                        if($problem->solve_name == NULL)
                                                            echo "<span style=\"color:red;\">待解决</span>";
                                                        else
                                                        echo $problem->solve_name;
                                                    ?></td>
                                                    <td><?php

                                                      if($problem->solved_time != NULL)
                                                          echo "<button type=\"test\" class=\"btn btn-m\" disabled >解决</button>";
                                                      else
                                                          echo  "<button type=\"button\" value=\"".$problem->pid."\"".
                                                                "  onclick=\"newSolveButton(this.value)\" class=\"btn btn-m btn-primary\"".
                                                                "  data-toggle=\"modal\" data-target=\"#myModal\" >解决".
                                                                "</button>";
                                                      ?>
                                                      <button type="button" value="<?php echo $problem->pid ?>"
                                                        onclick="deleteProblemButton(this.value)" class="btn btn-m btn-danger">
                                                        删除
                                                      </button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('view_footer'); ?>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10;">
  	    <div class="modal-dialog">
  	        <div class="modal-content" style="margin-top: 90px;">
  	            <div class="modal-header">
  	                <h4 class="modal-title" id="myModalLabelTitle"></h4>
  	            </div>
  	            <div id="modalBody" class="modal-body">
  	            </div>
  	        </div>
  	    </div>
  	</div>

    <!-- Mainly scripts -->
    <script src="<?=base_url().'assets/js/jquery-2.1.1.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/bootstrap.min.js?v=3.4.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/metisMenu/jquery.metisMenu.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/slimscroll/jquery.slimscroll.min.js' ?>"></script>
    <script src="<?=base_url().'assets/js/problem.js' ?>"></script>

    <!-- nav item active -->
    <script>
        $(document).ready(function () {
            $("#active-workReview").addClass("active");
            $("#active-problem").addClass("active");
            $("#mini").attr("href", "problem#");
        });
    </script>

    <!-- Custom and plugin javascript -->
    <script src="<?=base_url().'assets/js/hplus.js?v=2.2.0' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/pace/pace.min.js' ?>"></script>

    <!-- Dynamic date -->
    <script src="<?=base_url().'assets/js/dynamicDate.js' ?>"></script>

    <!-- Chosen -->
    <script src="<?=base_url().'assets/js/plugins/chosen/chosen.jquery.js' ?>"></script>

    <!-- Date time picker -->
    <script src="<?=base_url().'assets/js/plugins/datetimepicker/bootstrap-datetimepicker.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/datetimepicker/bootstrap-datetimepicker.zh-CN.js' ?>"></script>

    <!-- Data Tables -->
    <script src="<?=base_url().'assets/js/plugins/dataTables/jquery.dataTables.js' ?>"></script>
    <script src="<?=base_url().'assets/js/plugins/dataTables/dataTables.bootstrap.js' ?>"></script>

    <script>
        $(document).ready(function () {

            // dataTable
            $('.users-dataTable').dataTable({
                "iDisplayLength": 10
            });

            // /* Calendar */
            // $('#start_dtp').datetimepicker({
            //     format: 'yyyy-mm-dd hh:ii',
            //     language: 'zh-CN',
            //     weekStart: 1,
            //     todayBtn:  1,
            //     autoclose: 1,
            //     todayHighlight: 1,
            //     startView: 2,
            //     minView: 0,
            //     forceParse: 1
            // });
            // $('#end_dtp').datetimepicker({
            //     format: 'yyyy-mm-dd hh:ii',
            //     language: 'zh-CN',
            //     weekStart: 1,
            //     todayBtn:  1,
            //     autoclose: 1,
            //     todayHighlight: 1,
            //     startView: 2,
            //     minView: 0,
            //     forceParse: 1
            // });

        });

        /* Chosen name */
        var config = {
                '.chosen-select-classroom': {
                    // 实现中间字符的模糊查询
                    search_contains: true,
                    no_results_text: "没有找到",
                    disable_search_threshold: 10
                },
                '.chosen-select-classroom-deselect': {
                    allow_single_deselect: true
                },
                '.chosen-select-classroomt-no-single': {
                    disable_search_threshold: 10
                },
                '.chosen-select-classroom-no-results': {
                    no_results_text: 'Oops, nothing found!'
                },
                '.chosen-select-classroom-width': {
                    width: "95%"
                }
            }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }

        /* Chosen classroom */
        var config = {
                '.chosen-select-name': {
                    // 实现中间字符的模糊查询
                    search_contains: true,
                    no_results_text: "没有找到",
                    disable_search_threshold: 10
                },
                '.chosen-select-classroom-name': {
                    allow_single_deselect: true
                },
                '.chosen-select-name-no-single': {
                    disable_search_threshold: 10
                },
                '.chosen-select-name-no-results': {
                    no_results_text: 'Oops, nothing found!'
                },
                '.chosen-select-name-width': {
                    width: "95%"
                }
            }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }


    </script>

</body>

</html>
