<!DOCTYPE html>
<html>
<head>
<?php include('nav.html'); ?>
<br><br><br><br>
<style>
table {
border-collapse: collapse;
width: 100%;
height: 50px;
color: grey;
font-family: 'Times New Roman';
font-size: 25px;
text-align: left;
}
th {
background-color: grey;
color: gold;
}

tr:nth-child(even) {background-color: #f2f2f2}
label {
    font-size: 40px;
}
.transfer {
    color: grey;
    box-shadow: inset;
    padding-left: 350px;
}
.amount {
    color: goldenrod;
    padding-left: 450px;
}

.btn-primary {
    margin-left: 600px;
    color: indianred;
    background-color: indigo;
    display: block;
    width: 15%;
    border: none;
    background-color: #04AA6D;
    color: white;
    padding: 14px 28px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
}

.btn-primary:hover {
  background-color: #ddd;
  color: black;
}
.form-control {
    font-size: 30px;

}



<?php 
    include 'config.php';
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn,$sql);
?>



<div class="container">
        <br>
        
        <br>
            <div class="row">
                <div class="col">
                    <div class="table-responsive-sm">
                    <table class="table table-hover table-sm table-striped table-condensed table-bordered">
                        <thead>
             
 <html>
<body>
<head>
<style>

label{
    
}
table {
border-collapse: collapse;
width: 100%;
height: 50px;
color: grey;
font-family: 'Times New Roman';
font-size: 25px;
text-align: left;
}
th {
background-color: grey;
color: white;
}

tr:nth-child(even) {background-color: #f2f2f2}
.label {
  color: red ;
  padding: 10px;
  padding-left: 400px;
  font-size: 40px;
  transform: translate(-200%,-50%);
  font-family: Arial;
  
}
.amount{
    color: orange;
    padding: 10px;
    padding-left: 400px;
    font-size: 40px;
    font-family: Arial;
}
.table{
    font-size: 25px;
}
.form-control {
    font-size: 25px;
}
.btn {
  background-color:crimson;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  transform: translate(500%,-20%);
}
.btn-primary {
    color: white;
}

</style>
</head>
    
<br>
<br>

<?php
include('config.php');


if(isset($_POST['submit']))
{
    $from = $_GET['id'];
    $to = $_POST['to'];
    $amount = $_POST['amount'];

    $sql = "SELECT * from users where id='$from'";
    $query = mysqli_query($conn,$sql);
    $sql1 = mysqli_fetch_array($query); // returns array or output of user from which the amount is to be transferred.

    $sql = "SELECT * from users where id='$to'";
    $query = mysqli_query($conn,$sql);
    $sql2 = mysqli_fetch_array($query);

    if (($amount)<0)
   {
        echo '<script type="text/javascript">';
        echo ' alert("Oops! Negative values cannot be transferred")';  // showing an alert box.
        echo '</script>';
    }
    // constraint to check insufficient balance.
    else if($amount > $sql1['balance']) 
    {
        
        echo '<script type="text/javascript">';
        echo ' alert("Bad Luck! Insufficient Balance")';  // showing an alert box.
        echo '</script>';
    }
    
    else if($amount == 0){

         echo "<script type='text/javascript'>";
         echo "alert('Oops! Zero value cannot be transferred')";
         echo "</script>";
     }
    else {
        
                // deducting amount from sender's account
                $newbalance = $sql1['balance'] - $amount;
                $sql = "UPDATE users set balance=$newbalance where id='$from'";
                mysqli_query($conn,$sql);
             

                // adding amount to reciever's account
                $newbalance = $sql2['balance'] + $amount;
                $sql = "UPDATE users set balance=$newbalance where id='$to'";
                mysqli_query($conn,$sql);
                
                $sender = $sql1['name'];
                $receiver = $sql2['name'];
                $sql = "INSERT INTO transaction(`sender`, `receiver`, `balance`) VALUES ('$sender','$receiver','$amount')";
                $query=mysqli_query($conn,$sql);

                if($query){
                     echo "<script> alert('Transaction Successful');
                                     window.location='transactionhistory.php';
                           </script>";
                }
                $newbalance= 0;
                $amount =0;
        }   
}
?>
	<div class="container">
            <?php
                include 'config.php';
                $sid = isset($_GET['id']) ? $_GET['id'] : '';
                $sql = "SELECT * FROM  users WHERE id='$sid'";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo "Error : ".$sql."<br>".mysqli_error($conn);
                }
                $rows=mysqli_fetch_assoc($result);
            ?>
            <form method="post" name="tcredit" class="tabletext" ><br>
        <div>
            <table class="table table-striped table-condensed table-bordered">
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Balance</th>
                </tr>
                <tr>
                    <td class="py-2"><?php echo $rows['id'] ?></td>
                    <td class="py-2"><?php echo $rows['name'] ?></td>
                    <td class="py-2"><?php echo $rows['email'] ?></td>
                    <td class="py-2"><?php echo $rows['balance'] ?></td>
                </tr>
            </table>
        </div>
        <br>
        <span class="label Transfer">Transfer to :</span>
        <select name="to" class="form-control" required>
            <option value="" disabled selected>Choose</option>
            <?php
                include 'config.php';
                $sid = isset($_GET['id']) ? $_GET['id'] : '';
                $sql = "SELECT * FROM users WHERE id!='$sid'";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo "Error ".$sql."<br>".mysqli_error($conn);
                }
                while($rows = mysqli_fetch_assoc($result)) {
            ?>
                <option class="table" value="<?php echo $rows['id'];?>" >
                
                    <?php echo $rows['name'] ;?> (Balance: 
                    <?php echo $rows['balance'] ;?> ) 
               
                </option>

                
            <?php 
                } 
            ?>
            <div>
        </select>
        <br>
        <br>
            <label class="amount">Amount:</label>
            <input type="number" class="form-control" name="amount" required>   
            <br><br>
                <div class="text-center" >
            <button class="btn-primary" name="submit" type="submit" id="btn">Transfer</button>
            </div>
        </form>
    </div>
</body>
</html>