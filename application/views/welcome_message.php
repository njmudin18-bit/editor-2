<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Login | <?php echo $this->config->item('company_name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?php echo $this->config->item('company_name'); ?>" />
    <meta name="author" content="IT Department <?php echo $this->config->item('company_name'); ?>" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/icons/<?php echo $this->config->item('company_icon_bar'); ?>">
    
    <!-- Theme Config Js -->
    <script src="<?php echo base_url(); ?>assets/js/hyper-config.js"></script>
    <!-- App css -->
    <link href="<?php echo base_url(); ?>assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Icons css -->
    <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body class="authentication-bg">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-4 col-lg-5">
            <div class="card">
              <!-- Logo -->
              <div class="card-header py-2 text-center bg-primary">
                <a href="#">
                  <span><img src="<?php echo base_url(); ?>assets/images/logos/<?php echo $this->config->item('company_logo'); ?>" alt="<?php echo $this->config->item('company_name'); ?>" style="width:30%;"></span>
                </a>
              </div>
              <div class="card-body p-3">
                
                <div class="text-center w-75 m-auto">
                  <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                </div>
                <form id="login_form" action="#">
                  <div class="form-group mb-2">
                    <label for="emailaddress" class="form-label">Username</label>
                    <input class="form-control" type="text" id="username" name="username" required="required" placeholder="Enter your username" autocomplete="off">
                  </div>
                  <div class="form-group mb-2">
                    <!-- <a href="pages-recoverpw.html" class="text-muted float-end"><small>Forgot your password?</small></a> -->
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group input-group-merge">
                      <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" autocomplete="off">
                      <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                      </div>
                    </div>
                  </div>
                  <div class="mb-2">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                      <label class="form-check-label" for="checkbox-signin">Remember me</label>
                    </div>
                  </div>
                  <hr>
                  <div class="mb-2" style="margin: auto; max-width: 305px;">
                    <div id="recaptcha" class="g-recaptcha" data-sitekey="<?php echo $this->config->item('site_key'); ?>"></div>
                  </div>
                  <div class="mb-3 mb-0 text-center">
                    <button class="btn btn-primary" id="button_login" type="submit"> Log In </button>
                  </div>
                </form>
              </div> <!-- end card-body -->
            </div>
            <!-- end card -->
            <!-- <div class="row mt-3">
              <div class="col-12 text-center">
                <p class="text-muted">Don't have an account? <a href="pages-register.html" class="text-muted ms-1"><b>Sign Up</b></a></p>
              </div>
            </div> -->
            <!-- end row -->
          </div> <!-- end col -->
        </div>
      <!-- end row -->
      </div>
      <!-- end container -->
    </div>
    <!-- end page -->
    <footer class="footer footer-alt">
      <script>document.write(new Date().getFullYear())</script> ©&nbsp;<a href="https://omas-mfg.com/" target="_blank"><?php echo $this->config->item('company_name'); ?></a>
    </footer>
    <!-- Vendor js -->
    <script src="<?php echo base_url(); ?>assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="<?php echo base_url(); ?>assets/js/app.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
			$(function () {
				$.validator.setDefaults({
					submitHandler: loginAction
				});
				$('#login_form').validate({
					rules: {
						username: {
							required: true,
							minlength: 4,
						},
						password: {
							required: true,
							minlength: 5
						}
					},
					errorElement: 'span',
					errorPlacement: function (error, element) {
						error.addClass('invalid-feedback');
						element.closest('.form-group').append(error);
					},
					highlight: function (element, errorClass, validClass) {
						$(element).addClass('is-invalid');
					},
					unhighlight: function (element, errorClass, validClass) {
						$(element).removeClass('is-invalid');
					}
				});

				function loginAction() {
					var data = $("#login_form").serialize();
					$.ajax({
						type: 'POST',
						url: "<?php echo base_url(); ?>welcome/login_proses",
						data: data,
						beforeSend: function () {
							$("#error").fadeOut();
							$("#button_login").prop('disabled', true);
							$("#button_login").html('Login...');
						},
						success: function (response) {
							const res = JSON.parse(response);
							console.log(res);
							if (res.status_code == 400 || res.status_code == 404 || res.status_code == 401) {
								Swal.fire({
									icon: 'info',
									title: 'Oops...',
									text: res.message
								});
								$("#button_login").html('Log In');
							} else {
								$("#button_login").html('Masuk aplikasi...');
								setTimeout('window.location.href = "' + res.url + '"', 500);
							}

							$("#button_login").prop('disabled', false);
							//$("#button_login").html('Log In');
							grecaptcha.reset();
						}
					});
					return false;
				}

				var width = $('.g-recaptcha').parent().width();
				console.log(width);
				if (width < 302) {
					var scale = width / 302;
					$('.g-recaptcha').css('transform', 'scale(' + scale + ')');
					$('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
					$('.g-recaptcha').css('transform-origin', '0 0');
					$('.g-recaptcha').css('-webkit-transform-origin', '0 0');
				}
			});
		</script>
  </body>
</html>