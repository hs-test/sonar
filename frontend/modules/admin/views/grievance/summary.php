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
          
          <!-- Top Buttons row-->
          <div class="top_buttonWrap">
            <aside class="leftWrap">
              <button type="button" class="btn btn-info">Change Status</button>
              <button type="button" class="btn btn-success">Post Comments</button>
            </aside>
            <aside class="rightWrap">
              <button type="button" class="btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
              <div class="date">15-JAN-2019</div>
            </aside>
          </div>
          
          <!--Basic view start-->
          <section class="widget__wrapper">
            <div class="section_head">
              <h2>Basic</h2>
            </div>
            <div class="basicDetail">
              <div class="basicDetail_listing">
                <ul>
                  <li><span>Grievance</span> ABCD</li>
                  <li><span>Grievance Type</span> ABCD</li>
                  <li><span>Eligibility Status</span> ABCD</li>
                  <li><span>App. Status</span> ABCD</li>
                  <li><span>Name</span> Mr. Sumit</li>
                  <li><span>Gender</span> Male</li>
                  <li><span>Mobile</span> 8860686636</li>
                  <li><span>Email</span> sumitrec@gmail.com</li>
                  <li><span>Address / Pincode</span> c-218, Hari Nagar / 851216</li>
                  <li><span>Village</span> Parbatta</li>
                  <li><span>District </span> Delhi</li>
                  <li><span>State</span> Delhi</li>
                  <li class="full"><span>Description Complaint</span> Delhi</li>
                </ul>
              </div>
            </div>
          </section>
          <!--Basic view end--> 
          
          <!--State History section start-->
          <section class="widget__wrapper">
            <div class="section_head withLink">
              <h2><a href="javascript:;">Status History <i><!--plus icon--></i></a></h2>
            </div>
            <div class="table__structure has-margin-0">
              <div class="table-responsive grievancecomm">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Application Status / <br/>
                        Comments</th>
                      <th>Eligibility <br/>
                        Status</th>
                      <th>Taken By <br/>
                        [Name - User Name - Role]</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="statusHead">
                      <td>04 Feb 2019</td>
                      <td><span class="status">Status Head</span></td>
                      <td>Yes</td>
                      <td>Kirti Bhardwaj - Kirti - Student</td>
                    </tr>
                    <tr>
                      <td width="100%"  colspan="4"><table  cellspacing="0"  class="table table-bordered">
                          <tr>
                            <td>05 Feb 2019</td>
                            <td>Comment Here Start</td>
                            <td>Kirti</td>
                          </tr>
                          <tr>
                            <td>06 Feb 2019</td>
                            <td>Another Comment2  Here Start</td>
                            <td>abcd</td>
                          </tr>
                          <tr>
                            <td>07 Feb 2019</td>
                            <td>Another Comment2  Here Start</td>
                            <td>efgh</td>
                          </tr>
                        </table></td>
                    </tr>
                    
                     <tr class="statusHead">
                      <td>04 Feb 2019</td>
                      <td><span class="status">Status Head</span></td>
                      <td>Yes</td>
                      <td>Kirti Bhardwaj - Kirti - Student</td>
                    </tr>
                    
                    
                     <tr>
                      <td width="100%"  colspan="4"><table  cellspacing="0"  class="table table-bordered">
                          <tr>
                            <td>05 Feb 2019</td>
                            <td>Comment Here Start</td>
                            <td>Kirti</td>
                          </tr>
                          <tr>
                            <td>06 Feb 2019</td>
                            <td>Another Comment2  Here Start</td>
                            <td>abcd</td>
                          </tr>
                          <tr>
                            <td>07 Feb 2019</td>
                            <td>Another Comment2  Here Start</td>
                            <td>efgh</td>
                          </tr>
                        </table></td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </section>
          <!--State History section end--> 
          
          <!--State History section start-->
          <section class="widget__wrapper">
            <div class="section_head withLink">
              <h2><a href="javascript:;">Other Grievance <i><!--plus icon--></i></a></h2>
            </div>
            <div class="table__structure has-margin-0 hidett">
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