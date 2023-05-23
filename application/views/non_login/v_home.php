<?php
$this->load->view('sistem/v_breadcrumb');
?>
<div class="page-content">
    <div class="page-header hide">
        <h1>
            <?= $title[0] ?>
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <?= $this->session->flashdata('notif'); ?>
        </div><!-- /.col -->
    </div><!-- /.row -->
    <div class="col-xs-12 <?= ($this->session->userdata('groupid') != 4) ? '':'hide'?>">
        <p id="satu-spin" class="bigger-130 blue hide" align="center"><i class="fa fa-spinner fa-spin fa-fw fa-2x"></i> Loading . . .</p>
        <div class="widget-box transparent">
            <div class="widget-header">
                <h5 class="widget-title">
                    <i class="ace-icon fa fa-bar-chart"></i>
                    <span id="txt-akm">Aktivitas Kuliah Mahasiswa</span>
                </h5>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="widget-toolbar no-border">
                    <form id="akm-form" class="btn-group btn-overlap">
                        <select class="btn-xs center bolder" name="uts" id="uts" data-placeholder="--> Pilih Status <--">
                            <option value=""> --> Status UTS <-- </option>
                            <?php
                            foreach (load_array('st_opsi') as $val) {
                                echo '<option value="'.$val['id'].'">'.$val['txt'].'</option>';
                            }
                            ?>
                        </select>
                        <select class="btn-xs center bolder" name="uas" id="uas" data-placeholder="--> Pilih Status <--">
                            <option value=""> --> Status UAS <-- </option>
                            <?php
                            foreach (load_array('st_opsi') as $val) {
                                echo '<option value="'.$val['id'].'">'.$val['txt'].'</option>';
                            }
                            ?>
                        </select>
                        <select class="btn-xs center" name="tahun" id="tahun" data-placeholder="---> Pilih Tahun <---">
                            <option value=""> ---> Angkatan <--- </option>
                            <?php
                            foreach (load_array('tahun') as $val) {
                                echo '<option value="'.$val.'">'.$val.'</option>';
                            }
                            ?>
                        </select>
                        <select class="btn-xs center" name="fakultas" id="fakultas" data-placeholder="--> Pilih Fakultas <--">
                            <option value=""> ----> Fakultas <---- </option>
                            <?php
                            foreach ($fakultas['data'] as $val) {
                                echo '<option value="'.encode($val['fakultas']).'">'.$val['fakultas'].'</option>';
                            }
                            ?>
                        </select>
                    </form>
                    <div class="btn-group btn-overlap">
                        <button id="btn-akm" class="btn btn-white btn-primary btn-sm btn-bold">
                            <i class="fa fa-search-plus bigger-120"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main table-responsive">
                    <div id="container_akm" style="min-height: 600px;min-width: 600px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 <?= ($this->session->userdata('groupid') != 4) ? '':'hide'?>">
        <p id="dua-spin" class="bigger-130 blue hide" align="center"><i class="fa fa-spinner fa-spin fa-fw fa-2x"></i> Loading . . .</p>
        <div class="widget-box transparent">
            <div class="widget-header">
                <h5 class="widget-title">
                    <i class="ace-icon fa fa-bar-chart"></i>
                    <span id="txt-kelas">Kelas Kuliah</span>
                </h5>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
                <div class="widget-toolbar no-border">
                    <form id="kelas-form" class="btn-group btn-overlap">
                        <select class="btn-xs center" name="prodi" id="prodi" data-placeholder="--> Pilih Program Studi <--">
                            <option value=""> ----> Program Studi <---- </option>
                            <?php
                            foreach ($prodi['data'] as $val) {
                                echo '<option value="'.encode($val['id_prodi']).'">'.$val['nama_prodi'].'</option>';
                            }
                            ?>
                        </select>
                        <select class="btn-xs center" name="semester" id="semester" data-placeholder="--> Pilih Semester <--">
                            <option value=""> --> Semester <-- </option>
                            <?php
                            foreach (array(1,2,3,4,5,6,7,8) as $val) {
                                echo '<option value="' . $val . '">' . $val . '</option>';
                            }
                            ?>
                        </select>
                    </form>
                    <div class="btn-group btn-overlap">
                        <button id="btn-kelas" class="btn btn-white btn-primary btn-sm btn-bold">
                            <i class="fa fa-search-plus bigger-120"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main table-responsive">
                    <div id="container_kelas" style="min-height: 600px;min-width: 600px"></div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.page-content -->
<?php
load_js(array(
    'backend/assets/js/select2.js',
    'backend/highcharts.js'
));
?>
<script type="text/javascript">
    const module = "<?= site_url($module) ?>";
    
    $(function() {
        $(".select2").select2({allowClear: true});
        $(".select2-chosen").addClass("center");
    });
    $("#btn-akm").click(function () {
        grafik_akm();
    });
    $("#btn-kelas").click(function () {
        grafik_kelas();
    });
</script>
<script type="text/javascript">
    function grafik_akm() {
        $("#satu-spin").removeClass("hide");
        $.ajax({
            url: module + "/ajax/type/chart/source/akm",
            dataType: "json",
            type: "POST",
            data: $("#akm-form").serialize(),
            success: function (rs) {
                var series1 = []; 
                var series2 = [];
                rs.data.map((obj) => {
                    series1.push([obj.prodi, obj.awal]);
                    series2.push([obj.prodi, obj.akhir]);
                });
                chart_akm.series[0].update({ data: series2});
                chart_akm.series[1].update({ data: series1});
                chart_akm.setTitle(
                    {text: "Total AKM : [ <strong>"+ rs.total + "</strong> ] dari "+ rs.all +" Mahasiswa"}
                );
                chart_akm.setSubtitle({text: rs.range});
                chart_akm.redraw();
                $("#txt-akm").html(rs.range);
                $("#satu-spin").addClass("hide");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $("#satu-spin").addClass("hide");
                myNotif('Peringatan', 'Mohon ulangi, koneksi tidak stabil', 3);
            }
        });
    }
    function grafik_kelas() {
        $("#dua-spin").removeClass("hide");
        $.ajax({
            url: module + "/ajax/type/chart/source/kelas",
            dataType: "json",
            type: "POST",
            data: $("#kelas-form").serialize(),
            success: function (rs) {
                var series1 = []; 
                var series2 = [];
                var series3 = [];
                rs.data.map((obj) => {
                    series2.push([obj.name, obj.qty]);
                    series3.push([obj.name, obj.grade]);
                    series1.push([obj.name, obj.meet]);
                });
                chart_kelas.series[0].update({ data: series1});
                chart_kelas.series[1].update({ data: series2});
                chart_kelas.series[2].update({ data: series3});
                chart_kelas.setTitle(
                    {text: "Total : [ <strong>"+ rs.total + "</strong> ]"}
                );
                chart_kelas.setSubtitle({text: rs.range});
                chart_kelas.redraw();
                $("#txt-kelas").html(rs.range);
                $("#dua-spin").addClass("hide");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $("#dua-spin").addClass("hide");
                myNotif('Peringatan', 'Mohon ulangi, koneksi tidak stabil', 3);
            }
        });
    }
    const option_akm = {
        chart: {
            type: 'column',
            zoomType: 'x',
                events: {
                    load: grafik_akm()
                }
        },
        xAxis: {
            type: 'category',
            tickmarkPlacement: 'on',
            title: {
                enabled: true
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah'
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        legend: {
            align: 'center',
            verticalAlign: 'top',
            borderWidth: 0
        },
        plotOptions: {
            column: {
                depth: 25
            },
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '<small>{point.y}</small>'
                }
            }
        },
        series: [{
            name: 'Mahasiswa AKM ',
            data: [],
            //colorByPoint: true
        },{
            name: 'Mahasiswa ',
            data: [],
            //colorByPoint: true
        }]
    };
    const option_kelas = {
        chart: {
            type: 'column',
            zoomType: 'x',
                events: {
                    //load: grafik_kelas()
                }
        },
        xAxis: {
            type: 'category',
            tickmarkPlacement: 'on',
            title: {
                enabled: true
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah'
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        legend: {
            align: 'center',
            verticalAlign: 'top',
            borderWidth: 0
        },
        plotOptions: {
            column: {
                depth: 25
            },
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '<small>{point.y}</small>'
                }
            }
        },
        series: [{
            name: 'Pertemuan ',
            data: [],
            //colorByPoint: true
        },{
            name: 'KRS ',
            data: [],
            //colorByPoint: true
        },{
            name: 'Nilai ',
            data: [],
            //colorByPoint: true
        }]
    };
    const chart_akm = Highcharts.chart('container_akm', option_akm);
    const chart_kelas = Highcharts.chart('container_kelas', option_kelas);
</script>