<script id="single-upload-media-template" type="text/x-handlebars-template">
    <div class="uploads__image">
        <img src="{{media}}" alt="image" />
        <div class="uploads__image-close deleteFile" data-id="{{id}}" data-guid="{{guid}}"><i class="fa fa-close"></i></div>
        <div class="uploads__image-content">{{file}}</div>
    </div>
</script>
<script id="upload-media-template" type="text/x-handlebars-template">
    <div class="owl-item">
        <div class="item">
            <a href="javascript:;">
                <div class="overlay_icons">
                    <div class="close removeImage" data-id="{{id}}"  data-guid="{{guid}}"><i class="fa fa-close"></i></div>
                </div>
                <img src="{{media}}" alt="image" />
            </a>
        </div>
    </div>
</script>
<script id="icon-upload-media-template" type="text/x-handlebars-template">
    <div class="uploads__image">
        {{#if image}}
            <img src="{{media}}" alt="image" />
        {{/if}}
        <div class="uploads__image-close removeImage" data-id="{{id}}" data-unqid="{{unqid}}"><i class="fa fa-close"></i></div>
        <div class="uploads__image-content">{{file}}</div>
    </div>
</script>
