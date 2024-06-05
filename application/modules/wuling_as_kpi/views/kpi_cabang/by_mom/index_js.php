<!-- <script src="https://raw.githubusercontent.com/ashl1/datatables-rowsgroup/master/dataTables.rowsGroup.js"></script> -->
<script src="<?= base_url() ?>public/assets/js/datatables/dataTables.rowsGroup.js"></script>

<script>
    $(document).ready(function() {
        $("#table_kpi_by_mom").DataTable({
            ordering: false, //disable sorting
            searching: false, //searching
            lengthChange: true, //menu kolom di kiri atas
            paginate: true, //disable paginate,
            filter: false, //disable filter/search
            info: false, //disable info row kiri bawah
            select: true,
            rowsGroup: [0],
            paging: false
        });
    });
</script>