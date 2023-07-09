<?php
session_start();
error_reporting(1);
include('includes/dbconnection.php');

    if(isset($_POST['pay'])){
 
		   $aid=$_SESSION['odmsaid'];
           $fname=$_POST['fullname'];
           $amt=$_POST['amt'];
           $fno=$_POST['fno'];
           $desc=$_POST['servicedes'];
           $ptype=$_POST['ptype'];
		   
		   $type = "(outward Payment - ".$ptype." )"; 

	$sql = "INSERT INTO payments (`ownerid`, `franchiseno`, `amount`, `description`, `paytype`,`status` )VALUES ('$aid','$fno','$amt', '$desc','$type','out')";
       
					  if ($conn->query($sql) === true){
				
					  echo "<script>alert('Payment Record Added Successfully.');  document.location ='payment_history.php';</script>";
					  }
					  else 
					  {
					  echo "<script>alert('Something went wrong. Please try again');</script>";
				    }
	}


?>
 
 <style>
.required{
	color:red;
}
</style>
<div class="card-body">
    <form  method="POST"  name="signup"  >
       <?php 
		 
                                        
			$aid=$_SESSION['odmsaid']; $empty='';
			$result = $conn->query("select name,id,franchiseno from driverinfo where ownerId='$aid' AND franchiseno!=''");                
			$row = $result->fetch_assoc();				
	   
	   ?>
	    <div class="row">
            <div class="form-group col-md-12">
			  <label for="exampleInputName1">Current Drivers Name <span class="required">*</span></label>
                <input type="text" readonly class="form-control" name="fullname"   value="<?php echo $row['name'];?>"   required="required">
            </div>
           
        </div> 
										 
	    <div class="form-group mt-3">
          <label for="exampleInputName1">Amount to pay</label>
           
          <input type="text"  name="amt" class="form-control" id="amt" placeholder="Amount"required>
          <input type="hidden" readonly name="fno" class="form-control" value="<?php echo $row['franchiseno']; ?>"required>
        </div> 
		
		 <div class="form-group mt-3">
          <label for="exampleInputName1">Payment Type</label>
           <select name="ptype" class="form-control" id="type">
			  <option>Choose</option>
			  <option>Transfer</option>
			  <option>Cash</option>
			  <option>Others</option>
		</select>
        </div> 
		
        <div class="form-group">
          <label for="exampleTextarea1">Service Description</label>
		  <?php          ?>
          <textarea class="form-control" name="servicedes" id="servicedes" placeholder="e.g. Monthly Payment (January)" rows="2" style="line-height: 30px;" required></textarea>
        </div>
		
        <div class="form-group">
            <input type="submit" value="Pay Driver" name="pay"   class="btn btn-dark">
        </div>
    </form>
</div>