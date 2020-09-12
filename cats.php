<?php
session_start();
include 'init.php';?>
<div class = 'container'>
       <h1 class="text-center"> Show Category Items </h1>
       <div class='row'>
                     <?php
               //  $itemid=isset ($_GET['item_id'])&& is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;
               if(isset ($_GET['pageid'])&& is_numeric($_GET['pageid'])){
                    $category =intval($_GET['pageid']);
                         $allitems=getAllfrom("*","items"," where cat_id ={$category}"," AND approve = 1","item_id","DESC" );
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
                         echo "<div class = 'alert alert-danger'> You Must ADD PageID</div>";
                    }
                    ?>
       </div>
</div>

<?php include $tpl  .  'fotar.php' ;?>