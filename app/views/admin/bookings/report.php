<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/admin_navbar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <main class="">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Laporan Jualan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <input type="text" id="daterange_textbox" class="form-control" readonly />
                </div>
            </div>

            <div class="table-responsive">
                <div class="chart-container pie-chart">
                    <canvas class="my-4 w-100" id="myChart" width="100%" height="20%"></canvas>
                </div>
                <table id="report_table" class="table table-striped table-sm" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Jumlah (RM)</th>
                            <th scope="col">Tarikh</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<style>
    <?php require APPROOT . '/views/inc/dashboard_css.php'; ?>
</style>
<script>
    $(document).ready(function() {
        let sale_chart = null;
        fetch_data();

        function fetch_data(start_date = '', end_date = '') {
            var dataTable = $('#report_table').DataTable({
                "language": {
                    "lengthMenu": "Papar _MENU_ rekod per halaman",
                    "info": "Paparan _PAGE_ daripada _PAGES_ halaman",
                    "infoEmpty": "Tiada rekod yang ditemui",
                    "infoFiltered": "(disaring daripada jumlah _MAX_ rekod)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Seterusnya",
                        "previous": "Sebelumnya"
                    }
                },
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo URLROOT; ?>/admins/salesReport",
                    type: "POST",
                    data: {
                        action: 'fetch',
                        start_date: start_date,
                        end_date: end_date
                    }
                },

                "drawCallback": function(settings) {
                    var sales_date = [];
                    var sale = [];

                    for (var count = 0; count < settings.aoData.length; count++) {
                        sales_date.push(settings.aoData[count]._aData[2]);
                        sale.push(parseFloat(settings.aoData[count]._aData[1]));
                    }

                    var chart_data = {
                        labels: sales_date,
                        datasets: [{
                            label: 'Jualan',
                            backgroundColor: 'rgba(153,102,255)',
                            color: '#fff',
                            data: sale,
                        }]
                    };

                    var group_chart3 = $('#myChart');

                    if (sale_chart != null) {
                        sale_chart.destroy();
                    }

                    sale_chart = new Chart(group_chart3, {
                        type: 'bar',
                        data: chart_data
                    });

                }

            });
        }

        $('#daterange_textbox').daterangepicker({
                ranges: {
                    'Hari ini': [moment(), moment()],
                    'Semalam': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                    'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    'Bulan Lepas': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                },
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Terapkan",
                    "cancelLabel": "Batal",
                    "fromLabel": "Dari",
                    "toLabel": "Hingga",
                    "customRangeLabel": "Julat Tersuai",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Ahad",
                        "Isnin",
                        "Selasa",
                        "Rabu",
                        "Khamis",
                        "Jumaat",
                        "Sabtu"
                    ],
                    "monthNames": [
                        "Januari",
                        "Februari",
                        "Mac",
                        "April",
                        "Mei",
                        "Jun",
                        "Julai",
                        "Ogos",
                        "September",
                        "Oktober",
                        "November",
                        "Disember"
                    ],
                },
                format: 'YYYY-MM-DD'
            },
            function(start, end) {
                $('#report_table').DataTable().destroy();
                fetch_data(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            });
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>