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
    <!-- HEADER CSS -->
    <?php $this->load->view('adminx/components/header_dashboard_css'); ?>
    <!-- HEADER CSS END -->
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
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Projects</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Projects</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- SUMMARY -->
            <div class="row">
                <div class="col-12">
                    <div class="card widget-inline">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card rounded-0 shadow-none m-0">
                                        <div class="card-body text-center">
                                            <i class="ri-product-hunt-line text-muted font-24"></i>
                                            <h3><span><?php echo $jumlah_produk; ?></span></h3>
                                            <p class="text-muted font-15 mb-0">Total Produk</p>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                        <div class="card-body text-center">
                                            <i class="ri-chat-new-line text-muted font-24"></i>
                                            <h3><span><?php echo $jumlah_pertanyaan_all; ?></span></h3>
                                            <p class="text-muted font-15 mb-0">Total Pertanyaan</p>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                        <div class="card-body text-center">
                                            <i class="ri-group-line text-muted font-24"></i>
                                            <h3><span><?php echo $jumlah_user; ?></span></h3>
                                            <p class="text-muted font-15 mb-0">Members</p>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-sm-6 col-lg-3">
                                    <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                        <div class="card-body text-center">
                                            <i class="ri-chat-2-line text-muted font-24"></i>
                                            <h3><span><?php echo $jumlah_call_back_all; ?></span></h3>
                                            <p class="text-muted font-15 mb-0">Total Callback</p>
                                        </div>
                                    </div>
                                </div>
    
                            </div> <!-- end row -->
                        </div>
                    </div> <!-- end card-box-->
                </div> <!-- end col-->
            </div>
            <!-- SUMMARY end row-->

            <!-- PERTANYAAN -->
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Pertanyaan</h4>
                  </div>
                  <div class="card-header bg-light-lighten border-top border-bottom border-light py-1 text-center">
                    <p class="m-0"><b><?php echo $jumlah_pertanyaan_lengkap; ?></b> pertanyaan lengkap dari <?php echo $jumlah_pertanyaan_proses; ?>. Klik <a href="<?php echo base_url(); ?>pertanyaan">more</a></p>
                  </div>
                  <div class="card-body pt-2">
                    <div class="table-responsive">
                      <table class="table table-centered table-nowrap table-hover mb-0">
                        <tbody>
                          <?php foreach ($jumlah_pertanyaan_data as $key => $value): ?>
                            <tr>
                              <td>
                                <h5 class="font-14 my-1"><a href="javascript:void(0);" class="text-body">Pengirim</a></h5>
                                <span class="text-muted font-13"><?php echo $value->pengirim; ?></span>
                              </td>
                              <td>
                                <span class="text-muted font-13">Status</span><br/>
                                <?php 
                                  switch ($value->status_answer) {
                                    case 'HOLD':
                                      ?>
                                      <span class="badge badge-danger-lighten"><?php echo $value->status_answer; ?></span>
                                      <?php
                                      break;

                                    case 'ANSWER':
                                      ?>
                                      <span class="badge badge-success-lighten"><?php echo $value->status_answer; ?></span>
                                      <?php
                                      break;
                                    
                                    default:
                                      ?>
                                      <span class="badge badge-warning-lighten"><?php echo $value->status_answer; ?></span>
                                      <?php
                                      break;
                                  }
                                ?>
                              </td>
                              <td>
                                <span class="text-muted font-13">Judul</span>
                                <h5 class="font-14 mt-1 fw-normal"><?php echo $value->judul; ?></h5>
                              </td>
                              <td>
                                <span class="text-muted font-13">Tgl. Kirim</span>
                                <h5 class="font-14 mt-1 fw-normal"><?php echo $value->create_date; ?></h5>
                              </td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    </div> <!-- end table-responsive-->
                  </div> <!-- end card body-->
                </div> <!-- end card -->
              </div><!-- end col-->
            </div>
            <!-- PERTANYAAN end row-->

            <!-- CALLBACK & RECENT ACTIVITIES -->
            <div class="row">
              <div class="col-xl-7">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Callback</h4>
                  </div>
                  <div class="card-header bg-light-lighten border-top border-bottom border-light py-1 text-center">
                    <p class="m-0"><b><?php echo $jumlah_call_back_lengkap; ?></b> callback lengkap dari <?php echo $jumlah_call_back_all; ?>. Klik <a href="<?php echo base_url(); ?>callback">more</a></p>
                  </div>
                  <div class="card-body pt-2">
                    <div class="table-responsive">
                      <table class="table table-centered table-nowrap table-hover mb-0">
                        <tbody>
                          <?php foreach ($jumlah_call_back_data as $key => $value): ?>
                            <tr>
                              <td>
                                <h5 class="font-14 my-1"><a href="javascript:void(0);" class="text-body">Pengirim</a></h5>
                                <span class="text-muted font-13"><?php echo $value->pengirim; ?></span>
                              </td>
                              <td>
                                <span class="text-muted font-13">Status</span><br/>
                                <?php 
                                  switch ($value->status_answer) {
                                    case 'HOLD':
                                      ?>
                                      <span class="badge badge-danger-lighten"><?php echo $value->status_answer; ?></span>
                                      <?php
                                      break;

                                    case 'ANSWER':
                                      ?>
                                      <span class="badge badge-success-lighten"><?php echo $value->status_answer; ?></span>
                                      <?php
                                      break;
                                    
                                    default:
                                      ?>
                                      <span class="badge badge-warning-lighten"><?php echo $value->status_answer; ?></span>
                                      <?php
                                      break;
                                  }
                                ?>
                              </td>
                              <td>
                                <span class="text-muted font-13">Judul</span>
                                <h5 class="font-14 mt-1 fw-normal"><?php echo $value->judul; ?></h5>
                              </td>
                              <td>
                                <span class="text-muted font-13">Tgl. Kirim</span>
                                <h5 class="font-14 mt-1 fw-normal"><?php echo $value->create_date; ?></h5>
                              </td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    </div> <!-- end table-responsive-->
                  </div> <!-- end card body-->
                </div> <!-- end card -->
              </div><!-- end col-->

              <div class="col-xl-5">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Recent Activities</h4>
                  </div>
                  <div class="card-body pt-0">
                    <div class="table-responsive">
                      <table class="table table-centered table-nowrap table-striped mb-0">
                        <tbody>
                          <?php foreach ($recent_activities as $key => $value): ?>
                            <tr>
                              <td>
                                <div class="d-flex align-items-start">
                                  <img class="me-2 rounded-circle" src="<?php echo base_url(); ?>assets/images/users/icon-user.png" width="40" alt="<?php echo $value->username; ?>">
                                  <div>
                                    <h5 class="mt-0 mb-1"><?php echo $value->username; ?></h5>
                                    <span class="font-13">Last login on <?php echo $value->last_login; ?></span>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    </div> <!-- end table-responsive-->
                  </div> <!-- end card body-->
                </div> <!-- end card -->
              </div><!-- end col-->
            </div>
            <!-- CALLBACK & RECENT ACTIVITIES end row-->

            <!-- CALENDAR -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Calender</h4>
                  </div>

                  <div class="card-body">
                    <div data-provide="datepicker-inline" data-date-today-highlight="true" class="calendar-widget"></div>
                  </div> <!-- end card body-->
                </div> <!-- end card -->
              </div><!-- end col-->
            </div>
            <!-- CALENDAR end row-->
          </div> <!-- container -->
        </div> <!-- content -->

        <!-- Footer Start -->
        <?php $this->load->view('adminx/components/footer'); ?>
        <!-- end Footer -->

      </div>

      <!-- ============================================================== -->
      <!-- End Page content -->
      <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- THEME SETTINGS -->
    <?php $this->load->view('adminx/components/theme_settings'); ?>
    <!-- THEME SETTINGS END -->

    <!-- FOOTER JS -->
    <?php $this->load->view('adminx/components/footer_dashboard_js'); ?>
    <!-- FOOTER JS END -->
  </body>
</html>