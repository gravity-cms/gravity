define(['jquery', 'jqueryui', 'bootstrap', 'bootbox', 'cms/core/datatable/bootstrap', 'cms/core/api'], function ($, ui, bs, bootbox, dt, api) {

    $(document).ready(function () {

        var $table = $('.nefarian-data-table'),
            options = $table.data(),
            tableOptions = {},
            $wrapper;

        if($table.length) {
            if (options.url) {
                tableOptions.processing = true;
                tableOptions.serverSide = true;
                tableOptions.ajax = options.url;
            }
            $table.dataTable(tableOptions);
            $wrapper = $table.parent();
            $wrapper.find('.table-caption').text('Views');
            $wrapper.find('.dataTables_filter input').attr('placeholder', 'Search...');
        }


        $('form.api-save').on('submit', function (e) {
            e.stopPropagation();
            e.preventDefault();

            api.saveForm($(this));
            return false;
        });
    });
});
