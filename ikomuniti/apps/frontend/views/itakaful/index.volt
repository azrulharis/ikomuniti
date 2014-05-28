<script type="text/javascript">
    $(function() {
        $('#readmore_windscreen').click(function() {
        $('.result_windscreen').toggle();
        return false;
        });
		$('#readmore_crp').click(function() {
        $('.result_crp').toggle();
        return false;
        });
		$('#readmore_pa').click(function() {
        $('.result_pa').toggle();
        return false;
        }); 
        $('#readmore_sum').click(function() {
        $('.result_sum').toggle();
        return false;
        }); 
        $('#readmore_sms').click(function() {
        $('.result_sms').toggle();
        return false;
        });
    });
</script>
{{ partial("partials/navigation") }}
<div class="row">
    <div class="col-lg-12">  
        <div class="alert alert-dismissable alert-info">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Attention!</strong> You will receive Insurance Quotation within 1 month before expiry date.<br/>
          <strong>Perhatian!</strong> Anda akan menerima Sebut Harga Insuran dalam tempoh 1 bulan sebelum tamat tempoh.
        </div>  
	</div>
</div>
{% for insurance in insurances %}
<div class="row"> 
<div class="col-lg-6">
    <div class="panel panel-primary">
			    <div class="panel-heading">
				  <h3 class="panel-title">iTakaful</h3>
				</div> 
                <div class="panel-body">
                <div class="table-responsive">
      			<table class="table table-bordered table-hover table-striped tablesorter"> 
      			    {% for info in navigations %}
                    <tr>
					   <td>Registration Number: </td><td>{{ info.reg_number }}</td>
					 </tr>
					{% endfor %}
					<tr>
					   <td>Due Date: </td><td>{{ insurance.next_renewal }}</td>
					 </tr>
                     <tr>
					   <td>Sum Insured: </td><td>RM{{ insurance.cover }}</td>
					 </tr>
                     <tr><td>Takaful Premium Amount: </td><td>RM{{ insurance.insurance }}</td></tr>
                     <tr><td>Road Tax Fee: </td><td>RM{{ insurance.road_tax }}</td></tr>
                     <tr><td>Windscreen Sum Insured: </td><td>RM{{ insurance.wind_screen }}</td></tr>
                     <tr><td>Windscreen Premium: </td><td>RM{{ insurance.wind_screen * 0.15 }}</td></tr>
                     <tr><td>Free Towing Service: </td><td>RM200</td></tr></td></tr>
                     <tr><td>Car Replacement Program: </td><td>{% if insurance.crp == 120 %}
                       1 Year CRP (RM120)
                       {% elseif insurance.crp == 78 %}
                       Additional 9 month CRP (RM78)
                       {% else %} 
                       N/A
                       {% endif %}</td></tr>
                     <tr><td>Additional Driver Premium: </td><td>RM{{ insurance.driver_total }}</td></tr> 
                     <tr><td>Additional Driver Name: </td><td>{{ insurance.second_driver }}</td></tr>
                     <tr><td>Personal Accident (PA): </td><td>
					 {% if insurance.pa == 50 %}
					 RM50 Sum Covered RM10K per Person (Max 5 person)
					 {% elseif insurance.pa == 90 %}
					 RM90 Sum Covered RM20K per Person (Max 5 person)
					 {% elseif insurance.pa == 130 %}
					 RM130 Sum Covered RM30K per Person (Max 5 person) 
					 {% elseif insurance.pa == 170 %}
				     RM170 Sum Covered RM40K per Person (Max 5 person) 
				     {% elseif insurance.pa == 210 %}
				     RM210 Sum Covered RM50K per Person (Max 5 person)
					 {% else %}
					 N/A
					 {% endif %} 
					 </td></tr>
                     <tr><td>Myeg Service Charge: </td><td>RM{{ insurance.service_charge }}</td></tr>
                     <tr><td>Pos Laju Tracking: </td><td>{{ insurance.tracking_code }}</td></tr>
                     <tr><td>Total Amount To Pay: </td><td>RM{{ insurance.total }}</td></tr>
                     
                     <tr><td>Payment</td><td>{{ link_to('wallets/index?amount='~insurance.total, 'Pay Now', 'class': 'btn btn-success')}}</td></tr>
                
                </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="panel panel-primary">
			    <div class="panel-heading">
				  <h3 class="panel-title">Add iTakaful</h3>
				</div> 
                <div class="panel-body">
                {{ content() }}
                 {{ form('itakaful/index', 'method': 'post')}}
                 <div class="form-group">
                   <label>Jumlah Perlindungan Takaful (Sum Insured) <a href="" id="readmore_sum"><i class="fa fa-question-circle"></i></a></label>
                   <div class="result_sum" style="display:none; width:100%;height:auto;">Jumlah Perlindungan Takaful (Sum Insured) adalah mengikut harga pasaran semasa kenderaan tersebut yang ditetapkan oleh Bank Negara. Jumlah Perlindungan Takaful boleh diturunkan sehingga 20% daripada harga pasaran yang ditetapkan. Jumlah Perlindungan Takaful yang diturunkan sebanyak 20% boleh mendatangkan <b>risiko kewangan</b> jika berlaku sebarang insiden yang tidak diingini. Pihak Takaful hanya akan membayar 80% daripada jumlah tuntutan. <b>Tertakluk kepada Polisi Perlindungan Takaful</b>. Pihak iShare tidak menggalakkan anda untuk menurunkan Jumlah Perlindungan Takaful</div>
                   <input type="text" name="sum" class="form-control" value="{{ insurance.cover }}"> 
                 </div>
                 
                 <div class="form-group">
                   <label>Windscreen (Jumlah Perlindungan Takaful) <a href="" id="readmore_windscreen"><i class="fa fa-question-circle"></i></a></label>
                   <div class="result_windscreen" style="display:none; width:100%;height:auto;">Sila masukkan jumlah perlindungan Takaful Windscreen yang dikehendaki. Perlindungan Windscreen merangkumi cermin hadapan, belakang dan kesemua cermin tingkap. Jumlah perlindungan minimum yang ditetapkan untuk Windscreen adalah RM300 dengan bayaran Premium RM45. Tambahan bayaran Premium sebanyak RM15 untuk setiap penambahan Perlindungan Takaful RM100. Contoh: Perlindungan Takaful Windscreen RM500 (Bayaran Premium RM75)</div>
                   <input type="text" name="windscreen" class="form-control" placeholder="300">
                 </div>
                 <div class="form-group">
                   <label>Car Replacement Program (CRP) <a href="" id="readmore_crp"><i class="fa fa-question-circle"></i></a></label>
                   <div class="result_crp" style="display:none; width:100%;height:auto;">Car Replacement Program (CRP) merupakan Program Gantian Kenderaan sementara sekiranya berlaku kemalangan yang menyebabkan anda tidak mempunyai kenderaan untuk digunakan. Kenderaan CRP tersebut boleh digunakan selama 14 hari pada setiap kali kemalangan dalam tempoh Polisi CRP berkuatkuasa. Kadar bayaran untuk perlindungan Takaful RM500 dan keatas adalah RM78 untuk tambahan 9 bulan (3 bulan pertama adalah percuma). Kadar bayaran untuk Perlindungan Takaful dibawah RM500 adalah RM120 untuk tempoh 12 bulan. Untuk maklumat lanjut, sila hubungi Hotline iShare di 03 8922 2277.</div>
                   <select name="crp" class="form-control">
                       <option value="0">Select</option>
                       {% if insurance.insurance >= 500 %}
                       <option value="78">14 Day CRP (RM78)</option>
                       {% elseif insurance.insurance < 500 AND insurance.insurance > 0 %}
                       <option value="120">14 Day CRP (RM120)</option>
                       {% else %}
                       <option value="78">14 Day CRP (RM78)</option>
                       <option value="120">14 Day CRP (RM120)</option>
                       {% endif %}
                    </select>
                 </div>
                 <div class="form-group">
                   <label>2nd Driver - Name (I/C Number) Free</label> 
                   <input type="text" name="driver" class="form-control" placeholder="Ali Bin Abu (780901106789)"> 
                 </div>
                 <div class="form-group">
                   <label>3rd Driver - Name (I/C Number) RM10</label>  
                   <input type="text" name="2driver" class="form-control" placeholder="Ahmad Bin Abu (780901106789)"> 
                 </div>
                 <div class="form-group">
                   <label>4th Driver - Name (I/C Number) RM10</label>  
                   <input type="text" name="3driver" class="form-control" placeholder="Aminah Binti Abu (890901106784)"> 
                 </div>
                 <div class="form-group">
                   <label>5th Driver - Name (I/C Number) RM10</label> 
                   <input type="text" name="4driver" class="form-control" placeholder="Intan Ladyana Binti Halim (890901106786)">  
                 </div>
                 <div class="form-group">
                   <label>Personal Accident (PA) <a href="" id="readmore_pa"><i class="fa fa-question-circle"></i></a></label>
                   <div class="result_pa" style="display:none; width:100%;height:auto;">Personal Accident (PA) merupakan perlindungan terhadap Pemandu dan 4 orang Penumpang sekiranya berlaku kemalangan mengikut Polisi yang berkuatkuasa.</div>
                   <select name="pa" class="form-control">
				       <option value="0">Select</option>
					   <option value="50">RM50 Sum Covered RM10K per Person (Max 5 person)</option>  
				       <option value="90">RM90 Sum Covered RM20K per Person (Max 5 person)</option> 
				       <option value="130">RM130 Sum Covered RM30K per Person (Max 5 person)</option>
				       <option value="170">RM170 Sum Covered RM40K per Person (Max 5 person)</option> 
				       <option value="210">RM210 Sum Covered RM50K per Person (Max 5 person)</option>
				    </select>
				 
                 </div>
                 <div class="form-group"> 
                   <input type="submit" name="submit" value="Update" class="btn btn-success">
                 </div>
                </div>
              </div>
            </div>
          </div> 
	<div class="row"> 
		<div class="col-lg-6">
	    	<div class="panel panel-primary">
			    <div class="panel-heading">
				  <h3 class="panel-title">iTracking</h3>
				</div> 
		        <div class="panel-body">
		           <h4>Pos Laju Tracking: {{insurance.tracking_code}}</h4>
		           <div style="width: 100%; height: 284px; border: 1px solid #ccc; overflow: hidden; z-index: 999; padding-bottom: 5px;">
		             <iframe style="width: 100%; height: 400px; border: none; margin-top: -8px;" scrolling="no" id="extFrame" 
					 src="http://www.pos.com.my/emstrack/search.asp?x=%27oal_dbo%27"></iframe>
				   </div> 
		        </div>
	        </div>
		</div>  
		<div class="col-lg-6">
	    	<div class="panel panel-primary">
			    <div class="panel-heading">
				  <h3 class="panel-title">Prosedur Pembayaran</h3>
				</div> 
		        <div class="panel-body">
		            <div class="result_sms" style="display:none; background-color:#FDFDFD;width:100%;height:180px;">{{image('img/sms_screen.png', 'width': 250)}}</div>
                  <ol style="padding: 16px;">
		            <li>Setelah mendapat SMS Sebut Harga dari pihak iShare SMS <a href="" id="readmore_sms"><i class="fa fa-question-circle"></i></a>, pastikan jumlah yang perlu dibayar.</li> 
		            <li>Bayar jumlah yang telah ditetapkan atau hubungi Pejabat iShare jika ingin menambah Perlindungan Takaful, Windscreen, CRP dan sebagainya.</li>
		            <li>Pembayaran hendaklah dibuat kepada:
		              <br/>
					<span class="col-lg-3 col-xs-12">Nama</span><span class="col-lg-9 col-xs-12"><b>Global Group Holdings Sdn Bhd</b></span>
		            <span class="col-lg-3 col-xs-12">Bank</span><span class="col-lg-9 col-xs-12"><b>Maybank Berhad</b></span> 
		            <span class="col-lg-3 col-xs-12">No Akaun</span><span class="col-lg-9 col-xs-12"><b>5628 3450 3818</b></span> 
		            Pastikan anda menyimpan bukti bayaran sebagai rujukan.
					
					</li>
		            
		            
		            <li>Pihak iShare tidak bertanggungjawab sekiranya anda membuat bayaran ke akaun lain selain dari di atas.</li>
		            
		            <li>Segala bukti bayaran hendaklah dikemukakan kepada pihak iShare dengan mengisi borang {{ link_to('wallets/index', 'di sini', 'style': 'color: #032EAD; font-weight: bold;')}}.</li>
		            <li>Proses memperbaharui Takaful dan Cukai Jalan akan dibuat setelah pihak iShare mendapat maklumat mengenai bukti bayaran.</li>
		            <li>Setelah selesai urusan memperbaharui Takaful dan Cukai Jalan, anda akan menerima SMS pembaharuan Takaful dan Cukai Jalan beserta No. Tracking Poslaju (Jika penghantaran melalui Poslaju).</li>
		            <li>Jika terdapat sebarang masalah atau inginkan maklumat lanjut. Sila hubungi Hotline Takaful iShare. (Hari Bekerja - 9.00 pagi hingga 6.00 petang)<br/>
					<span class="col-lg-5 col-xs-12">Telefon</span><span class="col-lg-7 col-xs-12"><b>03 8922 2277</b></span>
					<span class="col-lg-5 col-xs-12">Telefon</span><span class="col-lg-7 col-xs-12"><b>03 8927 5228</b></span>
		            <span class="col-lg-5 col-xs-12">Call / SMS / Whatsapp</span><span class="col-lg-7 col-xs-12"><b>012 658 8135</b></span> 
		            <span class="col-lg-5 col-xs-12">Call / SMS / Whatsapp</span><span class="col-lg-7 col-xs-12"><b>012 298 0228</b></span>
		            <span class="col-lg-5 col-xs-12">Call / SMS / Whatsapp</span><span class="col-lg-7 col-xs-12"><b>012 639 3059 (6.00 Ptg - 12.00 Mlm)</b></span>
					</li>
		            </ol>
		        </div>
	        </div>
		</div> 
	</div>   
</div> 

{% endfor %}
{{ partial("partials/footer") }}