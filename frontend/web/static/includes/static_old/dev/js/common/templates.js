/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var dropdownList = '<option value="">Select Section</option>'+
                    '{{#each this }} ' +
                        '<option value="{{@key}}">{{this}}</option>'+
                    '{{/each}}';

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
        
     
       
       