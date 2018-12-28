<?php $this->load->view('authentication/includes/head.php'); ?>
<body class="login_admin"<?php if(is_rtl()){ echo ' dir="rtl"'; } ?>>
 <div class="container">
  <div class="row">
   <div class="col-md-4 col-md-offset-4 authentication-form-wrapper">
    <div class="company-logo">
      <?php get_company_logo(); ?>
    </div>
    <div class="mtop40 authentication-form">
      <h1>Two Factor Authentication</h1>
      <img src="<?php echo isset($qr_code_url) ? $qr_code_url :''; ?>" alt="">
          <form action="<?php echo base_url() ?>authentication/enable2FA" method="POST" enctype="multipart/form-data">
            <?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash() ); ?>
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                      <label>
                          <input type="checkbox"  name="authenticate" <?php echo (isset($profiledata->authenticate) && $profiledata->authenticate == 'on') ? 'checked' :''; ?> value="on">
                          <b class="lbl padding-8">Enable Two Factor Authentication</b>
                      </label>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <input class="form-control" required="" type="text" placeholder="Two Factor Authentication code" name="code" value="">
                    </div>
                </div>
                 <div class="col-sm-3 with-data">
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary">Enable</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
</div>
</div>
</body>
</html>