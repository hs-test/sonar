<!-- Begin global header section -->
<?php
$pageTitle = 'Admin Dashboard';
include("includes/_global-Head.php");
?>

<!-- End global header section -->

<!-- Begin header section -->
<section id="viewport">
    <div class="page-container">
        <!-- Begin Navigational Area -->
        <?php
        include("includes/_sidebar.php");
        ?>
        <!-- //End Navigational Area -->

        <!-- Begin Page Content Area -->
        <div class="page__content-wrapper">
            <div class="page__content-inner">
                <div class="page__content-section">
                    <!-- Begin Page Header Area -->
                    <?php
                    include("includes/_header.php");
                    ?>
                    <!-- //End Page Header Area -->

                    <!-- Begin Form section -->
                    <div class="page-main-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <section class="widget__wrapper">
                                        <form class="widget__wrapper-searchFilter">
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="sectionHead__wrapper">
                                                        <ul class="upper">
                                                            <li class="active"><a href="javascript:;">Form Title</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Begin single column section -->
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="form-group has-error">
                                                        <label class="control-label">Title</label>
                                                        <input class="form-control" type="text" placeholder="Title" />
                                                        <p class="help-block help-block-error">Title cannot be empty</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="form-group has-success">
                                                        <label class="control-label">Title2</label>
                                                        <input class="form-control" type="text" placeholder="Title2" />
                                                        <p class="help-block help-block-success">Input complete</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="form-group has-success">
                                                        <label class="control-label">Textarea</label>
                                                        <textarea></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End single column section -->

                                            <!-- Begin two column section -->
                                            <div class="row">
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">First Name</label>
                                                        <input class="form-control" type="text" placeholder="Title" />
                                                        <p class="help-block help-block-error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Last Name</label>
                                                        <input class="form-control" type="text" placeholder="Title" />
                                                        <p class="help-block help-block-error"></p>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Father's Name</label>
                                                        <input class="form-control" type="text" placeholder="Title" />
                                                        <p class="help-block help-block-error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Multi Select</label>
                                                        <select id="multiClassSelect" class="selectpicker custom-select classSelect" multiple data-actions-box="true">
                                                            <option>Select type</option>
                                                            <option>Type A</option>
                                                            <option>Type B</option>
                                                            <option>Type C</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End two column section -->

                                            <!-- Begin three column section -->
                                            <div class="row">
                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Select with Search</label>
                                                        <select class="chzn-select">
                                                            <option>Select type</option>
                                                            <option>Type A</option>
                                                            <option>Type B</option>
                                                            <option>Type C</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Select</label>
                                                        <div class="cog-select">
                                                            <select class="chzn-select">
                                                                <option>Select type</option>
                                                                <option>Type A</option>
                                                                <option>Type B</option>
                                                                <option>Type C</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Date Picker</label>
                                                        <input class="form-control datetimepicker4" type="text" placeholder="Posted Date" />
                                                        <p class="help-block help-block-error"></p>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Password</label>
                                                        <input class="form-control" type="password" placeholder="Password" />
                                                        <p class="help-block help-block-error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Email</label>
                                                        <input class="form-control" type="email" placeholder="Email" />
                                                        <p class="help-block help-block-error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Mobile number</label>
                                                        <input class="form-control" type="number" placeholder="Mobile number" />
                                                        <p class="help-block help-block-error"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End three column section -->

                                            <!-- Begin Four column section -->
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="custom-checkbox bottom-margin pull-left field-RememberMe">
                                                        <label>
                                                            <input id="RememberMe" name="LoginForm[rememberMe]" value="1" checked="" type="checkbox">
                                                            <span for="RememberMe"></span>
                                                        </label>
                                                    </div>  
                                                </div>
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="custom-checkbox bottom-margin pull-left field-RememberMe">
                                                        <label>
                                                            <input id="RememberMe" name="LoginForm[rememberMe]" value="1" checked="" type="checkbox">
                                                            <span for="RememberMe">Remember Me</span>
                                                        </label>
                                                    </div>  
                                                </div>
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="custom-checkbox bottom-margin pull-left field-RememberMe">
                                                        <label>
                                                            <input id="RememberMe" name="LoginForm[rememberMe]" value="1" checked="" type="checkbox">
                                                            <span for="RememberMe">Remember Me</span>
                                                        </label>
                                                    </div>  
                                                </div>
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="custom-checkbox bottom-margin pull-left field-RememberMe">
                                                        <label>
                                                            <input id="RememberMe" name="LoginForm[rememberMe]" value="1" checked="" type="checkbox">
                                                            <span for="RememberMe">Remember Me</span>
                                                        </label>
                                                    </div>  
                                                </div>
                                            </div>
                                            <!-- End Four column section -->

                                            <!-- Begin Four column section -->
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    <input type="checkbox" class="js-switch" checked />  
                                                </div>
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="custom-radio bottom-margin pull-left field-RememberMe">
                                                        <label>
                                                            <input id="RememberMe" name="LoginForm[rememberMe]" value="1" type="radio">
                                                            <span for="RememberMe">Remember Me</span>
                                                        </label>
                                                    </div>  
                                                </div>
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="custom-radio bottom-margin pull-left field-RememberMe">
                                                        <label>
                                                            <input id="RememberMe" name="LoginForm[rememberMe]" value="1" checked="" type="radio">
                                                            <span for="RememberMe">Remember Me</span>
                                                        </label>
                                                    </div>  
                                                </div>
                                                <div class="col-md-3 col-xs-12">
                                                    <div class="custom-radio bottom-margin pull-left field-RememberMe">
                                                        <label>
                                                            <input id="RememberMe" name="LoginForm[rememberMe]" value="1" checked="" type="radio">
                                                            <span for="RememberMe">Remember Me</span>
                                                        </label>
                                                    </div>  
                                                </div>
                                            </div>
                                            <!-- End Four column section -->

                                            <!-- Begin One column section -->
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="switchery-content">
                                                        <span class="content">
                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                                        </span>
                                                        <span class="icon">
                                                            <input type="checkbox" class="js-switch" checked />
                                                        </span>
                                                    </div>  
                                                </div>
                                            </div>    
                                            <!-- End One column section -->

                                            <!-- Begin Two column section -->
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="fileUploading__wrapper mediaDocumentBlock">
                                                        <div class="row">
                                                            <div class="col-lg-9 col-md-10 col-sm-12 col-xs-12">
                                                                <div class="uploads multi">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="javascript:;">
                                                                                <figure>
                                                                                    <img src="dist/images/icons/media.svg" alt="Media Icon">
                                                                                </figure>
                                                                                <p>Upload Documents 
                                                                                    <span>(Vaild file extension doc, docx, xlss, pdf, txt only)</span>
                                                                                </p>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:;">
                                                                                <figure>
                                                                                    <img src="dist/images/icons/media.svg" alt="Media Icon">
                                                                                </figure>
                                                                                <p>Upload Image 
                                                                                    <span>(Vaild file extension jpeg, png, giff only)</span>
                                                                                </p>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="uploads">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="javascript:;">
                                                                                <figure>
                                                                                    <img src="dist/images/icons/media.svg" alt="Media Icon">
                                                                                </figure>
                                                                                <p>Upload Documents 
                                                                                    <span>(Vaild file extension doc, docx, xlss, pdf, txt only)</span>
                                                                                </p>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="uploads">
                                                                    <div class="uploads__image">
                                                                        <img src="http://frontend.schoolproduct.com/static/admin/dist/images/icons/upload-doc.svg" alt="image">
                                                                        <div class="uploads__image-close deleteFile" data-id="211" data-unqid="a4ed0f80-3980-4057-a68f-59d5d5f9259f">
                                                                            <i class="fa fa-close"></i>
                                                                        </div>
                                                                        <div class="uploads__image-content">FInal.docx</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>    
                                            <!-- End Two column section -->

                                            <!-- Begin Buttons section -->
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="grouping equal-button  grouping__leftAligned">
                                                            <button type="submit" class="button blue">Create</button>                                    
                                                            <a href="javascript:;" class="button grey">Cancel</a>            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- End Buttons section -->
                                        </form>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Form section -->
                </div>
                <div class="clearfix"></div>
                <!-- Begin Footer section -->

                <?php
                include("includes/_footer.php");
                ?>
                <!-- End Footer section -->
            </div>
        </div>
    </div>
    <!-- End header section -->
</section>

<!-- Begin Script section -->
<?php
include("includes/_scripts.php");
?>
<!-- Begin Script section -->

</body>
</html>