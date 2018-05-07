    <script src="../assets/backstage/js/popper.min.js"></script>
    <script src="../assets/backstage/js/plugins.js"></script>
    <script src="../assets/backstage/js/main.js"></script>

    <script src="../assets/backstage/js/lib/data-table/datatables.min.js"></script>
    <script src="../assets/backstage/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="../assets/backstage/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="../assets/backstage/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="../assets/backstage/js/lib/data-table/jszip.min.js"></script>
    <script src="../assets/backstage/js/lib/data-table/pdfmake.min.js"></script>
    <script src="../assets/backstage/js/lib/data-table/vfs_fonts.js"></script>
    <script src="../assets/backstage/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="../assets/backstage/js/lib/data-table/buttons.print.min.js"></script>
    <script src="../assets/backstage/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="../assets/backstage/js/lib/data-table/datatables-init.js"></script>
    <script src="../assets/js/sweetalert2.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        var DataTable = $('#bootstrap-data-table').DataTable();

        $('#test').click(function(event) {
          // DataTable.row.add( [
          //   '.1',
          //     '.2',
          //   '.3',
          //     '.4',
          //     '.5'
          // ] ).draw( false );
          // DataTable.row.add('<tr><td>ss</td></tr>').draw(false);
        });
        $('#select').change(function(event) {
          $.ajax({
            url: 'attractions',
            type: 'POST',
            dataType: 'json',
            data: {
              place: $(this).val()
            }
          })
          .done(function(ok) {
            console.log('ok');
            DataTable.rows().remove().draw(false);
            $(ok).each(function(index, val) {

              var row = DataTable.row.add([//add td 內容 in 20180507
                val.Name,
                val.Opentime,
                val.Tel,
                val.Add
              ]).draw(false).nodes();//nodes get tr attr  in 20180507
              $(row).attr( 'data-id', val.id);//增加被點選tr得屬性  in 20180507

            });

          })
          .fail(function(error) {
            console.log('error');
            console.log(error);
          });

        });
      });

    </script>

</body>
</html>
