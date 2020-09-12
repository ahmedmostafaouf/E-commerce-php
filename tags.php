<?php
session_start();
include 'init.php';?>
<div class = 'container'>
       <div class='row'>
                     <?php
               if(isset ($_GET['name'])){
              echo  "<h1 class='text-center'>".$_GET['name'] ." </h1>";
                    $tag =$_GET['name'];
                          $allitems=getAllfrom("*","items"," where tags like '%$tag%'"," AND approve = 1","item_id","DESC" );
                         foreach($allitems as $items)
                         {
                              echo '<div class = "col-sm-6 col-md-3">';
                                   echo '<div class="thumbnail item-box">';
                                        echo '<span class="price-tag">$'.$items['price'] .'</span>';
                                        echo '<img class="img-responsive" src="img.jpg" alt="" />';
                                        echo '<div class = "caption">';
                                             echo '<h3><a href="item.php?item_id='.$items['item_id'].'">'.$items['name'] .'</a></h3>';
                                             echo '<p>'.$items['description'] .'</p>';
                                             echo '<div class="date">'. $items['add_date'].'</div>';
                                        echo '</div>';
                                   echo '</div>';
                              echo '</div>';
                         } 
                    }else{
                         echo "<div class = 'alert alert-danger'> You Must Enter Taf Name </div>";
                    }
                    ?>
       </div>
</div>

<?php include $tpl  .  'fotar.php' ;?>