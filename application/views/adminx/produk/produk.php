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
                        <table id="order-table" class="table table-striped" width="150%">
                          <thead>
                            <tr class="bg-primary text-white">
                              <th>No.</th>
                              <th width="10%">#</th>
                              <th>Aktivasi</th>
                              <th width="10%">Jenis Produk</th>
                              <th width="15%">Produk</th>
                              <th width="15%">Nominal Voltage</th>
                              <th width="32%">Available Types</th>
                              <th width="10%">Images</th>
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
                <label class="col-sm-3 col-form-label">Jenis Produk</label>
                <div class="col-sm-9">
                  <select id="id_jenis" name="id_jenis" class="form-select">
                    <option selected="selected" disabled="disabled">-- Pilih --</option>
                    <?php foreach ($jenis_produk as $key => $value): ?>
                      <option value="<?php echo $value->id; ?>"><?php echo $value->jenis_produk; ?></option>
                    <?php endforeach ?>
                  </select>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Nama Produk</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Nominal Voltage</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nominal_voltage" name="nominal_voltage" placeholder="Nominal Voltage">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Available Types</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="available_types" name="available_types" placeholder="Pisahkan dengan ';' jika multiple">
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

      //FUNCTION OPEN MODAL CABANG
      function openModal() {
        save_method = 'add';
        $("#pass_div").show();
        $('#btn_save').text('Save');
        $('#RegisterValidation')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Produk'); // Set Title to Bootstrap modal title
      }

      function closeModal(){
        $('#RegisterValidation')[0].reset();
        $('#modal').modal('hide');
        $('.modal-title').text('Tambah Produk');
      }

      //FUNCTION RESET
      function reset() {
        $('#RegisterValidation')[0].reset();
        $('.modal-title').text('Tambah Produk');
        $('#image_preview').hide();
        $(".form-group").parent().find('div').removeClass("has-error");
      }

      //FUNCTION EDIT
      function edit(id) {

        save_method = 'update';
        $('#RegisterValidation')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#image_preview').show();
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>produk/produk_edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('[name="kode"]').val(data.id);
              $('[name="id_jenis"]').val(data.id_jenis);
              $('[name="nama_produk"]').val(data.nama_produk);
              $('[name="nominal_voltage"]').val(data.nominal_voltage);
              $('[name="available_types"]').val(data.available_types);
              $('[name="aktivasi"]').val(data.aktivasi);

              var imgs = '<?php echo base_url(); ?>upload/produk_images/' + data.images;
              $("#prevew_box").attr("src", imgs);
              
              $('#modal').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Edit Produk'); // Set title to Bootstrap modal title
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
              url: '<?php echo base_url(); ?>produk/produk_deleted/' + id,
              type: 'DELETE',
              error: function() {
                alert('Something is wrong');
              },
              success: function(data) {
                $("#"+id).remove();
                Swal.fire(
                  'Sukses!',
                  'Anda sukses menghapus data',
                  'success'
                )
                reload_table();
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
          url = "<?php echo base_url(); ?>produk/produk_add";
        } else {
          url = "<?php echo base_url(); ?>produk/produk_update";
        }
        
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
              "url": "<?php echo base_url(); ?>produk/produk_list",
              "type": "POST",
            },

            "aoColumns": [
              { "No": "No" , "sClass": "text-right"},
              { "#": "#" , "sClass": "text-center" },
              { "Aktivasi": "Aktivasi" , "sClass": "text-center" },
              { "Jenis Produk": "Jenis Produk" , "sClass": "text-left" },
              { "Produk": "Produk" , "sClass": "text-left" },
              { "Nominal Voltage": "Nominal Voltage" , "sClass": "text-left" },
              { "Available Types": "Available Types" , "sClass": "text-left"},
              { "Images": "Images" , "sClass": "text-left"}
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

        $("#id_jenis").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#nama_produk").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#nominal_voltage").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#available_types").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#aktivasi").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });
      });
    </script>
  </body>
</html>