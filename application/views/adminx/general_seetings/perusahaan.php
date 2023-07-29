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
                        <table id="order-table" class="table table-striped" width="180%">
                          <thead>
                            <tr class="bg-primary text-white">
                              <th>No.</th>
                              <th>#</th>
                              <th>Aktivasi</th>
                              <th>Nama</th>
                              <th>Telepon</th>
                              <th>Handphone</th>
                              <th>Fax</th>
                              <th>Email</th>
                              <th>Alamat</th>
                              <th>Icon Name</th>
                              <th>Logo Name</th>
                              <th>Twitter</th>
                              <th>Facebook</th>
                              <th>Instagram</th>
                              <th>Pinterest</th>
                              <th>Youtube</th>
                              <th>Skype</th>
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
                <label class="col-sm-3 col-form-label">Nama Perusahaan</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Perusahaan">
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
                <label class="col-sm-3 col-form-label">Telepon</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Nomor Telepon">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Handphone</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="handphone" name="handphone" placeholder="Nomor Handphone">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Fax</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="fax" name="fax" placeholder="Nomor Fax">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Alamat Email">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="alamat" name="alamat" placeholder="Alamat Perusahaan">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Maps</label>
                <div class="col-sm-9">
                  <textarea id="maps" name="maps" class="form-control" placeholder="Alamat Maps" rows="5"></textarea>
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Twitter</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="twitter" name="twitter" placeholder="Link Twitter">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Facebook</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="facebook" name="facebook" placeholder="Link Facebook">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Instagram</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="instagram" name="instagram" placeholder="Link Instagram">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Pinterest</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="pinterest" name="pinterest" placeholder="Link Pinterest">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Youtube</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="youtube" name="youtube" placeholder="Link Youtube">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Skype</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="skype" name="skype" placeholder="Link Skype">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Logo Perusahaan</label>
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

    <!-- MODAL UPLOAD ICON -->
    <div class="modal fade" id="modal_upload_icon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg">
        <div class="modal-content">
          <div class="modal-header modal-colored-header bg-primary">
            <h4 class="modal-title" id="staticBackdropLabel">Modal title</h4>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-hidden="true" onclick="reset_icon()"></button>
          </div> <!-- end modal header -->
          <div class="modal-body">
            <form id="RegisterValidation_icon" enctype="multipart/form-data">
              <input type="hidden" value="" name="kode_perusahaan" >
              
              <div class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Icon Perusahaan</label>
                <div class="col-sm-9">
                  <input type="file" id="file_icon" name="file_icon" class="form-control" required="required">
                  <span class="help-block"></span>
                </div>
              </div>
              <div id="image_preview_icon" class="form-group row mb-3">
                <label class="col-sm-3 col-form-label">Preview</label>
                <div class="col-sm-9">
                  <img id="prevew_box_icon" src="<?php echo base_url(); ?>assets/images/not_founds/not-found.jpg" alt="post-img" class="rounded me-1" height="120">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal" onclick="reset();">Close</button>
            <button id="btn_save_icon" type="button" class="btn btn-primary" onclick="save_icon();">SAVE</button>
          </div> <!-- end modal footer -->
        </div> <!-- end modal content-->
      </div> <!-- end modal dialog-->
    </div>
    <!-- MODAL UPLOAD ICON END -->

    <!-- Theme Settings -->
    <?php $this->load->view('adminx/components/theme_settings'); ?>
    <!-- Theme Settings END -->

    <!-- Theme Settings -->
    <?php $this->load->view('adminx/components/footer_datatable_js'); ?>
    <!-- Theme Settings END -->

    <script>
      var save_method;
      var url

      //SAVE ICON
      function save_icon() {
        //var cek_file = document.getElementById("file").files.length == 0
        var cek_file = document.getElementById("file_icon");
        console.log(cek_file.files.length);
        if (document.getElementById("file_icon").files.length == 0) {
          alert("File harus diisi!");
          $("#file").focus();
        } else {

          var form      = $('#RegisterValidation_icon')[0];
          var form_data = new FormData(form);

          // ajax adding data to database
          $.ajax({
            url: '<?php echo base_url(); ?>perusahaan/upload_icon',
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            beforeSend: function (response) {
              $("#btn_save_icon").prop('disabled', true);
              $("#btn_save_icon").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            },
            success: function (data) {
              if(data.status == 'ok') //if success close modal and reload ajax table
              {
                $('#modal_upload_icon').modal('hide');
                reload_table();
              } else {
                alert("error when upload");
              }
              $('#btn_save_icon').text('Save'); //change button text
              $('#btn_save_icon').attr('disabled',false); //set button enable 
            },
            error: function (response) {
              alert('Error adding / update data');
              $('#btn_save_icon').text('Save'); //change button text
              $('#btn_save_icon').attr('disabled',false); //set button enable 
            }
          });
        }
      }

      //FUNCTION UPLOAD ICON
      function openModalUpload(id) {
        save_method = 'update';
        $('#RegisterValidation_icon')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>perusahaan/perusahaan_edit/" + id,
            type: "GET",
            dataType: "JSON",
            beforeSend: function (response) {
              $("#btn_save_icon").prop('disabled', true);
              $("#btn_save_icon").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            },
            success: function(data)
            {
              $('[name="kode_perusahaan"]').val(data.id);
              $('#modal_upload_icon').modal('show');
              $('#btn_save_icon').attr('disabled', false);
              const icon = data.icon_name;
              if (icon == '' || icon == null) {
                $('.modal-title').text('Tambah Icon Perusahaan');
                $('#btn_save_icon').text('Save');
                $('#image_preview_icon').hide();
              } else {
                $('.modal-title').text('Edit Icon Perusahaan');
                $('#btn_save_icon').text('Update');
                var imgs = '<?php echo base_url(); ?>upload/general_images/' + icon;
                $("#prevew_box_icon").attr("src", imgs);
                $('#image_preview_icon').show();
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              alert('Error get data from ajax');
            }
        });
      }

      //FUNCTION OPEN MODAL CABANG
      function openModal() {
        save_method = 'add';
        $("#image_preview").hide();
        $('#btn_save').text('Save');
        $('#RegisterValidation')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Perusahaan'); // Set Title to Bootstrap modal title
      }

      function closeModal(){
        $('#RegisterValidation')[0].reset();
        $('#modal').modal('hide');
        $('.modal-title').text('Tambah Perusahaan');
      }

      //FUNCTION RESET
      function reset() {
        $('#RegisterValidation')[0].reset();
        $('.modal-title').text('Tambah Perusahaan');
        $('#image_preview').hide();
        $(".form-group").parent().find('div').removeClass("has-error");
      }

      function reset_icon() {
        $('#RegisterValidation_icon')[0].reset();
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
            url : "<?php echo base_url(); ?>perusahaan/perusahaan_edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('[name="kode"]').val(data.id);
              $('[name="aktivasi"]').val(data.aktivasi);
              $('[name="nama"]').val(data.nama);
              $('[name="telepon"]').val(data.telepon);
              $('[name="handphone"]').val(data.handphone);
              $('[name="fax"]').val(data.fax);
              $('[name="email"]').val(data.email);
              $('[name="alamat"]').val(data.alamat);
              $('[name="maps"]').val(data.maps);
              $('[name="twitter"]').val(data.twitter);
              $('[name="facebook"]').val(data.facebook);
              $('[name="instagram"]').val(data.instagram);
              $('[name="pinterest"]').val(data.pinterest);
              $('[name="youtube"]').val(data.youtube);
              $('[name="skype"]').val(data.skype);

              var imgs = '<?php echo base_url(); ?>upload/general_images/' + data.logo_name;
              $("#prevew_box").attr("src", imgs);
              
              $('#modal').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Edit Perusahaan'); // Set title to Bootstrap modal title
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
              url: '<?php echo base_url(); ?>perusahaan/perusahaan_deleted/' + id,
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
          url = "<?php echo base_url(); ?>perusahaan/perusahaan_add";
        } else {
          url = "<?php echo base_url(); ?>perusahaan/perusahaan_update";
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
              "url": "<?php echo base_url(); ?>perusahaan/perusahaan_list",
              "type": "POST",
            },

            "aoColumns": [
              { "No": "No" , "sClass": "text-right"},
              { "#": "#" , "sClass": "text-center" },
              { "Aktivasi": "Aktivasi" , "sClass": "text-center" },
              { "Nama": "Nama" , "sClass": "text-left" },
              { "Telepon": "Telepon" , "sClass": "text-left" },
              { "Handphone": "Handphone" , "sClass": "text-left" },
              { "Fax": "Fax" , "sClass": "text-left" },
              { "Email": "Email" , "sClass": "text-left" },
              { "Alamat": "Alamat" , "sClass": "text-left" },
              { "Icon Name": "Icon Name" , "sClass": "text-left" },
              { "Logo Name": "Logo Name" , "sClass": "text-left" },
              { "Twitter": "Twitter" , "sClass": "text-left" },
              { "Facebook": "Facebook" , "sClass": "text-left" },
              { "Instagram": "Instagram" , "sClass": "text-left" },
              { "Pinterest": "Pinterest" , "sClass": "text-left" },
              { "Youtube": "Youtube" , "sClass": "text-left" },
              { "Skype": "Skype" , "sClass": "text-left" }
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

        $("#nama").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#aktivasi").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#telepon").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#handphone").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#fax").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#email").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });

        $("#alamat").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        });
      });
    </script>
  </body>
</html>