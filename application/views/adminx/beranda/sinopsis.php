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
                        <table id="order-table" class="table table-striped" width="120%">
                          <thead>
                            <tr class="bg-primary text-white">
                              <th>No.</th>
                              <th>#</th>
                              <th>Urutan</th>
                              <th>Aktivasi</th>
                              <th>Product Name</th>
                              <th>Product Image</th>
                              <th>Types</th>
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
            <form id="RegisterValidation" enctype="multipart/form-data">
              <input type="hidden" value="" name="kode" >
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Product Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Product Description</label>
                <div class="col-sm-9">
                  <textarea id="product_desc" name="product_desc" rows="5" class="form-control" placeholder="Product Description"></textarea>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Aktivasi</label>
                <div class="col-sm-9">
                  <select id="aktivasi" name="aktivasi" class="form-select">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                    <option value="AKTIF">AKTIF</option>
                    <option value="TIDAK">TIDAK</option>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Urutan</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="urutan" name="urutan" placeholder="Urutan 1, 2, 3 dst.">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Link</label>
                <div class="col-sm-9">
                  <input type="url" class="form-control" id="link" name="link" placeholder=" Link">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Types</label>
                <div class="col-sm-9">
                  <select id="types" name="types" class="form-select" onchange="get_types(this);">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                    <option value="IMAGES">WITH IMAGES</option>
                    <option value="TEXT">ONLY TEXT</option>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
              <div id="image_input" class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Image</label>
                <div class="col-sm-9">
                  <input type="file" id="file" name="file" class="form-control" required="required">
                  <span class="help-block"></span>
                </div>
              </div>
              <div id="image_preview" class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Preview</label>
                <div class="col-sm-9">
                  <img id="prevew_box" src="<?php echo base_url(); ?>assets/images/not_founds/not-found.jpg" alt="post-img" class="rounded me-1" height="120">
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

      function get_types(event) {
        console.log(event.value);
        if (event.value == 'TEXT') {
          $('#image_input').hide();
        } else {
          $('#image_input').show();
        }
      }

      //FUNCTION OPEN MODAL
      function openModal() {
        save_method = 'add';
        $('#image_preview').hide();
        $('#btn_save').text('Save');
        $('#RegisterValidation')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Sinopsis'); // Set Title to Bootstrap modal title
      }

      function closeModal(){
        $('#RegisterValidation')[0].reset();
        $('#modal').modal('hide');
        $('.modal-title').text('Tambah Sinopsis');
      }

      //FUNCTION RESET
      function reset() {
        $('#RegisterValidation')[0].reset();
        $('.modal-title').text('Tambah Sinopsis');
        $('#image_preview').hide();
        $(".form-group").parent().find('div').removeClass("has-error");
      }

      //FUNCTION EDIT
      function edit(id) {

        save_method = 'update';
        $('#RegisterValidation')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>sinopsis/sinopsis_edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('[name="kode"]').val(data.id);
              $('[name="product_name"]').val(data.product_name);
              $('[name="product_desc"]').val(data.product_desc);
              $('[name="aktivasi"]').val(data.aktivasi);
              $('[name="urutan"]').val(data.urutan);
              $('[name="link"]').val(data.link);
              $('[name="types"]').val(data.types);

              if (data.types == 'TEXT') {
                $('#image_preview').hide();
                $('#image_input').hide();
              } else {
                $('#image_preview').show();
                $('#image_input').show();

                var imgs = '<?php echo base_url(); ?>upload/sinopsis_images/' + data.product_images;
                $("#prevew_box").attr("src", imgs);
              }
              
              $('#modal').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Edit Sinopsis'); // Set title to Bootstrap modal title
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
              url: '<?php echo base_url(); ?>sinopsis/sinopsis_deleted/' + id,
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
          url = "<?php echo base_url(); ?>sinopsis/sinopsis_add";
        } else {
          url = "<?php echo base_url(); ?>sinopsis/sinopsis_update";
        }
        
        //var data_save  = $('#RegisterValidation').serializeArray();
        var form      = $('#RegisterValidation')[0];
        var form_data = new FormData(form);

        // ajax adding data to database
        $.ajax({
          url: url,
          dataType: 'JSON', 
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'POST',
          beforeSend: function (response) {
            $("#btn_save").prop('disabled', true);
            $("#btn_save").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
          },
          success: function (data) {
            if(data.status == 'ok') //if success close modal and reload ajax table
            {
              $('#modal').modal('hide');
              reload_table();
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
          error: function (response) {
            alert('Error adding / update data');
            $('#btn_save').text('Save'); //change button text
            $('#btn_save').attr('disabled',false); //set button enable 
          }
        });
      };

      $(document).ready(function() {
        $('#image_preview').hide();
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
              "url": "<?php echo base_url(); ?>sinopsis/sinopsis_list",
              "type": "POST",
            },

            "aoColumns": [
              { "No": "No" , "sClass": "text-right"},
              { "#": "#" , "sClass": "text-center" },
              { "Urutan": "Urutan" , "sClass": "text-center" },
              { "Aktivasi": "Aktivasi" , "sClass": "text-center" },
              { "Product Name": "Product Name" , "sClass": "text-left" },
              { "Product Image": "Product Image" , "sClass": "text-left" },
              { "Types": "Types" , "sClass": "text-left" }
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

        $("#product_name").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#product_desc").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#types").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#aktivasi").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#urutan").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#link").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });
      });
    </script>
  </body>
</html>