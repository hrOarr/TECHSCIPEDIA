<?php
//include config
include('../includes/config.php');

//show message from add / edit page
if(isset($_GET['deledi'])){ 

	$stmt = $db->prepare('DELETE FROM editorialscitech WHERE ediID = :ediID') ;
	$stmt->execute(array(':ediID' => $_GET['deledi']));
  
  // delete from editorial subject 
	$stmt = $db->prepare('DELETE FROM editagsscitech WHERE ediID = :ediID');
	$stmt->execute(array(':ediID' => $_GET['deledi']));

	header('Location: index.php?action=deleted');
	exit;
} 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>Delete Editorial | bookpalace</title>

<script language="JavaScript" type="text/javascript">
  function deledi(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'index.php?deledi=' + id;
	  }
  }
  </script>

</head>

<body>

      <?php include('includes/header.php');?> 
            <div class="container" style="margin-top: 20px;">

                <div class="row">
				             <div class="col-lg-12">
                        <div class="card">


                            <div align="center">
                                <h4>Recent Post </h4> <a href='add-editorial(scitech).php'> <button type="button" class="btn btn-dark"><i class="fa fa-sticky-note"></i>  Add Editorial</button></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">


					                <?php 
									//show message from add / edit page
									if(isset($_GET['action'])){ 
										echo '<h3>Editorial is '.$_GET['action'].'.</h3>'; 
									} 
									?>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Categories</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

									  <tbody>
                                    
                                    <?php
										try {

											$stmt = $db->query('SELECT * FROM editorialscitech ORDER BY ediID DESC');
											while($row = $stmt->fetch()){

                                            echo '<tr>';

                                          echo '<td>'.$row['ediID'].'</td>';
                                          echo '<td>'.$row['ediTitle'].'</td>';
                                          echo '<td>';
                                          $stmt1 = $db->query('SELECT * FROM tagsscitech where topID in (select topID from editagsscitech where ediID='. $row['ediID'].')');
										  while($row1 = $stmt1->fetch()){

                                          echo $row1['topTitle'];

                                            }
                                            echo '</td>';
                                          echo '<td>'.date('jS M Y', strtotime($row['topDate'])).'</td>';
                                          ?>
                                                <td><a href="edit-edi(scitech).php?id=<?php echo $row['ediID'];?>"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button></a> | <a href="javascript:deledi('<?php echo $row['ediID'];?>','<?php echo $row['ediTitle'];?>')"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button></a></td>
                                            
                                            <?php 
												echo '</tr>';

											}

										} catch(PDOException $e) {
										    echo $e->getMessage();
										}
									?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              </div>

</body>

</html>