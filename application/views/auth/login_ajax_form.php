<div class="modal fade show LoginModalAjax" id="LoginModalAjax" tabindex="-1" role="dialog" style="display: block;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('auth/login'); ?>" class="login-frm" id="login-frm" name="login-frm" method="post">
                <div class="modal-header text-center">
                    <img class="model-logo" src="<?php echo ASSETS_PATH; ?>images/slogo.png" alt="">
                    <!-- <h4 class="title" id="defaultModalLabel"><?php echo WEBSITE_NAME . ' Login'; ?></h4> -->
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Enter Email </label>
                                <input type="text" class="form-control" id="email" name="login">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">Password </label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn l-cyan  btn-round login-btn">LOG IN</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show LoginModalAjax"></div>