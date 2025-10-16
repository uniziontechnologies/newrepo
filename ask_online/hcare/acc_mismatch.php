<?php

  $conn = new mysqli('192.168.29.22','root','','ask_accounting2526');

  if ($conn) {
  $i=0;
    $sql = "select * from `entries`";
    $result = $conn->query($sql);

      if ($result->num_rows>0) {
     
        while ($row = $result->fetch_assoc()) {
          
            $entries[$i][0] = $row['id'];
            $entries[$i][1] = $row['entry_type'];
            $entries[$i][2] = $row['number'];
            $entries[$i][3] = $row['date'];
            $entries[$i][4] = $row['dr_total'];
            $entries[$i][5] = $row['cr_total'];
            $entries[$i][6] = $row['narration'];

            $i++;

        }

      }

      if (!empty($entries)) {
       $sum=0;
        for ($i=0; $i <count($entries) ; $i++) { 

          $amount[$i] = amount_entry($entries[$i][0]);

          // var_dump($amount[$i][0]." || ".($entries[$i][4]+$entries[$i][5]));

          if ($amount[$i][0]!=($entries[$i][4]+$entries[$i][5])) {

            $diff[$i] = ($amount[$i][0])-($entries[$i][4]+$entries[$i][5]);
            // echo $amount[$i][0]-($entries[$i][4]+$entries[$i][5])."<br>";

            // echo $entries[$i][0]." || ".$amount[$i][0]." || ".($entries[$i][4]+$entries[$i][5])."<br>";

            // var_dump($entries[$i][0]." ||| ".$diff[$i]);

            $sum += $diff[$i];
            // var_dump($entries[$i][0]." || ".$diff[$i]);
            
            $arr[$i] = preg_replace("/[^0-9]{1,4}/", '', $entries[$i][6]); 

            echo $arr[$i]." || ".$entries[$i][3]." || ".$entries[$i][4]." || ".$diff[$i]." || ".$entries[$i][0]."<br>";
            

          }

       


        }

        // var_dump($sum);


      }









  }












      function amount_entry($entry_id){
$i=0;

        $conn=mysqli_connect("192.168.29.22","root","","ask_accounting2526");
     global $conn;
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

          $sql = "select sum(amount) as amounts from `entry_items` where `entry_id`='".$entry_id."'";
          $result = $conn->query($sql);


        if ($result->num_rows>0) {
       
          while ($row = $result->fetch_assoc()) {
            
              $entries_item[$i] = $row['amounts'];

              $i++;

          }

        }

        return $entries_item;


      }










  
  // $array = array(1,2,4,5);

  // for ($i=0; $i <count($array)-2 ; $i++) { 
  //   for ($j=0; $j <count($array)-1 ; $j++) { 
  //       for ($k=0; $k <count($array) ; $k++) { 
  //         if ($array[$i]+$array[$j]+$array[$k]==9) {
  //           echo '{'.$array[$i].",".$array[$j].",".$array[$k]."}, ";
  //         }
  //       }

  //   }
  // }


  // var_dump($array);



