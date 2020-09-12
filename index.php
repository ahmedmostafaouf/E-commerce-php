<?php
session_start();
$pageTitle= "Home Page";
include 'init.php';
       ?>
<div class = 'container'>
       <div class='row'>
                     <?php
                     $Allitems=  getAllfrom('*','items', 'where approve = 1' ,'','item_id','DESC');
                     foreach( $Allitems as $items)
                     {
                            echo '<div class = "col-sm-6 col-md-3">';
                                 echo '<div class="thumbnail item-box">';
                                      echo '<span class="price-tag">'.$items['price'] .'</span>';
                                      echo '<img class="img-responsive" src="img.jpg" alt="" />';
                                      echo '<div class = "caption">';
                                          echo '<h3><a href="item.php?item_id='.$items['item_id'].'">'.$items['name'] .'</a></h3>';
                                          echo '<p>'.$items['description'] .'</p>';
                                          echo '<div class="date">'. $items['add_date'].'</div>';
                                      echo '</div>';
                                 echo '</div>';
                            echo '</div>';
                     }
                    ?>
       </div>
                           <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5e77dd79eec7650c3321dd31/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</div>
<?php
include $tpl  .  'fotar.php' ; 

?>
