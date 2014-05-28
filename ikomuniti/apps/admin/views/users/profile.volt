{{ partial("partials/navigation") }} 
{% for user in users %}
  <div class="row">
          <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row"> 
               
                  <div class="col-xs-6 text-left"> 
                    <h4>{{ wallet }}</h4> 
                    <p class="announcement-text">iPoint</p>
                  </div>
                </div>
              </div>
              <a href="{{ admin_path }}wallets/add">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Add iPoint
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
         
          <div class="col-lg-3">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                   
                  <div class="col-xs-6 text-left">
                    <h4>{{ user.insuran_due_date }}</h4>
                    <p class="announcement-text">Due</p>
                  </div>
                </div>
              </div>
              <a href="{{ admin_path }}insuran/update/{{user.id}}">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-8">
                      Quotation
                    </div>
                    <div class="col-xs-4 text-right">
                      <i class="glyphicon glyphicon-user"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
           <div class="col-lg-3">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row"> 
                  <div class="col-xs-6 text-left">
                    <h4>{{ epin_balance }}</h4>
                    <p class="announcement-text">iPin</p>
                  </div>
                </div>
              </div>
              <a href="{{ admin_path }}epins/transfer">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Add iPin
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
			<div class="col-lg-3">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                   
                  <div class="col-xs-6 text-right">
                    <h4>{{event}}</h4>
                    <p class="announcement-text">Status</p>
                  </div>
                </div>
              </div>
              <a href="{{ admin_path }}users/ireseller/{{user.username}}">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6 col-lg-8"> 
                    Add as iReseller
                    </div>
                    <div class="col-xs-6 col-lg-4 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div><!-- /.row -->
<div class="row">
<div class="col-lg-12">
  <div class="panel panel-primary">
    <div class="panel-heading">
	  <h3 class="panel-title">{{user.username}} Profile</h3>
	</div>
	<div class="panel-body">     
	{{ content()}} 
      <div class="bs-example user-profile">
            <ul class="list-group">
         {{link_to('gghadmin/users/edit/' ~ user.username, '<i class="fa fa-edit"></i> Edit '~user.username~' Profile', 'class': 'btn btn-success')}} 
        
	       <h4><b>Personal Information</b></h4> 
		   
		      <li class="list-group-item">Sponsor: <span class="space-left col-xs-12"><b>{{user.username_sponsor}}</b></span></li>
		      <li class="list-group-item">Username: <span class="space-left col-xs-12"><b>{{user.username}}</b></span></li>
		      <li class="list-group-item">Full Name: <span class="space-left col-xs-12 capitalize"><b>{{user.name|e}}</b></span></li>
		      <li class="list-group-item">NRIC: <span class="space-left col-xs-12"><b>{{user.nric_new}}</b></span></li>
		      <li class="list-group-item">Occupation: <span class="space-left col-xs-12 capitalize"><b>{{user.occupation|e}}</b></span></li>
		      <li class="list-group-item">Next Of Kin: <span class="space-left col-xs-12 capitalize"><b>{{user.kin_name|e}}</b></span></li>
		      <li class="list-group-item">Kin Phone: <span class="space-left col-xs-12"><b>{{user.kin_phone}}</b></span></li>
		      <li class="list-group-item">Relation: <span class="space-left col-xs-12 capitalize"><b>{{user.relation|e}}</b></span></li>
		      <li class="list-group-item">Kin NRIC: <span class="space-left col-xs-12"><b>{{user.nric_new_kin}}</b></span></li> 
		      <li class="list-group-item">Address: <span class="space-left col-xs-12 capitalize"><b>{{user.address|e}}</b></span></li>
		      <li class="list-group-item">Address Line 2: <span class="space-left col-xs-12 capitalize"><b>{{user.second_address|e}}</b></span></li>
		      
		      <li class="list-group-item">Postcode: <span class="space-left col-xs-12"><b>{{user.postcode}}</b></span></li>
		      <li class="list-group-item">City: <span class="space-left col-xs-12 capitalize"><b>{{user.city|e}}</b></span></li>
		      <li class="list-group-item">Region: <span class="space-left col-xs-12"><b>{{user.region|e}}</b></span></li>
		      <li class="list-group-item">Phone: <span class="space-left col-xs-12"><b>{{user.telephone}}</b></span></li>
		      <li class="list-group-item">Email: <span class="space-left col-xs-12"><b>{{user.email}}</b></span></li>
		      <li class="list-group-item">Join Date: <span class="space-left col-xs-12"><b>{{user.created}}</b></span></li>
		      
		      <li class="list-group-item">Bank Name: <span class="space-left col-xs-12 capitalize"><b>{{user.bank_name|e}}</b></span></li>
		      <li class="list-group-item">Account Number: <span class="space-left col-xs-12 capitalize"><b>{{user.bank_number|e}}</b></span></li>
		   </ul> 
  </div>     
      <div class="bs-example user-profile">
            <ul class="list-group"> {{link_to('gghadmin/users/edit/' ~ user.username, '<i class="fa fa-edit"></i> Edit '~user.username~' Profile', 'class': 'btn btn-success')}} 
	       <h4><b>Vehicle Information</b></h4> 
	      <li class="list-group-item">Previous Insurance: <span class="space-left col-xs-12 capitalize"><b>{{user.previous_insuran_company|e}}</li>
	      <li class="list-group-item">Cover Note: <span class="space-left col-xs-12"><b>{{user.cover_note|e}}</b></span></li>
	      <li class="list-group-item">NCD: <span class="space-left col-xs-12"><b>{{user.insuran_ncb}}</b></span></li>
	      <li class="list-group-item">Road Tax: <span class="space-left col-xs-12"><b>{{user.road_tax}}</b></span></li>
	      <li class="list-group-item">Due Date: <span class="space-left col-xs-12"><b>{{user.insuran_due_date}}</b></span></li>
	      
	      <li class="list-group-item">Reg No: <span class="space-left col-xs-12"><b>{{user.reg_number}}</b></span></li>
	      <li class="list-group-item">Owner Name: <span class="space-left col-xs-12 capitalize"><b>{{user.owner_name}}</b></span></li>
	      <li class="list-group-item">Owner NRIC: <span class="space-left col-xs-12"><b>{{user.owner_nric}}</b></span></li>
	      <li class="list-group-item">Owner DOB: <span class="space-left col-xs-12"><b>{{user.owner_dob}}</b></span></li>
	      <li class="list-group-item">Model: <span class="space-left col-xs-12 capitalize"><b>{{user.model|e}}</b></span></li>
	      <li class="list-group-item">Year Make: <span class="space-left col-xs-12"><b>{{user.year_make}}</b></span></li>
	      <li class="list-group-item">Cubic Capacity: <span class="space-left col-xs-12"><b>{{user.capacity}}</b></span></li>
	      <li class="list-group-item">Engine No: <span class="space-left col-xs-12"><b>{{user.engine_number|e}}</b></span></li>
	      <li class="list-group-item">Chasis No: <span class="space-left col-xs-12"><b>{{user.chasis_number|e}}</b></span></li>
	      
	      <li class="list-group-item">Grant Serial: <span class="space-left col-xs-12"><b>{{user.grant_serial_number|e}}</b></span></li>
	    </ul>  
           
{% endfor %} 
  </div>
</div> 
      </div>
	</div>
  </div>
</div> 
{{ partial("partials/footer") }}