<form id="otp-form" action="/home/send-otp">
    <div class="form-group">
        <label class="label" for="Name"><span class="">Name</span></label>
        <input type="text" id="Name" placeholder="Enter Name" class="form-control" name="name" aria-required="true" required> 
        <p class="help-block help-block-error"></p>
    </div>
    <div class="form-group">
        <label class="label" for="Mobile Number"><span class="">Mobile Number</span></label>
        <input type="text" id="Name" placeholder="Enter Mobile Number" class="form-control" name="mobile" aria-required="true" required="required">  
        <p class="help-block help-block-error"></p>
    </div>
    <div class="form-group">
        <label class="label" for="Email"><span class="">Email</span></label>
        <input type="email" id="Name" placeholder="Enter Email" class="form-control" name="email" aria-required="true" required="required"> 
        <p class="help-block help-block-error"></p>
    </div>
    <button type="submit" id="sendOtp"  class="button theme__btn">Submit Now</button>
</form>