<style>
</style>
<?php
   $Adults=0; 
   $Extrabedcount=0;
   $Roomid=$_POST['roomid'];
   $delete="Delete temp_trans_roomdet_det_rent where roomid='".$Roomid."'";
   $deleqry =$this->db->query($delete);
   $Indate = str_replace('/', '-',$_POST['Fdat']);
   $Indate=date('Y/m/d', strtotime($Indate));
   $fromdate=date('Y/m/d', strtotime($Indate));
   $todate = str_replace('/', '-',$_POST['Tdat']);
   $todate=date('Y/m/d', strtotime($todate));
   $Res=$this->Myclass->Get_NightAuditdate();
  foreach($Res as $row)
  {  $DateofAudit=$row['DateofAudit'];}
   while ($Indate <= $todate) 
		{
		 $sql6="SELECT * FROM Mas_RatePlan RP 
		INNER JOIN Mas_RatePlan_Det RD on RD.RatePlan_Id=RP.RatePlan_Id
		INNER JOIN Mas_Plantype PT on PT.PlanType_Id=Rp.PlanType_Id
		INNER JOIN Mas_Roomtype RT on RT.RoomType_Id=RP.RoomType_Id
		INNER JOIN Mas_Room RM on RM.RoomType_Id =RT.RoomType_Id
		where RM.Room_Id ='".$Roomid."'  and isnull(RP.act,0)=0  Order by PT.PlanType_Id ";
		  $res6=$this->db->query($sql6);
		  $data=$res6->result();
		  foreach ($res6->result_array() as $row6)
		  { $Adults=$row6['Adults']; 
			$Extrabedcount=$row6['Extrabedcount'];
			$singlerent=$row6['Single']; 
			$Doublerent=$row6['Doubles'];
		    $Triplerent=$row6['Triple'];
			$Quartertriplerent=$row6['Quadruple'];
			if($row6['PubTarriff'] == 1){
			 $ins3="Insert into temp_trans_roomdet_det_rent(Rentdate,roomid,singlerent,Doublerent,Triplerent,Quartertriplerent,checkinrenttype,actsinglerent,actdoublerent,acttriplerent,actquartertriplerent,extraadultcharges,userid,GrcNo,hotelid)
		 values('".$Indate."','".$Roomid."','".$singlerent."','".$Doublerent."','".$Triplerent."','".$Quartertriplerent."','I','".$singlerent."','".$Doublerent."','".$Triplerent."','".$Quartertriplerent."','".$row6['Extrabedamount']."','".User_id."',dbo.GrcNo(),'".Hotel_Id."')";
		 $result = $this->db->query($ins3);
			}
		}
		 $Indate = date ("Y/m/d", strtotime("+1 day", strtotime($Indate)));		  
	    }

		$sql ="select isnull(registrationcard,0) as registrationcardreprint from extraoption";
		$res = $this->db->query($sql);
		foreach($res->result_array() as $row){
			$no = $row['registrationcardreprint'];
		}


?>
<div><input type="hidden" value="<?php echo $no ?>"  id="printenable"></div>
<div id="guesthistory" class="modal">
	  <!-- Modal content -->
	  <div class="modal-content" style="width:60%">
	    <div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle">
	 	<span class="ui-dialog-title">Guest History</span>
		   <span id="span10" class="close">&times;</span>	
         <Br>		   
	   </div>
		    
			<button class="tablink" id="defaultOpen1" onclick="openPage('History', this, 'black')">Analysis</button>
			<button class="tablink" onclick="openPage('display', this, 'black')" >Visits</button>
			<input type="hidden" id="Customerid" value='0'>
           <form id="guestformm" method="post">
			<div id="History" class="tabcontent">
			 <tr>Guest History:</tr>
			 <div class="box">
			 
				<table class="FrmTable" >
				   <tbody>
				    <tr>
				    <td>First stayed Date</td>
				    <td>Last Statyed Date</td>
					<td>No of Visits</td>
				    </tr> 
					<tr>
					<td><input name="firstdate" id="firstdate" readonly type="text" placeholder="First Stayed Date"></td>
					<td><input name="lastdate" id="lastdate" type="text" readonly placeholder="Last Stayed Date "></td>
					<td><input name="Noofvisits" id="Noofvisits" type="text" readonly placeholder="No of Visits"></td>
					</tr>
					<tr>
					 <td>Last stayed Room</td>
					 <td>No of Cancellation</td>
					 <td>Noof no show</td>
					</tr>
					<tr>
					<td><input name="lastRoom" id="lastRoom" type="text" readonly placeholder="Last Stayed Room"></td>
					<td><input name="nofc" id="nofc" type="text"  readonly placeholder="No of Cancellation"></td>
					<td><input name="noshows" id="noshows" type="text" readonly  placeholder="No of No shows"></td>
					</tr>
					<tr>
					 <td>Last stayed Room Rent</td>
					 <tr>
					 <td><input name="rent" id="Rent" type="text" placeholder="00000" readonly ></td>
					 
					</tr>
					</tr>
				   </tbody>
		        </table>
	        </div>
			</div>

			<div id="display" class="tabcontent" >
			 <div class="box">
			    <table class="FrmTable" id="historylist" border="1">
				 <tr>
				  <td>Room No</td>
				  <td>Arr.Date</td>
				  <td>Dep.Date</td>				
				  <td>Pax</td>
				  <td>Bill No</td>
				  <td>Bill Amount</td>
				  <td>Rent</td>
				  <td>Discount</td>
				  <td>DiscPer</td>			
				 </tr>
				 
				</table>
			 </div>
			</div>

			
			<tr>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <!-- <td><input type="submit"   class="btn btn-warning btn-sm"></td> -->
			 <td><a onclick="closeguestform1()"class="btn btn-warning btn-sm">Close</a>	
			 </tr>			 
           </form>   
		 </div>	 
	</div>


	<!--Guest More Details Start-->
	<div id="guestmoredetails" class="modal">
	  <!-- Modal content -->
	  <div class="modal-content" style="width:60%">
	    <div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle">
	 	<span class="ui-dialog-title">Guest Details</span>
		   <span id="span" class="close">&times;</span>	
         <Br>		   
	   </div>
		
	   <button class="tablink" id="defaultOpenn" onclick="openPage('Address', this, 'black')">Address</button>
			<button class="tablink" onclick="openPage('Personal', this, 'black')" >Personal</button>
<button class="tablink" id="passporttab" disabled onclick="openPage('Passport', this, 'black')">Passport</button>
			<!--button class="tablink" onclick="openPage('About', this, 'black')">About</button--->
           <form id="guestform" method="post">
			<div id="Address" class="tabcontent">
			 <tr>Guest details:</tr>
			 <div class="box">
			 
				<table class="FrmTable">
				   <tbody>
				   <input type="hidden" value="" name="gmobile" id="gmobile">
				    <tr>
				    <td>Address1</td>
				    <td>Address2</td>
					<td>Address3</td>
				    </tr> 
					<tr>
					<td><input name="address1" id="address1" type="text" placeholder="Address1"></td>
					<td><input name="address2" id="address2" type="text" placeholder="Address2"></td>
					<td><input name="address3" id="address3" type="text" placeholder="Address3"></td>
					</tr>
					<tr>
					 <td>Pin</td>
					 <td>Nationality</td>
					 <td>Phone</td>
					</tr>
					<tr>
					 <td><input name="pincode" id="pincode" type="text" placeholder="00000" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
					 <input type="hidden" name="Nationid" id="Nationid">
					 <td><input name="Nationality" id="Nationality" placeholder="Nationality" type="text" value="0"></td>
					 <td><input name="phone" id="phone" type="text" placeholder="04222649" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
					</tr>
				   </tbody>
		        </table>
			  </div>
			  <tr>Work details:</tr>
			   <div class="box">
			    <table class="FrmTable">
				   <tbody>
				   <tr>
				    <td>Work Address1</td>
				    <td>Work Address2</td>
					<td>Work Address3</td>
				    </tr>
					<tr>
					<td><input name="workaddress1" id="workaddress1" type="text" placeholder="Address1"></td>
					<td><input name="workaddress2" id="workaddress2" type="text" placeholder="Address2"></td>
					<td><input name="workaddress3" id="workaddress3" type="text" placeholder="Address3"></td>
					</tr>
					<tr>
					 <td>Pincode</td>
					 <td>City</td>
					 <td>Phone</td>
					</tr>
					<tr>
					 <td><input name="workpincode" id="workpincode" type="text" placeholder="00000" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
					 <td><input name="workcity" id="workcity" placeholder="City" type="text"></td>
					 <td><input name="workphone" id="workphone" type="text" placeholder="04222649" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"></td>
					</tr>
				   </tbody>
				</table>
			   </div>
			</div>

			<div id="Personal" class="tabcontent" >
			 <div class="box">
			    <table class="FrmTable">
				 <tr>
				  <td>Gender</td>
				  <td>Profession</td>
				  <td>Date of Birth</td>				
				  <td>Anniversary Date</td>	

				 </tr>
				 <tr>
				  <td><select name="gender" id="gender"><option>Male</option><option>Female</option></select></td>
				  <td><input id="profession" name="profession" placeholder="Profession" type="text"></td>
				  <td><input id="dob" name="dob" type="date"></td>
				  <td><input id="anniversarydate" name="anniversarydate" type="date"></td>
				 </tr>
				  <tr>
				   <td>Likes</td>
				   <td>Dislike</td>
				   <td>Preferred Room</td>
				   <td>Hotel comments</td>
				  </tr>
				  <tr>
				   <td><textarea rows="4" name="likes" id="likes" placeholder="Guest Likes"> </textarea></td>
				   <td><textarea rows="4" name="dislikes" id="dislikes" placeholder="Guest Dislikes"> </textarea></td>
				   <td><input type="text" name="preferredroom" id="preferredroom"></td>
				   <td><textarea rows="4" name="hotelcommends" placeholder="Hotel comments" id="hotelcommends"> </textarea></td>
				  </tr>	
				  				  <tr>
					<td>ID Proof</td>
					<td>Valid Proof No</td>
				  </tr>		
				  <tr>
					<td>
						<select name="Id_Documenttype" id="Id_Documenttype">
							<option value="0" disabled selected>Select IDProof</option>
							<?php 
								$sql = "select * from mas_idproof where isnull(active,0)<>1";
								$resid = $this->db->query($sql);
								foreach($resid->result_array() as $rowid){
									echo '<option value="'.$rowid['proofid'].'">'.$rowid['idname'].'</option>';
								}
							?>
						</select>
					</td>
					<td>
						<input type="text" name="Id_Documentno" id="Id_Documentno"  readonly>
					</td>
				  </tr> 			  
				</table>
			 </div>
			</div>

			<div id="Passport" class="tabcontent">
			  <div class="box">
			    <table class="FrmTable">
				<tr>
				 <td>Passport.No</td>
				 <td>Date of Issue</td>
				 <td>Issue Place</td>
				 <td>Expiry Date</td>
				</tr>
				<tr>
				 <td><input type="Text" name="passportno" id="passportno" placeholder="Passport No"></td>
				 <td><input type="date" name="dateofissue" id="dateofissue"></td>
				 <td><input type="text" name="issueplace" id="issueplace" placeholder="Issue Place" ></td>
				 <td><input type="date" name="expirydate" id="expirydate"></td>
				</tr>
				<tr>
				 <td>VISA.No</td>
				 <td>Date of Issue</td>
				 <td>Issue Place</td>
				 <td>Expiry Date</td>
				</tr>
				<tr>
				 <td><input type="Text" name="visano" id="visano" placeholder="visa No"></td>
				 <td><input type="date" name="visadateofissue" id="visadateofissue"></td>
				 <td><input type="text" name="visaissueplace" id="visaissueplace" placeholder="Issue Place" ></td>
				 <td><input type="date" name="visaexpirydate" id="visaexpirydate"></td>
				</tr>
				<tr>
				 <td>Document Type</td>
				 <td>Document No</td>
				 <td></td>
				 <td></td>
				</tr>
				<tr>
				 <td><input type="text" name="documenttype" id="documenttype" placeholder="Ex: Vote Id.."></td>
				 <td><input type="Text" name="documentno" id="documentno" placeholder="Ex:12AS5656DD.."></td>
				 <td></td>
				 <td></td>
				</tr>
				</table>
			  </div>
			</div>
			<tr>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td><input type="submit"   class="btn btn-warning btn-sm"></td>
			 <td><a onclick="closeguestform()"class="btn btn-warning btn-sm">Cancel</a>	
			 </tr>			 
           </form>   
		 </div>	 
	</div>
	<form id="tariffsubmit" > 
	<div id="tariff" class="modal">
	 <div class="modal-content" style="width:60%">
	   <div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle" style="background-color:white !important;">
	 	<span class="ui-dialog-title "style="color:#04c;">Checkin Room Rent Details</span>
		   <span id="span1" style="color:#04c;" class="close">&times;</span>		
	   </div>
		
	   <table class="table table-borderless table-hover" id="rentdetails" >
		 <thead>
		  <tr style=" width:100%; border-top: 2px solid #333 !important; border-bottom:2px solid #333">
		   <td>S.No</td>
		   <td>Date</td>
		   <td>Single</td>
		   <td>Double</td>
		   <td>Triple</td>
		   <td>Quarter Triple</td>
		   <td>Extra bed</td>
		  </tr>
		 </thead>
		 <tbody>
		 <?php $i=1;
		 $rent="select * from temp_trans_roomdet_det_rent where Roomid='".$Roomid."' order by Rentdate";
		 $rentres=$this->db->query($rent);
		 foreach ($rentres->result_array() as $rentrow)
		 { 
		    if($i==1)
			{ $firstid= $rentrow['roomrentid']; ?>
		      <input type="hidden" name="firstid" id="firstid" value="<?php echo $firstid; ?>">
		<?php
			}
		 ?>	   
		  <tr  style="width:100%">
		   <td  style="width:10%; padding:2px;"><?php echo $i; ?></td>
		   <td align="left" style="width:15%;padding:2px;"><input type="hidden" name="roomrentid" value="<?php echo $rentrow['roomrentid']; ?>"><?php echo date('d/m/Y', strtotime($rentrow['Rentdate']));?></td>
		   <td style="width:15%; padding:2px; "><input style="border:hidden;  width:100px" name="<?php echo $rentrow['roomrentid']; ?>single" id="<?php echo $rentrow['roomrentid']; ?>single" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['singlerent']; ?>"></td>
		   <td style="width:15%; padding:2px;"><input  style="border:hidden;  width:100px"name="<?php echo $rentrow['roomrentid']; ?>double" id="<?php echo $rentrow['roomrentid']; ?>double" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['Doublerent']; ?>"></td>
		   <td style="width:15%; padding:2px;"><input style="border:hidden;width:100px" name="<?php echo $rentrow['roomrentid']; ?>triple" id="<?php echo $rentrow['roomrentid']; ?>triple" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['Triplerent']; ?>"></td>
		   <td style="width:15%; padding:2px;"><input style="border:hidden;  width:100px" name="<?php echo $rentrow['roomrentid']; ?>quartertriple" id="<?php echo $rentrow['roomrentid']; ?>quartertriple" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['Quartertriplerent']; ?>"></td>
		   <td style="width:10%; padding:2px;"><input style="border:hidden;  width:100px" name="<?php echo $rentrow['roomrentid']; ?>extrabed" id="<?php echo $rentrow['roomrentid']; ?>extrabed" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="width:100%;text-align:right" type="text" value="<?php echo $rentrow['extraadultcharges']; ?>"></td>
		  </tr>
		
		 <?php $i++;  $lastid=$rentrow['roomrentid'];} ?>
		   <tr style="border-top:2px solid #333;">
		    <td style="text-align: center;padding:2px;"><a onclick="Replicate(<?php echo $lastid; ?>,<?php echo $firstid;  ?>)"class="btn btn-warning btn-sm">Replicate</a></td>
			<td></td>
			<td></td>			
			<td></td>
			<td></td>
			<td style="text-align: center;"><input type="submit"   class="btn btn-warning btn-sm"></td>		
			<td style="text-align: center;"><a onclick="closetariff()"class="btn btn-warning btn-sm">Cancel</a>	</td>			
		   </tr>
		 </tbody>
		</table>
	</div>
	</div>
	</form>
	
 <!--Guest More Details Start--> 
 <form method="POST" enctype="multipart/form-data" id="formcheckin">
	<table class="FrmTable T-6" style="margin-top:5px">
  <tr>
    <td><strong>In&nbsp;Date</strong></td>
    <td ><input type="date" name="" id="Indate" style="background-color:white;" value="<?php echo $_POST['Fdat']; ?>"  min="<?php echo date('Y-m-d');?>"  max="<?php echo date('Y-m-d');?>" onChange="outdate();" class="m-ctrl"  style="background-color:#FFF59B;width:100px"  ></td>
    <td>Hr</td>
    <td><select name="FHr" id="FHr" >
    <option>-</option>
    <?php
	for($i=0;$i<24;$i++)
	{
        echo '<option value="'.$i.'" >'.$i.'</option>';
	}
		?>
      </select></td>
    <td>Min</td>
    <td><select name="FMi" id="FMi" ><option>-</option>
    <?php
	for($i=0;$i<60;$i++)
	{
        echo '<option value="'.$i.'" >'.$i.'</option>';
	}
		?>
      </select> </td>
    <td><strong>Out&nbsp;Date</strong></td>
	<td><input type="date" name="" id="outdate" style="background-color:white;" value="<?php echo $_POST['Tdat']; ?>"  style="background-color:#FFF59B;width:100px" onChange="Niight();" class="m-ctrl"></td>	  
	<td>Hr</td>
    <td><select name="THr" id="THr" ><option>-</option>
    <?php
	for($i=0;$i<24;$i++)
	{
        echo '<option value="'.$i.'" >'.$i.'</option>';
	}
		?>
      </select></td>
	  <td>Min</td>
    <td><select name="TMi" id="TMi" ><option>-</option>
    <?php
	for($i=0;$i<60;$i++)
	{
        echo '<option value="'.$i.'" >'.$i.'</option>';
	}
		?>
      </select></td>
	  
	  <td>R.Nights</td>
	  <?php
	$d1 =$_POST['Fdat'];
	$d1 = str_replace('/','-',$d1);
	$date1= date('Y-m-d' , strtotime($d1));
	
	$d2 =$_POST['Tdat'];
	$d2 = str_replace('/','-',$d2);
	$date2= date('Y-m-d' , strtotime($d2));
	function dateDiff($date1, $date2) 
	{
	  $date1_ts = strtotime($date1);
	  $date2_ts = strtotime($date2);
	  $diff = $date2_ts - $date1_ts;
	  return round($diff / 86400);
	}
	$dateDiff= dateDiff($date1, $date2);
	if($dateDiff==0)
	{ $dateDiff ='1';}
	
	 ?>
	  <td><input type="text" name="rnight" value="<?php echo $dateDiff; ?>" 
	  style="background-color:#FFF59B;width:50px" num=1 class="m-ctrl" id="nig" onkeyup="updateDate()"></td>
    <!---td rowspan="2" align="right">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:25px;border:1px solid #E3E3E3;" >
  <tbody>
    <tr>
      <td><strong>Rent</strong></td>
      <td align="right" class="Rent" >2000.00</td>
      <input type="hidden" name="Rent" id="Rent" >
       <input type="hidden" name="Tax" id="Rent" >
        <input type="hidden" name="Total" id="Rent" >
    </tr>
    <tr>
      <td><strong>Tax</strong></td>
      <td align="right" class="Tax"  >160.00</td>
    </tr>
    <tr style="color:red !important">
      <td><strong>Total</strong></td>
      <td style="" align="right"><strong class="Total" >2160.00</strong></td>
    </tr>
  </tbody>
</table>

    
    </td-->
  </tr>
  <tr>
    
    
  </tr>
</table>
<legend style="font-size:13px" ><strong>Room Details : -</strong></legend>
<table class="FrmTable" style="margin-top:-15px">
  <tr>
    <td>Room No</td>
    <td>Rate Type</td>    
    <td>Male</td>
	<td>Female</td>
    <td>Child</td>	
	<td>Pax</td>
	<td></td>
  </tr>
  <tr>
   <td><select class="m-ctrl" >
    <?php
    
	foreach($data as  $row)
	{
		echo '<option>'.$row->RoomNo.'</option>';
	}
	
	?>
      </select></td>
    <td>
		<select class="m-ctrl" name="RateCode" id="RateCode" onchange="getratetyperoomrent(this.value);"><?php
	foreach($data as  $row)
	{
		echo '<option value="'.$row->PlanType_Id.'" Single="'.$row->Single.'" Doubles="'.$row->Doubles.'" Triple="'.$row->Triple.'" Quadruple="'.$row->Quadruple.'"    >'.$row->RateCode.'</option>';
	}
	
	?>
      </select></td>
   
    <td><select onchange='Adult()' name="male" id="male" class="m-ctrl">
	    <option selected value='0'>0</option>
 	    <?php
		$pax=$Adults;
		$extrabed=$Extrabedcount;
		$totalpax=$pax+$extrabed;
		for($i=1; $i<=$totalpax;$i++)
		{
			echo '<option values='.$i.'>'.$i.'</option>';
		}
		
		?>
	 </select></td>
	 <td>
	 <?php 
	   $pax=$Adults;
		$extrabed=$Extrabedcount;
		$totalpax=$pax+$extrabed;
	 ?>
	 <input type='hidden' name='totalocc' id='totalocc' value="<?php echo $totalpax; ?>">
	 <select onchange='Adult()' name="female" id="female" class="m-ctrl">
	     <option selected value='0'>0</option>
		 <?php
		for($i=1; $i<=$totalpax;$i++)
		{
			echo '<option  values='.$i.'>'.$i.'</option>';
		}
		
		?>
	 </select></td>
	 <td><select class="m-ctrl" id="Child" name="Child" >
     <?php
    
	for($i=0; $i<=3;$i++)
	{
		echo '<option>'.$i.'</option>';
	}
	
	?>
      </select></td>
	 <td><input style="width:80px" readonly type='text' value='' class="m-ctrl" id="Adults" name="Adults" >  </td>
	 <td><a class="btn btn-warning btn-sm" id="tarifpop" >Dynamic Tariff</a></td>
  </tr>
</table>
<legend style="font-size:13px" ><strong>Guest Details : -</strong></legend>
<table class="FrmTable" style="margin-top:-15px" >
	<tr>
	<td>Mobile</td>
	<td>Title</td>
    <td>First Name</td>
    <td>Middle Name</td>
    <td>Last Name</td>
	<td></td>
	
	</tr>
  <tr>
    <td><input name="Mobile" id="Mobile" placeholder="Mobile"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="m-ctrl" ></td>
    <td align="left"><select id="Title" name="Title" >
	    <?php  $Res=$this->Myclass->Title();
				foreach($Res as $row)
				{ 
				 echo '<option value="'.$row['Titleid'].'"	 >'.$row['Title'].'</option>';
				}
		?>
        
      </select></td>
    <td  ><input name="Firstname" id="Firstname" placeholder="First Name"  class="m-ctrl" ></td>
    <td><input name="Middlename" id="Middlename" placeholder="Middle Name"  class="m-ctrl" ></td>
	<td><input name="Lastname" id="Lastname" placeholder="Last Name"  class="m-ctrl" ></td>
	<td><a class="btn btn-warning btn-sm" id="guestpop" >G</a></td>
	<td><a class="btn btn-warning btn-sm" id="guestdetails" >H</a></td>
	
  </tr>
</table>
<table class="FrmTable" >
  <tr>  
 <td>Address 1</td>
  <td>Address 2</td>
  <td>City</td>
  <td>Email</td>
  </tr>

  <tr>
   <td><input name="Address1" id="Address1" type="text" placeholder="Address1" class="m-ctrl " value ="" ></td>
  <td><input name="Address2" id="Address2" type="text" placeholder="Address2" class="m-ctrl " value=""></td>
  <td><input type="text" placeholder="City" id="City1" name="City" class="m-ctrl " /></td>
	<td><input name="Email_ID" id="Email_ID" placeholder="Email"  class="m-ctrl" ></td>

	<input type="hidden" id="State_id" name="State_id" value="">
	<input type="hidden" id="City_id" name="City_id" value="">
	<input type="hidden" id="Country_id" name="Country_id" value="">
	
	</tr>
	  <tr>
  <td>Company</td>
  <td>ID Proof Type</td>
  <td>ID Proof No</td>
  </tr>
	<tr>
	<td>
		<input name="Company" id="Company" placeholder="Company"  class="m-ctrl" ></td>
	<input type="hidden" id="Company_Id" name="Company_Id" value="">

	<td>
	<select name="Id_Documenttype" id="Id_Documenttype" class="m-ctrl">
	<option value="0" disabled selected>Select ID Proof</option>
	<?php 
	$sql = "select * from mas_idproof where isnull(active,0)<>1";
	$resid = $this->db->query($sql);
	foreach($resid->result_array() as $rowid){
	echo '<option value="'.$rowid['proofid'].'">'.$rowid['idname'].'</option>';
						}
							?>
						</select>
					</td>
	<td><input type="text" name="Id_Documentno" id="Id_Documentno" class="m-ctrl"></td>
	<td>Billing Address :<input type="hidden" value="0" name="guestaddress" id="guestaddress"><input type="checkbox" checked value="1" name="guestaddress" id="guestaddress"> Guest <input type="hidden" value="0" name="companyaddress" id="companyaddress"><input name="companyaddress" value="1" id="companyaddress" type="checkbox"> Company</td>

	</tr>
	<table class="FrmTable" >
	<tr>
	<td>Travel Agent</td>
	<td>Booking ID</td>
	<td>Disc.Per</td>
	<td>Disc.Amt</td>
	<td>Plan</td>
	<td>Attach</td>
	</tr>
    <tr>
	
	<td><input name="travelagent" id="travelagent" placeholder="Travel Agent"  class="m-ctrl" ><input id="travelagent_Id" name="travelagent_Id" type="hidden" value=""></td>
	<td><input name="bookingid" readonly id="bookingid" placeholder="Booking ID"  class="m-ctrl" ></td>
	<?php
		  
		$qury = "select * from usertable where User_id='".User_id."' ";
		$op = $this->db->query($qury);
		foreach($op -> result_array() as $row){
			$percent = $row['disper'];
			$disamount = $row['disAmount'];
	?>
	<td>
		<input type="hidden" id="DISP" value="<?php echo $percent;  ?>">
		<input onchange="discper()" name="discper" id="discper" value="0" placeholder="Disc.Per"  class="m-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" ></td>

	<td>
	    <input type="hidden" id="DISA" value="<?php echo $disamount;  ?>">
		<input onchange="discamt()" name="discamt" id="discamt" value="00.00" placeholder="Disc.Amt"  class="m-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" ></td>
	<?php } ?>
	<td><select name="foodplan" id="foodplan"><option value="0">Select Plan</option>
	<?php
	$qry="select * from Mas_FoodPlan";
	$res=$this->db->query($qry);
	foreach ($res->result_array() as $row)
	{
	 echo '<option value="'.$row['FoodPlan_Id'].'"	 >'.$row['FoodPlan'].'</option>';
	}
	?>
	</select></td>
	<td><input type="file" id="fileToUpload"  name="fileToUpload[]" multiple="multiple" >
	<!-- <span style="color:red">*jpeg, *png,*gif</span> -->
</td>
	</tr>
	<input type="hidden" name="Roomid" id="" value="<?php echo $_POST['roomid']; ?>">
</table>


<hr  >
<table class="FrmTable" style="margin-top:-25px" >
  <tr>
    
    <td style="padding-left:30px;"><a id="Reserve" onclick="Reserve()"  name="Reserve" style="display:none;float:left;" class="btn btn-warning btn-sm" ><i class="fa fa-book" aria-hidden="true"></i> Reserve </a></td>
    
	<td>&nbsp;&nbsp;&nbsp;&nbsp;  </td>
    <td><!--a class="btn btn-warning btn-sm" ><i class="fa fa-book" aria-hidden="true"></i> Temp Reserve </a---></td>
	<td  style="padding-right:30px;">
	<a id="CheckIn" onclick="CheckIn()"  name="CheckIn" style="display:inline-block;float:right;cursor:pointer" class="btn btn-warning btn-sm" >
		<i class="fa fa-calendar-o" aria-hidden="true"></i> Check-In <img id="loaderimg" src="../../assets/formloader.gif" width="20px" style="display:none;"/>
	</a>
   </td>
  </tr>
</table>

</form>

<script>

var d = new Date(); // for now
var h =d.getHours(); // => 9
var s =d.getMinutes(); // =>  30
document.getElementById("FHr").disabled = true;
document.getElementById("FMi").disabled = true;
$('#FHr').val(h);
$('#FMi').val(s);
$('#THr').val(h);
$('#TMi').val(s);
	var Indate =document.getElementById("Indate").value;
    var date = Indate.substring(0, 2);
    var month = Indate.substring(3, 5);
    var year = Indate.substring(6, 10); 
    var InDate = new Date(year, month - 1, date);
	var currentdate = new Date();

	if(currentdate <= InDate)
    {
	     document.getElementById("FHr").disabled = false;
		 document.getElementById("FMi").disabled = false;	
	}
if(currentdate <= InDate)
   {
	document.getElementById("CheckIn").style.display = "none";
   }

   <?php 
    $today = date('Y-m-d');
   ?>
function outdate() {
	var ind = document.getElementById("Indate").value;
	var today = new Date(ind); // Or Date.today()
    var tomorrow = today.setDate(today.getDate() + 1);
	var newdate = new Date(tomorrow).toISOString().slice(0,10);
    document.getElementById("outdate").min = newdate;
	document.getElementById("outdate").value = newdate;
	var date1 = new Date(ind);
	var date2 = new Date(newdate);
	var diff= date2.getTime() - date1.getTime();
	var daydiff = diff / (1000 * 60 * 60 * 24); 
	
	document.getElementById("nig").value = daydiff;

    var currentDate = new Date();

	// if(today > currentDate){

	// 	document.getElementById('CheckIn').style.display = "none";
		
	// }
	// else{
	// 	document.getElementById('CheckIn').style.display = "inline-block";
		
	// }
    
	
}
function Niight(){
	var d1 =document.getElementById("outdate").value;

	var d2= document.getElementById("Indate").value;
	var date1 = new Date(d1);
	var date2 = new Date(d2);
	var diff= date1.getTime() - date2.getTime();
	var daydiff = diff / (1000 * 60 * 60 * 24);   
	document.getElementById("nig").value = daydiff;

	var toodate = document.getElementById("outdate").value;
	var planidd = document.getElementById("RateCode").value 
	
	$.ajax({
            type: 'get',
            url: "<?php echo scs_index ?>Transaction/getratetyperoomrentt?planid="+planidd+"&Roomid=<?php echo $Roomid; ?>&fromdate=<?php echo $fromdate;?>&todate="+toodate,
            success: function (html) {
              $("#rentdetails").html(html);
			   }			
          });
}

function updateDate() {
	var nights = parseInt(document.getElementById("nig").value, 10);
    var inDate = new Date(document.getElementById("Indate").value);

    if (!isNaN(nights)) {
        inDate.setDate(inDate.getDate() + nights);
        var outDate = inDate.toISOString().split('T')[0]; // Format YYYY-MM-DD
        document.getElementById("outdate").value = outDate;
    }
}
// <?php
//     $F_date = date('Y-m-01', strtotime( $a_date)); // month first date
//     $l_date = date("Y-m-t", strtotime($a_date)); // month last date
//     $aa_date =date_create($fdate);
//     $l_date=date_create($tdate);
//     $diff=date_diff($aa_date ,$l_date );
//     $difference = $diff->format("%a");
// ?>

$(document).ready(function(e) {
   Single=$('#RateType_Id option:selected').attr('Single');
   Doubles=$('#RateType_Id option:selected').attr('Doubles');
   Triple=$('#RateType_Id option:selected').attr('Triple');
   Quadruple=$('#RateType_Id option:selected').attr('Quadruple');

});
 function Replicate(l,f)
 {  var fiestamt=f;
    var text="";
	while (f <= l) {
		var  singleamt= document.getElementById(fiestamt+"single").value;
		var  doubleamt= document.getElementById(fiestamt+"double").value;
		var  tripleamt= document.getElementById(fiestamt+"triple").value;
		var  quartertripleamt= document.getElementById(fiestamt+"quartertriple").value;
		var  extrabedamt= document.getElementById(fiestamt+"extrabed").value;
		 $("#"+f+"single").val(singleamt);	
		 $("#"+f+"double").val(doubleamt);
		 $("#"+f+"triple").val(tripleamt);	
		 $("#"+f+"quartertriple").val(quartertripleamt);	
		 $("#"+f+"extrabed").val(extrabedamt);	
		  f++;
		} 
 }
 function updateOutDate() {
    var nights = parseInt(document.getElementById("nig").value, 10);
    var inDate = new Date(document.getElementById("Indate").value);

    if (!isNaN(nights)) {
        inDate.setDate(inDate.getDate() + nights);
        var outDate = inDate.toISOString().split('T')[0]; // Format YYYY-MM-DD
        document.getElementById("outdate").value = outDate;
    }
}

 var nights = parseInt(document.getElementById("nig").value, 10);
    var inDate = new Date(document.getElementById("Indate").value);

    if (!isNaN(nights)) {
        inDate.setDate(inDate.getDate() + nights);
        var outDate = inDate.toISOString().split('T')[0]; // Format YYYY-MM-DD
        document.getElementById("outdate").value = outDate;

        // Optionally, re-trigger calculation and AJAX
        Niight();
    }
	
$("#Mobile").autocomplete({


         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/Customer",
                 dataType: "json",
                 data: {
                     term: request.term
                 },
                 success: function(data) {
                     response(data);
                 }
             });
         },
         minLength: 2,
         select: function(event, ui) {

		console.log(ui)
			    event.preventDefault();  
			 $("#Lastname").val(ui.item.Lastname);			  
			 $("#Mobile").val(ui.item.Mobile);
			 $("#Title").val(ui.item.Title);
			 $("#Email_ID").val(ui.item.Email_ID);
			 $("#Firstname").val(ui.item.Firstname);
			 $("#Country_id").val(ui.item.Countryid);			  
			 $("#State_id").val(ui.item.Stateid);
			 $("#City_id").val(ui.item.Cityid);
			 $("#City1").val(ui.item.City);
			 $("#workcity").val(ui.item.City);
			 $("#Middlename").val(ui.item.Middlename);
			 $("#Address1").val(ui.item.HomeAddress1);
			 $("#Address2").val(ui.item.HomeAddress2);
			 $("#address3").val(ui.item.HomeAddress3);
			 $("#pincode").val(ui.item.Homepincode);
			 $("#phone").val(ui.item.ResidentialPhone);
			 $("#workaddress1").val(ui.item.WorkAddress1);
			 $("#workaddress2").val(ui.item.WorkAddress2);
			 $("#workaddress3").val(ui.item.WorkAddress3);
			 $("#workpincode").val(ui.item.Workpincode);
			 $("#workphone").val(ui.item.WorPhone);
			 $("#profession").val(ui.item.Profession);
			// $("#dob").val(ui.item.Birthdate.split(' ')[0]);
			 //$("#anniversarydate").val(ui.item.Weddingdate.split(' ')[0]);
			 $("#likes").val(ui.item.Likes);
			 $("#dislikes").val(ui.item.Dislikes);
			 $("#preferredroom").val(ui.item.Preffered_Room);
			 $("#hotelcommends").val(ui.item.Hotel_Commends);
			 $("#passportno").val(ui.item.passportno);
			 //$("#dateofissue").val(ui.item.Passport_issuedate.split(' ')[0]);
			 $("#issueplace").val(ui.item.Passport_issueplace);
			 //$("#expirydate").val(ui.item.Passport_Expirydate.split(' ')[0]);
			 $("#visano").val(ui.item.VISA_No);
			 //$("#visadateofissue").val(ui.item.VISA_Issuedate.split(' ')[0]);
			 $("#visaissueplace").val(ui.item.VISA_Issueplace);
			 //$("#visaexpirydate").val(ui.item.VISA_Expirydate.split(' ')[0]);
			 $("#Id_Documenttype").val(ui.item.Id_Documenttype);
			 $("#Id_Documentno").val(ui.item.Id_Documentno);			  
			 $("#Nationality").val(ui.item.Nationality);
			 $("#Company").val(ui.item.Company);
			 $("#Customerid").val(ui.item.Customerid);
			
         }
     });
$("#Firstname").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/CustomerName",
                 dataType: "json",
                 data: {
                     term: request.term
                 },
                 success: function(data) {
                     response(data);
                 }
             });
         },
         minLength: 2,
         select: function(event, ui) {			
			    event.preventDefault();  			
			 $("#Lastname").val(ui.item.Lastname);			  
			 $("#Mobile").val(ui.item.Mobile);
			 $("#Email_ID").val(ui.item.Email_ID);
			 $("#Firstname").val(ui.item.Firstname);
			 $("#Country_id").val(ui.item.Countryid);			  
			 $("#State_id").val(ui.item.Stateid);
			 $("#City_id").val(ui.item.Cityid);
			 $("#City1").val(ui.item.City);
			 $("#Middlename").val(ui.item.Middlename);
			 $("#address1").val(ui.item.HomeAddress1);
			 $("#address2").val(ui.item.HomeAddress2);
			 $("#address3").val(ui.item.HomeAddress3);
			 $("#pincode").val(ui.item.Homepincode);
			 $("#phone").val(ui.item.ResidentialPhone);
			 $("#workaddress1").val(ui.item.WorkAddress1);
			 $("#workaddress2").val(ui.item.WorkAddress2);
			 $("#workaddress3").val(ui.item.WorkAddress3);
			 $("#workpincode").val(ui.item.Workpincode);
			 $("#workphone").val(ui.item.WorPhone);
			 $("#profession").val(ui.item.Profession);
			 $("#dob").val(ui.item.Birthdate);
			 $("#anniversarydate").val(ui.item.Weddingdate);
			 $("#likes").val(ui.item.Likes);
			 $("#dislikes").val(ui.item.Dislikes);
			 $("#preferredroom").val(ui.item.Preffered_Room);
			 $("#hotelcommends").val(ui.item.Hotel_Commends);
			 $("#passportno").val(ui.item.passportno);
			 $("#dateofissue").val(ui.item.Passport_issuedate);
			 $("#issueplace").val(ui.item.Passport_issueplace);
			 $("#expirydate").val(ui.item.Passport_Expirydate);
			 $("#visano").val(ui.item.VISA_No);
			 $("#visadateofissue").val(ui.item.VISA_Issuedate);
			 $("#visaissueplace").val(ui.item.VISA_Issueplace);
			 $("#visaexpirydate").val(ui.item.VISA_Expirydate);
			 $("#documenttype").val(ui.item.Id_Documenttype);
			 $("#documentno").val(ui.item.Id_Documentno);
			 $("#Nationid").val(ui.item.Nationid);			  
			 $("#Nationality").val(ui.item.Nationality);
			 $("#Company").val(ui.item.Company);
			 $("#Customerid").val(ui.item.Customerid);	
			
         }
     });
$("#travelagent").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/Travel_Agent",
                 dataType: "json",
                 data: {
                     term: request.term
                 },
                 success: function(data) {
                     response(data);
                 }
             });
         },
         minLength: 2,
         select: function(event, ui) {
			    event.preventDefault();  
			 $("#travelagent").val(ui.item.Company);			  
			 $("#travelagent_Id").val(ui.item.Company_Id);
			 $('#bookingid').attr('readonly', false);	
			 $("#Company").val('');	
			 $("#Company_Id").val('');			 
         } 
     });
	 
$("#Company").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/Company",
                 dataType: "json",
                 data: {
                     term: request.term
                 },
                 success: function(data) {
                     response(data);
                 }
             });
         },
         minLength: 2,
         select: function(event, ui) {
			    event.preventDefault();  
			 $("#Company").val(ui.item.Company);			  
			 $("#Company_Id").val(ui.item.Company_Id);
			 $("#travelagent").val('');	
			 $("#travelagent_Id").val('');
			 $("#bookingid").val('');
			$('#bookingid').attr('readonly', true);			 
						
         }
     }); 
$("#City1").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/city",
                 dataType: "json",
                 data: {
                     term: request.term
                 },
                 success: function(data) {
                     response(data);
                 }
             });
         },
         minLength: 2,
         select: function(event, ui) {
			    event.preventDefault();  
			 $("#Country_id").val(ui.item.Country_Id);			  
			 $("#State_id").val(ui.item.State_id);
			 $("#City_id").val(ui.item.Cityid);
			 $("#City1").val(ui.item.City);
			
         }
     });
	$("#Nationality").autocomplete({
         source: function(request, response) {
             $.ajax({
                 url: "<?php echo scs_index; ?>Auto_c/Nationality",
                 dataType: "json",
                 data: {
                     term: request.term
                 },
                 success: function(data) {
                     response(data);
                 }
             });
         },
         minLength: 2,
         select: function(event, ui) {
			    event.preventDefault();  
			 $("#Nationid").val(ui.item.Nationid);			  
			 $("#Nationality").val(ui.item.Nationality);
			
			
         }
     });
    
	function Reserve()
	{
	var Roomid=<?php echo $_POST['roomid']; ?>;
	var todate =document.getElementById("outdate").value;
	var Mobile=document.getElementById("Mobile").value;
	var Indate=document.getElementById("Indate").value;
	var Firstname=document.getElementById("Firstname").value;  
	var Lastname=document.getElementById("Lastname").value;
	var Email_ID=document.getElementById("Email_ID").value;
	var Adults=document.getElementById("Adults").value;
	var Child=document.getElementById("Child").value;
	var FHr=document.getElementById("FHr").value;
	var FMi=document.getElementById("FMi").value;
	var THr=document.getElementById("THr").value;
	var TMi=document.getElementById("TMi").value;
	var City_id=document.getElementById("City_id").value;
	var State_id=document.getElementById("State_id").value;
	var Country_id=document.getElementById("Country_id").value;
	var RateCode=document.getElementById("RateCode").value;
	var male=document.getElementById("male").value;
	var female=document.getElementById("female").value;
	var Middlename=document.getElementById("Middlename").value;
	var Company_Id=document.getElementById("Company_Id").value;
	var guestaddress=document.getElementById("guestaddress").value;
	var companyaddress=document.getElementById("companyaddress").value;
	var travelagent_Id=document.getElementById("travelagent_Id").value;
	var bookingid=document.getElementById("bookingid").value;
	var discper=document.getElementById("discper").value;
	var discamt=document.getElementById("discamt").value;
	var foodplan=document.getElementById("foodplan").value;
	var disp = document.getElementById("DISP").value;
	if(Mobile=='')
	{ alert('Mobile Number Empty'); 
		return; }
	if(Adults==0)
	{ alert('No of Pax Empty'); 
		return; }
	if(Firstname =='')
	{ alert('Guest Name Empty'); 
		return; }
	if(City_id =='')
	{ alert('Please Select the City'); 
		return; }
	
    $.ajax({
		     url:"<?php echo scs_index ?>Transaction/Reservesave?Roomid="+Roomid+"&Indate="+Indate+"&todate="+todate+"&Mobile="+Mobile+"&Firstname="+Firstname+"&Lastname="+Lastname+"&RateCode="+RateCode+"&City_id="+City_id+"&State_id="+State_id+"&Country_id="+Country_id+"&Email_ID="+Email_ID+"&Child="+Child+"&Adults="+Adults+"&FHr="+FHr+"&FMi="+FMi+"&THr="+THr+"&TMi="+TMi+"&male="+male+"&female="+female+"&Middlename="+Middlename+"&Company_Id="+Company_Id+"&guestaddress="+guestaddress+"&companyaddress="+companyaddress+"&travelagent_Id="+travelagent_Id+"&bookingid="+bookingid+"&discper="+discper+"&discamt="+discamt+"&foodplan="+foodplan,
         	 type: "POST",
			 dataType: "html",
			 success:function(result){
					$('.ui-dialog-titlebar-close').click();									
						if(result =='Sucess')		
						{
							swal("Success...!", "Reservation Save Successfully...!", "success")
							.then(function() {
								location.reload();	

								});
						}
						else
						{
							swal("Faild...!", "Reservation Save Faild...!", "error")
							.then(function() {
								location.reload();	

								});
						}
					}
			});	
	}
	
	var printenable = document.getElementById('printenable').value;
	function CheckIn()
	{
		if(currentdate <= InDate)
        {
		 alert('Unable to do Check-In at Feture Date Use Reservation Option'); return; 
		}
	var Roomid=<?php echo $_POST['roomid']; ?>;
	var Title =document.getElementById("Title").value;;
	var todate =document.getElementById("outdate").value;;
	var Mobile=document.getElementById("Mobile").value;
	var Indate=document.getElementById("Indate").value;
	var address1=document.getElementById("address1").value;
	var address2=document.getElementById("address2").value;
	var Firstname=document.getElementById("Firstname").value;  
	var Lastname=document.getElementById("Lastname").value;
	var Email_ID=document.getElementById("Email_ID").value;
	var Adults=document.getElementById("Adults").value;
	var Child=document.getElementById("Child").value;
	var FHr=document.getElementById("FHr").value;
	var FMi=document.getElementById("FMi").value;
	var THr=document.getElementById("THr").value;
	var TMi=document.getElementById("TMi").value;
	var City_id=document.getElementById("City_id").value;
	var State_id=document.getElementById("State_id").value;
	var Country_id=document.getElementById("Country_id").value;
	// var Address=document.getElementById("Address1").value;  
	var RateCode=document.getElementById("RateCode").value;
	var male=document.getElementById("male").value;
	var female=document.getElementById("female").value;
	var Middlename=document.getElementById("Middlename").value;
	var Company_Id=document.getElementById("Company_Id").value;
	var guestaddress=document.getElementById("guestaddress").value;
	var companyaddress=document.getElementById("companyaddress").value;
	var travelagent_Id=document.getElementById("travelagent_Id").value;
	var bookingid=document.getElementById("bookingid").value;
	var discper=document.getElementById("discper").value;
	var discamt=document.getElementById("discamt").value;
	var foodplan=document.getElementById("foodplan").value;
 var form = $('#formcheckin')[0];

 var formData = new FormData(form);


 

	if(Mobile=='')
	{ alert('Mobile Number Empty'); 
		return; }
	if(Adults==0)
	{ alert('No of Pax Empty'); 
		return; }
	if(Firstname =='')
	{ alert('Guest Name Empty'); 
		return; }
	if(City_id =='')
	{ alert('Please Select the City'); 
		return; }
	
	
		
		document.getElementById("CheckIn").style.cursor="not-allowed";
        document.getElementById("loaderimg").style.display="inline";

	

    $.ajax({ 
		      url:"<?php echo scs_index ?>Transaction/Checkinsave?Indate="+Indate+"&todate="+todate,
         	 type: "POST",
			  data:  formData,
				contentType: false,
				cache: false,
				processData: false,
			 success:function(result) {
				
					$('.ui-dialog-titlebar-close').click();	
					if(result !=0 && result >0)		
						{
							id=result;
							if(Number(printenable) !=0 && Number(printenable)!=''){
								swal({ 
								title: "Checkin Save Successfully!..",
								text: "Do You want Registration Card?",
								icon: "success",
								buttons: true,
								dangerMode: true,
								})
								.then((willDelete) => {
								if (willDelete) {
									window.location.href ="<?php echo scs_index ?>Transaction/RegistrationCard?roomgrcid="+id;
								}else{
									location.reload();
								}
							})
							}else{
								 swal("Success...!", "Checkin Save Successfully...!", "success").then(()=>{
									location.reload();
								 })
							}
							
						}
						else
						{
							swal("error...!", "Checkin Save Faild...!", "error")
							.then(function() {
								location.reload();	

								});
						}
					}
			});	 
	}
	

	$("#tariffsubmit").on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'get',
            url: "<?php echo scs_index ?>Transaction/temptarriffupdate?Roomid=<?php echo $Roomid; ?>",
            data: $('#tariffsubmit').serialize(),
            success: function (result) {
              alert(result);
			   var modal1 = document.getElementById("tariff");
			   modal1.style.display = "none";
			   }
			
          });
		   //guestmoredetails.style.display = "none";
        });
		
	$("#guestform").on('submit', function (e) {

          e.preventDefault(); 

          $.ajax({
            type: 'get',
            url: "<?php echo scs_index ?>Transaction/tempguestupdate?Roomid=<?php echo $Roomid; ?>",
            data: $('#guestform').serialize(),
            success: function (result) {
              alert(result);
			   modal.style.display = "none";
			   }			
          });
		  /// modal3.style.display = "none";
        });
 function Adult()
 {
	 var female =document.getElementById("female").value;
	 var male =document.getElementById("male").value;
	 var totalocc =document.getElementById("totalocc").value;
	 var adu=(female * 1 )+(male * 1);
	 if(totalocc <  adu)
	 {
		 alert('Pax are greater than Room Max Occupany');
		
		 $("#Adults").val('0');
		  return;
	 }
	$("#Adults").val(adu);	
 }
 function discper()
 {
	$("#discamt").val('0.00');	
	var discper=Number(document.getElementById("discper").value);
	var disp = document.getElementById("DISP").value;
	if(discper > disp || discper <0){
	   $("#discper").val('0');	
	   var msg = `you can give discount up to ${disp}% only`;
	   return swal( msg);
	   
      } 
 }
 function discamt()
 {
	$("#discper").val('0');		
	var discamt=Number(document.getElementById("discamt").value);
	var disa = document.getElementById("DISA").value;
	if(disa < discamt){
	   document.getElementById("discamt").value= "0.00";
	   var msg = `you can give discount up to ${disa} only`;
       return swal( msg);
	   
	   	
      } 

 }
 var modal = document.getElementById("guestmoredetails");
 var btn = document.getElementById("guestpop");
 var modal1 = document.getElementById("tariff");
 var btn2 = document.getElementById("tarifpop");
 var span1 = document.getElementById("span1");
 var spang = document.getElementById("span");
 var span = document.getElementsByClassName("close")[0];
 var btn10 = document.getElementById("guestdetails");
 var modal10 = document.getElementById("guesthistory");
 var span10 = document.getElementById("span10");

 btn.onclick = function() {
	 var Mobile=document.getElementById("Mobile").value;
	if(Mobile==0 || Mobile=='')
	  {
		bool=false;
		alert('Please Enter the Guest Name');
		return false;
	  };
  document.getElementById("gmobile").value =Mobile;
  modal.style.display = "block";
  document.getElementById("defaultOpenn").click();
  }


  btn10.onclick = function() {
	 var Mobile=document.getElementById("Mobile").value;
	 var Customerid = document.getElementById("Customerid").value;
	if(Mobile==0 || Mobile=='')
	  {
		bool=false;
		alert('Please Enter the Guest Name');
		return false;
	  };

	  $.ajax({
		type: 'get',
		url: "<?php echo scs_index ?>Transaction/getingCustomerHistory?id="+Customerid,
		dataType: "json",
		success: function (response) {
			// console.log(response.first)
			$("#firstdate").val(response.first);
			$("#lastdate").val(response.last);
			$("#Noofvisits").val(response.visits);
			$("#lastRoom").val(response.roomno);
			$("#nofc").val(response.cancel);
			$("#noshows").val(response.noshows);
			$("#Rent").val(response.roomrent);
			}			
		}).then(()=>{
			$.ajax({
		type: 'get',
		url: "<?php echo scs_index ?>Transaction/getingCustomerHistoryList?id="+Customerid,
		success: function (html) {
			// console.log(response.first)
			$("#historylist").html(html)
			}			
		});
		});
	
		modal10.style.display = "block";
		document.getElementById("defaultOpen1").click();
  }
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
spang.onclick = function() {
  modal.style.display = "none";
}
span10.onclick = function() {
  modal10.style.display = "none";
}
span1.onclick = function() {
  modal1.style.display = "none";
}

// $("#nig").on('keyup',function(){

// 	var nights = parseInt(document.getElementById("nig").value, 10);
//     var inDate = new Date(document.getElementById("Indate").value);

//     if (!isNaN(nights)) {
//         inDate.setDate(inDate.getDate() + nights);
//         var outDate = inDate.toISOString().split('T')[0]; // Format YYYY-MM-DD
//         document.getElementById("outdate").value = outDate;
//     }
//    });

function closetariff()
{
	modal1.style.display = "none";
}
function closeguestform()
{
	modal.style.display = "none";
}
function closeguestform1()
{
	modal10.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
btn2.onclick = function() {
  modal1.style.display = "block";
}
function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpenn").click();

document.getElementById("defaultOpen1").click();


const getratetyperoomrent = (planid)=>{
	$.ajax({
            type: 'get',
            url: "<?php echo scs_index ?>Transaction/getratetyperoomrentt?planid="+planid+"&Roomid=<?php echo $Roomid; ?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>",
            success: function (html) {
              $("#rentdetails").html(html);
			   }			
          });
}

const nationality = document.getElementById('Nationality');
nationality.addEventListener('change', ()=>{
	let nationalityvalue = nationality.value;
	if(nationalityvalue == 'INDIAN'){
		document.getElementById("passporttab").disabled = true;
	}else{
		document.getElementById("passporttab").disabled = false;
	}
});

const idproofselect =document.getElementById("Id_Documenttype");
const idproofnumber = document.getElementById("Id_Documentno");
idproofselect.addEventListener('change', () =>{
	var selectedOption = idproofselect.options[idproofselect.selectedIndex];
	let selectedValue = selectedOption.textContent;
	idproofnumber.removeAttribute('readonly');
	idproofnumber.removeAttribute('oninput');
	if(selectedValue == 'AADHARCARD'){
		idproofnumber.maxLength = "12";
		 idproofnumber.setAttribute('oninput' , "this.value=this.value.replace(/[^0-9]/g, '');");
	}
	if(selectedValue === 'PAN'){
		idproofnumber.maxLength = "10";
		idproofnumber.setAttribute('oninput' , "this.value=this.value.replace(/[^a-zA-Z0-9]/g, '');");
	}

	if(selectedValue ==='VOTERID'){
		idproofnumber.maxLength = "10";
		idproofnumber.setAttribute('oninput' , "this.value=this.value.replace(/[^a-zA-Z0-9]/g, '');");
	}

	if(selectedValue ==='D-L'){
		idproofnumber.maxLength = "15";
		idproofnumber.setAttribute('oninput' , "this.value=this.value.replace(/[^a-zA-Z0-9]/g, '');");
	}
});

</script>