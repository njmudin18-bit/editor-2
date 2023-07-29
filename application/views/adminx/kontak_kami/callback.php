<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title><?php echo $nama_halaman; ?> | <?php echo $this->config->item('company_name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?php echo $nama_halaman; ?> | <?php echo $this->config->item('company_name'); ?>" name="description" />
    <meta content="IT Department - <?php echo $this->config->item('company_name'); ?>" name="author" />
    
    <?php $this->load->view('adminx/components/header_datatable_css'); ?>
  </head>
  <body>
    <!-- Begin page -->
    <div class="wrapper">

      <!-- ========== Topbar Start ========== -->
      <?php $this->load->view('adminx/components/navbar'); ?>
      <!-- ========== Topbar End ========== -->

      <!-- ========== Left Sidebar Start ========== -->
      <?php $this->load->view('adminx/components/sidebar'); ?>
      <!-- ========== Left Sidebar End ========== -->

      <!-- ============================================================== -->
      <!-- Start Page Content here -->
      <!-- ============================================================== -->
      <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
              <!-- start page title -->
              <?php $this->load->view('adminx/components/page_title'); ?>
              <!-- end page title -->

              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="header-title text-center"><?php echo $nama_halaman; ?></h4>
                      <hr>
                      <div class="table-responsive">
                        <table id="order-table" class="table table-striped" width="125%">
                          <thead>
                            <tr class="bg-primary text-white">
                              <th class="text-center" width="5%">No.</th>
                              <th class="text-center" width="13%">#</th>
                              <th class="text-center" width="8%">Status</th>
                              <th class="text-center">Pengirim</th>
                              <th class="text-center" width="10%">Phone</th>
                              <th class="text-center">Judul</th>
                              <th class="text-center" width="15%">Tgl. Kirim</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                        </table>
                      </div>
                    </div> <!-- end card body-->
                  </div> <!-- end card -->
                </div>
                <!-- end col-->
              </div> 
              <!-- end row-->
            </div> 
            <!-- container -->
        </div> 
        <!-- content -->

        <!-- Footer Start -->
        <?php $this->load->view('adminx/components/footer'); ?>
        <!-- end Footer -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page content -->
      <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <div id="loading" class="loading">Loading&#8230;</div>

    <!-- Theme Settings -->
    <?php $this->load->view('adminx/components/theme_settings'); ?>
    <!-- Theme Settings END -->

    <!-- Theme Settings -->
    <?php $this->load->view('adminx/components/footer_datatable_js'); ?>
    <!-- Theme Settings END -->

    <script>
      //FUNCTION UPDATE STATUS
      function update_answer(event, id) {
        console.log(event.value);
        console.log(id);
        $.ajax({
            url : "<?php echo base_url(); ?>pertanyaan/update_answer",
            type: "POST",
            data: {id: id, answer: event.value},
            dataType: "JSON",
            beforeSend: function (response) {
              $('#loading').show();
            },
            success: function(data)
            {
              $('#loading').hide();
              reload_table();
              console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error get data from ajax');
            }
        });
      }

      //FUNCTION RELOAD TABLE
      function reload_table(){
        table.ajax.reload(null,false);
      }

      $(document).ready(function() {
        $('#loading').hide();
        table = $('#order-table').DataTable({ 
            dom: 'Bfrltip',
            buttons: [
              'excel'
              //'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "pagingType": "full_numbers",
            "lengthMenu": [
              [10, 25, 50, -1],
              [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
              search: "_INPUT_",
              searchPlaceholder: "Search records",
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
              "url": "<?php echo base_url(); ?>callback/callback_list",
              "type": "POST",
            },

            "aoColumns": [
              { "No": "No" , "sClass": "text-right"},
              { "#": "#" , "sClass": "text-center"},
              { "Status": "Status" , "sClass": "text-center" },
              { "Pengirim": "Pengirim" , "sClass": "text-left" },
              { "Phone": "Phone" , "sClass": "text-left" },
              { "Judul": "Judul" , "sClass": "text-left" },
              { "Tgl. Kirim": "Tgl. Kirim" , "sClass": "text-left" }
            ],

            //Set column definition initialisation properties.
            "columnDefs": [
              { 
                "targets": [ 1 ], //last column
                "orderable": false, //set not orderable
                className: 'text-right'
              },
            ]
        });
      });
    </script>
  </body>
</html>