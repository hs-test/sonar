var PageController = (function ($) {
    return {
        createUpdate: function () {
            PageController.CreateUpdate.init();
        },
        initCKEditorClassic: function (selector) {
            ClassicEditor
                    .create(document.querySelector(selector))
                    .catch(error => {
                        console.error(error);
                    });
        },
        initCKEditor: function (selector) {
            CKEDITOR.replace(selector, {
                height: 800,
                toolbar: [
                    {name: 'document', items: ['Source']},
                    {name: 'basicstyles', groups: ['basicstyles'], items: ['Bold', 'Italic', 'Underline', '-', 'Strike', '-', 'RemoveFormat', 'CopyFormatting', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Link', 'Unlink']},
                    {clipboard: 'clipboard', items: ['PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                    {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
                    {name: 'styles', items: ['Styles', 'Format', 'FontSize']},
                    {name: 'insert', items: ['Table', 'HorizontalRule', 'SpecialChar', '-', 'Embed', '-', 'UploadImage']},
                    {name: 'tools', items: ['Maximize']}
                ],
                allowedContent: true,
                extraPlugins: 'justify,uploadimage,autogrow,image2,customstyles',
                removePlugins: 'liststyle,tabletools,scayt,contextmenu',
                autoGrow_minHeight: 400,
                autoGrow_maxHeight: 1800,
                autoGrow_onStartup: true,
                disableNativeSpellChecker: false,
            });
        },
        uploadfiles: function () {
            $('a.uploadFileBtn').uploadFile({
                maxImage: 1,
                cloudUpload: true,
                addRemoveLinks: false,
                acceptedFiles: ".jpg,.png,.gif",
                onSuccess: function (file, response) {
                    if (response.success == "1") {
                        var media = response.media;
                        var source = $("#single-upload-media-template").html();
                        var template = Handlebars.compile(source);
                        var html = template({media: media.cdnPath, id: media.orig, guid: media.guid, file: response.fileName});

                        $('.mediaContainer').append('<input id="mediafile' + media.orig + '" name="Page[media_id]" type="hidden" value="' + media.orig + '">');
                        $('.mediaUploadBox').addClass('hide');
                        $('.mediaResultset').removeClass('hide');
                        $('.mediaResultset').html(html);

                        $('#uploadImageModal').modal('hide');
                    } else {
                        $().General_ShowErrorMessage({message: 'Some error occured. Please try again!!'});
                    }
                }
            });
        },
        sendAjaxRequest: function (elem,params) {
            if (typeof params.url === 'undefined' || params.url === "") {
                $().General_ShowErrorMessage({message: "Oops! invalid url"});
                return;
            }
            if (typeof params.type === 'undefined' || params.type === "") {
                $().General_ShowErrorMessage({message: "Oops! invalid request type"});
                return;
            }
            
            $.ajax({
                type: params.type,
                url: params.url,
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    if (data.success == "1") {
                        elem.data('status', data.status);
                        if (params.module == 'status') {
                            if (data.status == "1") {
                                elem.attr('title', 'Active');
                                elem.html("<span class='badge badge-success'><span class='title'>Active</span> <i class='fa fa-spin fa-spinner spinner'></i></span>");
                            } else {
                                elem.attr('title', 'Inactive');
                                elem.html("<span class='badge badge-danger'><span class='title'>Inactive</span> <i class='fa fa-spin fa-spinner spinner'></i></span>");
                            }
                        }
                        if (params.module == 'delete') {
                            toastr.success("Record deleted successfully.");
                            $.pjax.reload({container: '#DataList', timeout: false})
                            
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (params.module == 'status') {
                        elem.find('.badge').removeClass('badge--spins');
                    }
                    if (params.module == 'delete') {
                        elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-trash'); // delete 
                    }
                    $().General_ShowErrorMessage({message: jqXHR.responseText});
                },
                beforeSend: function (jqXHR, settings) {
                    if (params.module == 'status') {
                        elem.find('.badge').addClass('badge--spins');
                    }
                    if (params.module == 'delete') {
                        elem.find('.fa').removeClass('fa-trash').addClass('fa-spin fa-spinner');
                    }
                },
                complete: function (jqXHR, textStatus) {
                    if (params.module == 'status') {
                         elem.find('.badge').removeClass('badge--spins');
                    }
                    if (params.module == 'delete') {
                        elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-trash');
                    }
                }
            });                  
        },
		deleteMedia: function (e) {
			$('.deleteFile').on('click', function (e) {
				e.preventDefault();
				var elem = $(this);
				var id = elem.data('id');
				var guid = elem.data('guid');
				if ((typeof id === undefined || id === "") || typeof guid === undefined || guid === "") {
					$().General_ShowErrorMessage({message: "Error: Invalid media file."});
				}

				bootbox.confirm({
					title: "Confirm",
					message: "Do you really want to delete this media?",
					className: "modal__wrapper",
					buttons: {
						confirm: {
							label: 'Yes',
							className: 'button blue'
						},
						cancel: {
							label: 'Cancel',
							className: 'button grey'
						}
					},
					callback: function (result) {
						if (result === true) {
							$.ajax({
								type: 'post',
								url: baseHttpPath + '/upload-file/remove-media',
								dataType: 'json',
								data: {id: id, guid: guid},
								success: function (data, textStatus, jqXHR) {
									if (data.success == "1") {
										if (data.success == "1") {
											$('.mediaResultset').addClass('hide');
											$('.mediaUploadBox').removeClass('hide');
											toastr.success("Media has been removed successfully.");
										}
									}
								},
								error: function (jqXHR, textStatus, errorThrown) {
									elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-close');
									$().General_ShowErrorMessage({message: jqXHR.responseText});
								},
								beforeSend: function (jqXHR, settings) {
									elem.find('.fa').addClass('fa-spin fa-spinner').removeClass('fa-close');
								},
								complete: function (jqXHR, textStatus) {
									elem.find('.fa').removeClass('fa-spin fa-spinner').addClass('fa-close');
								}
							});
						}
					}
				});
			});
		}
    };
}(jQuery));

PageController.CreateUpdate = (function ($) {
    var attachEvents = function () {
        
        updateStatus();
        deleteRecord();
        
        $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
            updateStatus();
            deleteRecord();
        });
        
        if($('#page-content').length){
            PageController.initCKEditor('page-content');
        }
        
        PageController.uploadfiles();
        PageController.deleteMedia();
    };
    
    var deleteRecord = function () {
//        $('body').on('click', '.deletePageRecord', function (e) {
        $('.deletePageRecord').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === '') {
                return;
            }
            bootbox.confirm({
                title: "Confirm",
                message: "Do you really want to delete this record?",
                className: "modal__wrapper",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'button blue'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'button grey'
                    }
                },
                callback: function (result) {
                    if (result === true) {
                        var params = {url: url, type: 'post', module: 'delete'};
                        PageController.sendAjaxRequest(elem, params);
                    }
                }
            });
        });
    };
    
    var updateStatus = function (e) {
        $('.updatePageStatus').on('click', function (e) {
            e.preventDefault();
            var elem = $(this);
            var url = elem.data('url');
            if (typeof url === 'undefined' || url === '') {
                return;
            }
            var params = {
                url: url, 
                type: 'post', 
                module: 'status', 
                postData: {_csrf: yii.getCsrfToken()}
            };
            ModuleController.sendAjaxRequest(elem, params);
        });
    };

    return {
        init: function () {
            attachEvents();
        }
    };
}(jQuery));