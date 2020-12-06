/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var dropdownList = '<option value="">Select Section</option>'+
                    '{{#each this }} ' +
                        '<option value="{{@key}}">{{this}}</option>'+
                    '{{/each}}';
            
var optionGroupDropdownList =  
                    '{{#each list}}'+
                        '<optgroup label="{{@key}}">'+
                        '{{#each this }} ' +
                        '<option value="{{@key}}">{{this}}</option>'+
                         '{{/each}}'+
                        '</optgroup>'+
                    '{{/each}}';

var groupCheckBoxListLayout =  '<div class="row">'+
                    '<div class="col-md-12 col-sm-12 col-xs-12">'+
                        '<div class="application-accordian">'+
                            '{{#each list}}'+
                                '<div class="application-accordian__container">'+
                                    '<div class="application-accordian__header">'+
                                        '<div class="accordian-icon js-accordian">'+
                                            '<span class="fa fa-caret-right"></span>'+
                                        '</div>'+
                                        '<div class="accordian-info">'+
                                            '<div class="custom-checkbox pull-left">'+
                                                '<label>'+
                                                    '<input data-id="{{@key}}" name="category" value="1" hidefocus="" type="checkbox" class="select-on-check-all">'+
                                                    '<span for="kyc">{{@key}}</span>'+
                                                '</label>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                        '<div class="application-accordian__list" id="{{@key}}">'+
                                            '<ul>'+
                                                  '{{#each this }} ' +
                                                    '<li>'+
                                                        '<div class="custom-checkbox pull-left">'+
                                                            '<label>'+
                                                                '<input id="" name="UpdateStatusForm[comments][]" value="{{@key}}" hidefocus="" type="checkbox" class="listComments">'+
                                                                '<span for="RememberMe">{{this}}</span>'+
                                                            '</label>'+
                                                        '</div>'+
                                                    '</li>'+
                                                 '{{/each}}'+
                                            '</ul>'+
                                        '</div>'+
                                '</div>'+
                            '{{/each}}'+
                        '</div>'+
                         
                    '</div>'+
                '</div>';
var checkBoxListLayout =  '<div class="row">'+
                    '<div class="col-md-12 col-sm-12 col-xs-12">'+
                        '<div class="application-accordian">'+
                                '<div class="application-accordian__container">'+
                                        '<div class="application-accordian__list" style="display:block;">'+
                                            '<ul>'+
                                                  '{{#each this }} ' +
                                                    '<li>'+
                                                        '<div class="custom-checkbox pull-left">'+
                                                            '<label>'+
                                                                '<input id="comment" name="UpdateStatusForm[comments][]" value="{{@key}}" hidefocus="" class="listComments" type="checkbox">'+
                                                                '<span for="comment">{{this}}</span>'+
                                                            '</label>'+
                                                        '</div>'+
                                                    '</li>'+
                                                 '{{/each}}'+
                                            '</ul>'+
                                        '</div>'+
                                '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';        
                    
            

var groupDropdownList = '<select name ="fee_group_id" class="chzn-select form-control">'+
                            '{{#each this }} ' +
                                '<option value="{{@key}}">{{this}}</option>'+
                            '{{/each}}'+
                        '</select>';

var componentDropdownList =  '<select name ="fee_component_id" class="chzn-select form-control">'+
                            '{{#each this }} ' +
                                '<option value="{{@key}}">{{this}}</option>'+
                            '{{/each}}'+
                        '</select>';
                
var groupComponentDropDownList = 
                            '{{#each this }} ' +
                                '<option value="{{@key}}">{{this}}</option>'+
                            '{{/each}}';
var optionDropdownList = 
                            '{{#each this }} ' +
                                '<option value="{{@key}}">{{this}}</option>'+
                            '{{/each}}';

var optionListType =        '{{#each this }} ' +
                                '<option value="{{@key}}">{{this}}</option>'+
                            '{{/each}}';

var sliderItem = '<div class="item" id="owl-item{{id}}">'+
                        '<a href="javascript:;" data-media-id = "{{id}}">'+
                            '<div class="overlay_icons">'+
                                '<div class="close removeImage" data-id="{{id}}"  data-unqid="{{unqid}}">'+
                                    '<i class="fa fa-close"></i>'+
                                '</div>'+
                            '</div>'+
                            '<img src="{{media}}" alt="image" />'+
                         '</a>'+
                    '</div>';
            
var attachment = '<div class="uploads__image">'+
                    '<img src="{{media}}" alt="image" />'+
                    '<div class="uploads__image-close deleteFile" data-id="{{id}}" data-unqid="{{unqid}}"><i class="fa fa-close"></i></div>'+
                    '<div class="uploads__image-content">{{file}}</div>'+
                '</div>';
        
        
var attendancemessagecheckbox = '<label class="custom-checkbox pull-left">' +
        '<input id="sendDefaultMessage" name="defaultMessageSend" type="checkbox" checked>' +
        '<span for="defaultMessage">Send messsage to default admin number\'s</span>' +
        '</label>';   

var dealingHead = '<div class="modal-body">' +
        '<div class="row">' +
        '<div class="col-md-6 col-sm-12 col-xs-12">' +
        '<div class="form-group">' +
        '<label class="control-label" for="application-status">Application Status</label>' +
        '<select name ="application_status" class="chzn-select form-control applicationStatus">' +
        '{{#each status }} ' +
        '<option value="{{@key}}">{{this}}</option>' +
        '{{/each}}' +
        '</select>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-6 col-sm-12 col-xs-12">' +
        '<div class="form-group">' +
        '<label class="control-label" for="date">Date</label>' +
        '<input name="date" class="form-control grievanceDate" data-guid="{{guid}}" autocomplete ="off">' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="row has-margin-top-20">' +
        '<div class="col-md-12 col-sm-12 col-xs-12">' +
        '<div class="form-group">' +
        '<label class="control-label" for="description">Description</label>' +
        '<input name="description" class="form-control description" autocomplete ="off" readonly>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

var accountManager = '<div class="modal-body">' +
        '<div class="row">' +
        '<div class="col-md-6 col-sm-12 col-xs-12">' +
        '<div class="form-group">' +
        '<label class="control-label" for="application-status">Application Status</label>' +
        '<select name ="application_status" class="chzn-select form-control applicationStatus">' +
        '{{#each status }} ' +
        '<option value="{{@key}}">{{this}}</option>' +
        '{{/each}}' +
        '</select>' +
        '</div>' +
        '</div>' +
        '<div class="col-md-6 col-sm-12 col-xs-12">' +
        '<div class="form-group">' +
        '<label class="control-label" for="transactionNo">Transaction no.</label>' +
        '<input name="transaction_no" class="form-control transaction_no" autocomplete ="off">' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

var reassignedTargetLogs = '<div class="modal-dialog content__preview" role="document">'+
    '<div class="modal-content">'+
        '<div class="modal-header">'+
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                '<span aria-hidden="true">&times;</span>'+
            '</button>'+
            '<h4 class="modal-title"><i class="fa fa-edit"> </i> Message</h4>'+
        '</div>'+
        '<div class="modal-body">'+
        ' <section class="widget__wrapper">'+
            '<div class="table__structure has-margin-0 hidett">'+
                '<div class="table-responsive grievancecomm">'+
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>Total Records</th>'+
                                '<th>Success Records </th>'+
                                '<th colspan="2">Failed Records</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                                    '<tr>'+
                                        '<td>{{totalRecords}}</td>'+
                                        '<td>{{successRecords}}</td>'+
                                        '<td>{{failedRecords}}</td>'+
                                    '</tr>'+
                        '</tbody>'+
                    '</table>'+
                '</div>'+
            '</div>'+
            '</section>'+
            ' <section class="widget__wrapper">'+
            '<div class="table__structure has-margin-0 hidett">'+
                '<div class="table-responsive grievancecomm">'+
                    '<table class="table">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>Message</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody>'+
                            '{{#each errors }} ' +
                                    '<tr>'+
                                        '<td>{{this}}</td>'+
                                    '</tr>'+
                            '{{/each}}';
                        '</tbody>'+
                    '</table>'+
                '</div>'+
            '</div>'+
            '</section>'+
        '</div>'+
    '</div>'+
'</div>';
        
     
       
       