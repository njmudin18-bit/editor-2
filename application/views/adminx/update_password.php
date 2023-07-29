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
                        <form id="update_pass_form">
                          <div class="container">
                            <div class="row">
                              <div class="col-md-4 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group input-group-merge">
                                  <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password">
                                  <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4 mb-3">
                                <label for="password" class="form-label">Confirm New Password</label>
                                <div class="input-group input-group-merge">
                                  <input type="password" id="confirm_new_password" name="confirm_new_password" class="form-control" placeholder="Confirm new password">
                                  <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4 mb-3 mt-38">
                                <label for="password" class="form-label"></label>
                                <button id="btn_update" type="submit" class="btn btn-soft-primary">UPDATE</button>
                              </div>
                            </div>
                          </div>
                        </form>
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

    <!-- Theme Settings -->
    <?php $this->load->view('adminx/components/theme_settings'); ?>
    <!-- Theme Settings END -->

    <!-- Theme Settings -->
    <?php $this->load->view('adminx/components/footer_datatable_js'); ?>
    <!-- Theme Settings END -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript">
      $(function () {
        $.validator.setDefaults({
          submitHandler: updateAction
        });
        $('#update_pass_form').validate({
          rules: {
            new_password: {
              required: true,
              minlength: 5,
            },
            confirm_new_password: {
              required: true,
              minlength: 5,
              equalTo : "#new_password"
            }
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });

        function updateAction() {
          var data = $("#update_pass_form").serialize();
          $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>adminx/update_password_action",
            data: data,
            beforeSend: function () {
              $("#error").fadeOut();
              $("#btn_update").prop('disabled', true);
              $("#btn_update").html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Updating...');
            },
            success: function (response) {
              const res = JSON.parse(response);
              console.log(res);
              if(res.status) {
                Swal.fire(
                  'Good job!',
                  'Anda sukses mengganti password',
                  'success'
                );
                $('#update_pass_form')[0].reset();
              } else {
                Swal.fire(
                  'Oops!',
                  'Anda gagal mengganti password',
                  'info'
                )
              }

              $("#btn_update").prop('disabled', false);
              $("#btn_update").html('UPDATE');
            }
          });
          return false;
        }
      });
    </script>
  </body>
</html>