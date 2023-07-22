<?php
error_reporting(0);
include('includes/checklogin.php');
check_login();
// Code for deleting product from cart
if(isset($_GET['delid']))
{
  $rid=intval($_GET['delid']);
  $sql="delete from owner where id=:rid";
  $query=$dbh->prepare($sql);
  $query->bindParam(':rid',$rid,PDO::PARAM_STR);
  $query->execute();
  echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'manage_service.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<?php @include("includes/head.php");?>
<body>
 
  <div class="container-scroller">
    
    <?php @include("includes/header.php");?>
    
    <div class="container-fluid page-body-wrapper">
      
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="modal-header">
                  <h5 class="modal-title" style="float: left;">List of Submitted Proposal</h5>    
                </div>
                
                 
                
                
                <div id="editData" class="modal fade">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Manage Proposal Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="info_update">
                      
                     </div>
                     <div class="modal-footer ">
                      
                    </div>
                    
                  </div>
                  
                </div>
                
              </div>
              
              <div class="card-body table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                  <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th style="width:20%">Full Name</th>
                      <th style="width:20%">Email Address</th>
                      <th>Phone</th>
					   <th class="text-center">Approval Status</th>
					     <th class="text-center">Payment Status</th>
					   <th class="text-center">Registration Fees.</th>
                      <th class="text-center">Dated</th>
                      <th class="text-center" style="width: 10%;">Action</th>
                    </tr>
                  </thead>
               
					<tbody>
                    <?php
					 $aid=$_SESSION['odmsaid'];
					 
                    $sql="SELECT *from owner";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query->rowCount() > 0)
                    {
                      foreach($results as $row)
                      {    
                        ?>
                        <tr>
                          <td class="text-center"><?php echo htmlentities($cnt);?></td>
                          <td><?php  
						  
							    echo $row->ownername;
								?>
						  </td>
                          <td class="text-left"><?php  echo htmlentities($row->email);?></td>
                          <td class="text-left"><?php  echo htmlentities($row->phone);?></td>
                         
                          <td class="text-center"><?php  
						    if($row->status == 0)
								echo "<span class='badge badge-warning' style='color:black'>Pending </span>";
							else if($row->status == 1)
								echo"<span class='badge badge-success' style='color:black'> Approved</span>";
							else
								echo"<span class='badge badge-danger' style='color:black'> Rejected</span>";
						  ?></td>
						   <td class="text-center"><?php   
						  
						   if($row->pay_status == 0)
								echo "<span class='badge badge-warning' style='color:black'>Pending </span>";
							else  
								echo"<span class='badge badge-success' style='color:black'> Paid</span>";
							 
						  
						  ?></td>
						    <td class="text-left"><?php  
								$f = number_format(($row->fee), 2, '.', ',');
								echo "₦".htmlentities($f);
						  
						  ?></td>
                          <td class="text-center">
                            <span class=""><?php  echo htmlentities($row->regdate);?></span>
                          </td> 
						  
                          <td class="text-center">						
                            <a href="#"  class="btn btn-info rounded edit_data" id="<?php echo  ($row->id); ?>" 
							title="Details"><i class="mdi mdi-pencil-box-outline" aria-hidden="true"> </i>Details</a>
                          </td>
                        </tr>
                        <?php 
                        $cnt=$cnt+1;
                      }
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
      <?php @include("includes/footer.php");?>
      
    </div>
    
  </div>
  
</div>

<?php @include("includes/foot.php");?>
 

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.edit_data',function(){
      var edit_id=$(this).attr('id');
      $.ajax({
        url:"update_proposal.php",
        type:"post",
        data:{edit_id:edit_id},
        success:function(data){
          $("#info_update").html(data);
          $("#editData").modal('show');
        }
      });
    });
  });
</script>
</body>
</html>
