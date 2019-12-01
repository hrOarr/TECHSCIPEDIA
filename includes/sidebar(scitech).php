    <form style="margin-top: 20px;background-color: #fff;">
     <div class="container">
        <div>
           <h4 class="fa fa-long-arrow-right" style="font-size: 23px;font-weight: bold;">Popular Blogs</h4>
        </div>
            <?php
            $stmt = $db->query('SELECT * FROM editorialscitech WHERE (postdate > DATE_SUB(curdate(), INTERVAL 5 WEEK) AND status = 1) ORDER BY count DESC LIMIT 5');
            while($row = $stmt->fetch()){
            
               // echo '<a href="'.$row['ediSlug'].'">';
                //echo '<img class="media-object" src="admin/uploads/'.$row['image'].'" width="100%">';
                //echo '</a>';
                   
                    $string = $row['ediTitle'];
                    if (strlen($string) > 80) {
                    $trimhead = substr($string, 0, 80);
                    } else {
                    $trimhead = $string;
                    }
                    
                    echo '<h5 style="text-decoration:underline;font-size:18px;"><a href="fullviewblog(scitech).php?id='.$row['ediSlug'].'" style="color:#3e42df;">'.$trimhead.'</a></h5>';
                      /*
                      echo '<ul class="list-inline list-unstyled">';
                          $tim = abs(time() - strtotime($row['ediDate']));
                              $tim = ceil($tim/(60*60*24));
                              if($tim<365){
                              if($tim==1){
                              echo '<li class="list-inline-item"><span>Posted </span>'.$tim.' <span>day ago </span></li>';
                              }
                              else{
                                echo '<li class="list-inline-item"><span>Posted </span>'.$tim.' <span>days ago </span></li>';
                              }
                              }
                              else{
                                $tim = $tim/365;
                                if($tim==1){
                                echo '<li class="list-inline-item"><span>Posted </span>'.$tim.' <span>year ago </span></li>';
                              }
                              else{
                                echo '<li class="list-inline-item"><span>Posted </span>'.$tim.' <span>years ago </span></li>';
                              }
                              }
                        echo '</ul>';
                        */
                    }
                    ?>
                  </br>
      </div>
    </form>
      <!-- Tags -->
    <form style="margin-top: 20px;background-color: #fff;">
      <div class="container">
        <div>
           <h4 class="fa fa-long-arrow-right" style="font-size: 23px;font-weight: bold;">Blog Tags</h4>
        </div>
                    <?php
                    $stmt = $db->query('SELECT topTitle, topSlug FROM tagsscitech WHERE status = 1 ORDER BY topID DESC');
                    while($row = $stmt->fetch()){
                        echo '<ul class="list-inline list-unstyled">';
                         echo '<li><h5 style="font-size:16px;"><a href="viewbytag(scitech).php?id='.$row['topSlug'].'" style="text-decoration:underline;color:#3e42df;" >'.$row['topTitle'].'</a></h5></li>';
                        echo '</ul>';
                     }
                    ?>
                  </br>
               
      </div>
    </form>