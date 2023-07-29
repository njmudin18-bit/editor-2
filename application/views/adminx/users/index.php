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
                      <h4 class="header-title text-center">
                        <?php echo $nama_halaman; ?>
                        <span class="pull-right">
                          <button class="btn btn-primary btn-sm" onclick="openModal()">Add New</button>
                        </span>    
                      </h4>
                      <hr>
                      <div class="table-responsive">
                        <table id="order-table" class="table table-striped" width="100%">
                          <thead>
                            <tr class="bg-primary text-white">
                              <th>No.</th>
                              <th>#</th>
                              <th>Username</th>
                              <th>Email</th>
                              <th>Level</th>
                              <th>Aktivasi</th>
                              <th>Last login</th>
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

    <!-- MODAL -->
    <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg">
        <div class="modal-content">
          <div class="modal-header modal-colored-header bg-primary">
            <h4 class="modal-title" id="staticBackdropLabel">Modal title</h4>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-hidden="true" onclick="reset()"></button>
          </div> <!-- end modal header -->
          <div class="modal-body">
            <form id="RegisterValidation">
              <input type="hidden" value="" name="kode" >
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">NIP</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP anda">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email anda">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username anda">
                  <span class="help-block"></span>
                </div>
              </div>
              <div id="pass_div" class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password anda" minlength="7">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Level</label>
                <div class="col-sm-9">
                  <select id="level" name="level" class="form-select">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                    <option value="sa">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Aktivasi</label>
                <div class="col-sm-9">
                  <select id="aktivasi" name="aktivasi" class="form-select">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Block">Block</option>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal" onclick="reset();">Close</button>
            <button id="btn_save" type="button" class="btn btn-primary" onclick="save();">SAVE</button>
          </div> <!-- end modal footer -->
        </div> <!-- end modal content-->
      </div> <!-- end modal dialog-->
    </div>
    <!-- MODAL END -->

    <!-- Theme Settings -->
    <?php $this->load->view('adminx/components/theme_settings'); ?>
    <!-- Theme Settings END -->

    <!-- Theme Settings -->
    <?php $this->load->view('adminx/components/footer_datatable_js'); ?>
    <!-- Theme Settings END -->

    <script>
      var save_method;
      var url

      //FUNCTION OPEN MODAL CABANG
      function openModal() {
        save_method = 'add';
        $("#pass_div").show();
        $('#btn_save').text('Save');
        $('#RegisterValidation')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah User'); // Set Title to Bootstrap modal title
      }

      function closeModal(){
        $('#RegisterValidation')[0].reset();
        $('#modal').modal('hide');
        $('.modal-title').text('Tambah User');
      }

      //FUNCTION RESET
      function reset() {
        $('#RegisterValidation')[0].reset();
        $('.modal-title').text('Tambah User');
        //$('.form-group .col-sm-9').removeClass('has-error');
        $(".form-group").parent().find('div').removeClass("has-error");
      }

      //FUNCTION EDIT
      function edit(id) {

        save_method = 'update';
        $('#RegisterValidation')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $("#pass_div").hide();
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>users/users_edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('[name="kode"]').val(data.id);
              $('[name="nip"]').val(data.nip);
              $('[name="email"]').val(data.email_pegawai);
              $('[name="username"]').val(data.username);
              $('[name="aktivasi"]').val(data.aktivasi);
              $('[name="level"]').val(data.level);
              $('#modal').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title
              $('#btn_save').text('Update'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error get data from ajax');
            }
        });
      }

      //FUNCTION HAPUS
      function openModalDelete(id) {
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Data yang dihapus tidak bisa dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, hapus',
          cancelButtonText: 'Tidak, Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?php echo base_url(); ?>users/users_deleted/' + id,
              type: 'DELETE',
              error: function() {
                alert('Something is wrong');
              },
              success: function(data) {
                var result = JSON.parse(data);
                if (result.status == 'forbidden'){
                  Swal.fire(
                    'FORBIDDEN',
                    'Access Denied',
                    'info',
                  )
                } else {
                  $("#"+id).remove();
                  Swal.fire(
                    'Sukses!',
                    'Anda sukses menghapus data',
                    'success'
                  )
                  reload_table();
                }
              }
            });
          }
        })
      }

      //FUNCTION RELOAD TABLE
      function reload_table(){
        table.ajax.reload(null,false);
      }

      //VALIDATION AND ADD USER
      function save()
      {
        $("#btn_save").html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Saving...');
        $('#btn_save').attr('disabled', true); //set button disable 
        var url;

        if(save_method == 'add') {
          $("#pass_div").show();
          url = "<?php echo base_url(); ?>users/users_add";
        } else {
          $("#pass_div").hide();
          url = "<?php echo base_url(); ?>users/users_update";
        }
        
        var data_save  = $('#RegisterValidation').serializeArray();

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: data_save,
            dataType: "JSON",
            beforeSend: function() {
              
            },
            success: function(data)
            {
              if(data.status == 'ok') //if success close modal and reload ajax table
              {
                $('#modal').modal('hide');
                reload_table();
              } else if (data.status == 'forbidden') {
                Swal.fire(
                  'FORBIDDEN',
                  'Access Denied',
                  'info',
                )
              } else {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
              }
              $('#btn_save').text('Save'); //change button text
              $('#btn_save').attr('disabled',false); //set button enable 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error adding / update data');
              $('#btn_save').text('Save'); //change button text
              $('#btn_save').attr('disabled',false); //set button enable 
            }
        });

      };

      $(document).ready(function() {

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
              "url": "<?php echo base_url(); ?>users/users_list",
              "type": "POST",
            },

            "aoColumns": [
              { "No": "No" , "sClass": "text-right"},
              { "#": "#" , "sClass": "text-center" },
              { "Username": "Username" , "sClass": "text-left" },
              { "Email": "Email" , "sClass": "text-left" },
              { "Level": "Level" , "sClass": "text-center" },
              { "Aktivasi": "Aktivasi" , "sClass": "text-center" },
              { "Last login": "Last login" , "sClass": "text-left"}
            ],

            //Set column definition initialisation properties.
            "columnDefs": [
              { 
                "targets": [ -2 ], //last column
                "orderable": false, //set not orderable
                className: 'text-right'
              },
            ]
        });

        $("#nip").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#email").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#username").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#password").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#aktivasi").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#level").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });
      });
    </script>
  </body>
</html>