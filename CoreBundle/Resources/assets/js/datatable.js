(function() {
    define(['jquery', 'bootstrap', 'datatables'], function ($, bs, dt) {
        var $table = $('#jq-datatables-example');
        $table.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": $table.data('url')
        });
        $('#jq-datatables-example_wrapper .table-caption').text('Some header text');
        $('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
    });
});
