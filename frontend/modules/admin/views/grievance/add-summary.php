<?php
use yii\widgets\DetailView;
$this->title = 'Grievance View';
?>

<div class="page__bar">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <aside class="section section__left">
          <h2 class="section__heading upper">Grievance Manager</h2>
        </aside>
      </div>
    </div>
  </div>
</div>
<!-- Begin Form section -->
<div class="page-main-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="grievance__wrapper"> 
          
          <!--State History section start-->
          <section class="widget__wrapper">
            <div class="addSection">
            
            <div class="heading">
            Add Grievance <span>Enter  Mobile Number</span>
            </div>
            
              <input type="text" id="grivance-search" class="form-control" name="" placeholder="Mobile Number" aria-invalid="false">
              <button type="submit" class="button blue small">Submit</button>
            </div>
            <div class="section_head">
              <h2>Other Grievance </h2>
            </div>
            <div class="table__structure has-margin-0">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Location<br/>
                        [Vill. / Dis. / State ]</th>
                      <th>Name</th>
                      <th>Application<br/>
                        Status</th>
                      <th>Eligibility <br/>
                        Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>04 Feb 2019</td>
                      <td>Kirti Bhardwaj - Kirti - Student</td>
                      <td>asdfsf</td>
                      <td>asdfsf</td>
                      <td>asdfsf</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
          <!--State History section end--> 
          
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Form section -->