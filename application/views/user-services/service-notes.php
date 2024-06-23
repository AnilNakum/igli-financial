<?php
$ID = array('type'=>'hidden', 'name' => 'id', 'id' => 'id', 'value' => 0, 'class' => "form-control");
$USID = array('type'=>'hidden', 'name' => 'usid', 'id' => 'usid', 'value' => $USID, 'class' => "form-control");
$Note = array('name' => 'note', 'id' => 'note', 'value' => set_value('Note'), 'class' => "form-control", "rows" => 3, "tabindex" => 2, "style" => "resize:none");

$submit_btn = array('name' => 'submit_btn', 'id' => 'submit_btn', 'value' => 'SAVE', 'class' => 'btn btn-round l-blue');
$cancel_btn = array('name' => 'cancel_btn', 'id' => 'cancel_btn', 'content' => 'CANCEL', 'class' => 'btn btn-round btn-white', "onclick" => "pop_up.close()");
$form_attr = array('class' => 'default_form services_note_frm', 'id' => 'services_note_frm', 'name' => 'services_note_frm', 'type' => $type);
?>
<?php echo form_open_multipart('user_services/submit_note_form', $form_attr); ?>
<div class="popup_body_area">
    <header id="sidebar-header">
        <div class="sidebar-header">
            <div class="sidebar-header-content">
                <h3><?php echo $page_title; ?></h3>
                <a href="javascript:;" onclick="pop_up.close()"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </header>
    <section id="sidebar-section">
        <div class="sidebar-section">
            <?php 
                echo validation_errors(); 
                echo form_input($ID);
                echo form_input($USID);
            ?>
            <div class="row">
                <div class="col-md-12 card">
                    <?php if (count((array) $UserServices) == 0) {?>
                    <div class="body text-center manage-list">
                        <div class="institute-box">
                            <img width="80%" src="<?php echo ASSETS_PATH; ?>images/finder.png">
                            <h3>No Notes right now  </h3><br />
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="card chat-ap">
                        <div class="chat">
                            <div class="chat-history">
                                <ul>
                                    <?php foreach ($UserServices as $key => $n) {
                                        if($n->CreatedBy == $UserID){?>
                                        <li class="clearfix">
                                            <div class="message-data text-right">
                                                <span class="message-data-time"><?php echo DatetimeFormat($n->CreatedAt);?></span> &nbsp; &nbsp; <span class="message-data-name"></span> <i class="zmdi zmdi-circle me"></i> 
                                            </div>
                                            <div class="message other-message float-right"><?php echo $n->Note;?> </div>
                                        </li>
                                        <?php }else{?>
                                        <li>
                                            <div class="message-data">
                                            <span class="message-data-name"><i class="zmdi zmdi-circle online"></i></span> <span class="message-data-time"><?php echo DatetimeFormat($n->CreatedAt);?></span>
                                            </div>
                                            <div class="message my-message">
                                            <p><?php echo $n->Note;?></p>
                                            </div>
                                        </li>                        
                                    <?php } }?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                
            </div>
        </div>

    </section>
    <footer id="sidebar-footer">
        <div class="sidebar-footer">
            <div class="row footer-input">
            <div class="col-md-12 card">
                    <div class="row in-div">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Add New Note <span class="text-danger">*</span></label>
                                <?php echo form_textarea($Note); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="side-footer-button">
                <div class="form-group">
                    <?php
                        echo form_submit($submit_btn);
                        echo form_button($cancel_btn);
                    ?>
                </div>
            </div>
        </div>
    </footer>
</div>
<?php echo form_close(); ?>