<div class="SettingPanel__inner">
    <a href="javascript:;" class="SettingPanel__close" title="Close"><span class="circularButtonView"><img class="svgIcon svg-inject" src="dist/images/icons/icon_close.svg" alt="Close"></span></a>
    <h3 class="form-section">Publish Settings</h3>
    <form class="SettingPanelForm" name="" action="#" method="post">
        <div class="tabbable tabbable-custom setting-page">
            <ul class="nav nav-tabs">
                <li class=""><a href="#SettingGeneral" role="tab" data-toggle="tab">General</a></li>
                <li class="active"><a href="#SettingAdvanced" role="tab" data-toggle="tab">Advanced</a></li>
            </ul>
            <div class="tab-content">
                <!-- Begin General Tab -->
                <div class="tab-pane fade" id="SettingGeneral">
                    <div class="SettingPanelScroller">
                        <div class="form-group clearfix">
                            <div id="publish-wrapper" class="col-md-12">
                                <label class="publish-label" for="ms-publish">Publish to</label>
                                <input class="form-control" name="ms-publish" id="ms-publish">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-md-6">
                                <label for="label">Label</label>
                                <div class="selectCont">
                                    <select name="label" id="label">
                                        <option selected="" value="0">Select Label</option>
                                        <option value="1" selected>Livestock</option>
                                        <option value="2">Livestock</option>
                                    </select>
                                    <label><i class="fa fa-angle-down"></i></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="author">Author</label>
                                <div class="selectCont">
                                    <select name="author" id="author">
                                        <option selected="" value="0">Select Author</option>
                                        <option value="1" selected>Tom Spencer</option>
                                        <option value="2">Tom Spencer</option>
                                    </select>
                                    <label><i class="fa fa-angle-down"></i></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div id="social-wrapper" class="col-md-12">
                                <label class="social-label" for="ms-social">Amplify with social</label>
                                <input class="form-control" name="ms-social" id="ms-social">
                                <div class="social-item-lists">
                                    <a href="javascript:;" class="facebook tag"><span><i class="fa fa-facebook"></i>Facebook</span><b title="Removing tag"></b></a>
                                    <a href="javascript:;" class="twitter tag"><span><i class="fa fa-twitter"></i>Twitter</span><b title="Removing tag"></b></a>
                                    <a href="javascript:;" class="youtube tag"><span><i class="fa fa-youtube"></i>YouTube</span><b title="Removing tag"></b></a>
                                    <a href="javascript:;" class="instagram tag"><span><i class="fa fa-instagram"></i>Instagram</span><b title="Removing tag"></b></a>
                                    <a href="javascript:;" class="linkedin tag"><span><i class="fa fa-linkedin"></i>Linkedin</span><b title="Removing tag"></b></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="schedule">Schedule for later</label>
                                <input type='text' class="form-control" id='datetimepicker4' placeholder='Select date and time' />
                            </div>
                        </div>

                        <div class="form-group form-vh">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label for=""><span>Schedule for later</span></label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 text-right mobile-left-align">
                                <div class="btn-group" aria-label="..." role="group">
                                    <button class="button green bordered" type="button">On</button>
                                    <button class="button grey bordered" type="button">Off</button>
                                </div>
                            </div>
                        </div>

                        <div class="setting-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="button blue button-block large" type="button">Publish Article</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="button grey bordered button-block large" type="button">Save Draft</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="button opaque bordered button-block large" type="button">Cancel</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <a href="javascript:;" class="link-red">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //End General Tab -->

                <!-- Begin Advance Tab -->
                <div class="tab-pane fade in active" id="SettingAdvanced">
                    <div class="SettingPanelScroller">
                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="MetaTitle">Meta Title</label>
                                <input name="MetaTitle" id="MetaTitle" class="form-control" type="text" placeholder="Meta Title">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="MetaDescription">Meta Description</label>
                                <input name="MetaDescription" id="MetaDescription" class="form-control" type="text" placeholder="Meta Description">
                            </div>
                        </div>

                        <div class="form-group clearfix bootstrap-fileinput-style-01">
                            <div class="col-md-6">
                                <label for="CoverImage">Upload Opengraph Image</label>
                                <input type="file" name="CoverImage" id="CoverImage">
                                <span class="font12 font-italic">** photo must not bigger than 250kb</span>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="customurl">Custom URL</label>
                                <input name="customurl" id="customurl" class="form-control" type="text" placeholder="/article-name">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <label for="ArticleTags">Add tags</label>
                                <div class="addtags">
                                    <input type="text" class="c9n-ippt" name="ArticleTags" id="ArticleTags" placeholder="" maxlength="40">
                                    <a href="javascript:;" class="AddTagsPlus"><span class="circularButtonView"><img src="dist/images/icons/icon_plus.svg" class="svg-inject svgIcon"></span></a>
                                </div>
                                <div class="autocomplete-selected-item-lists">
                                    <a href="javascript:;" class="tag"><span>Websites</span><b title="Removing tag"></b></a>
                                    <a href="javascript:;" class="tag"><span>Interface</span><b title="Removing tag"></b></a>
                                </div>
                            </div>
                        </div>

                        <div class="setting-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="button blue button-block large" type="button">Publish Article</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="button grey bordered button-block large" type="button">Save Draft</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="button opaque bordered button-block large" type="button">Cancel</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <a href="javascript:;" class="link-red">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //End Advance Tab -->
            </div>
        </div>
    </form>
</div>