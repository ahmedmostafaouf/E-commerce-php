        <div class= "fotar">
         
        </div>
        <script src= "<?php echo $js; ?>jquery-1.12.1.min.js"></script>
        <script src= "<?php echo $js; ?>bootstrap.min.js"></script> 
        <script src= "<?php echo $js; ?>front.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>  
       $(document).ready(function(e){
        $("#Chat").on('submit', function(e){
         e.preventDefault();
         $.ajax({
              type: 'POST',
              url :'send.php',
              data : new FormData(this),
              contentType :false,
              cache :false,
              processData :false,
              success:function(data){
                  $('#Success').html(data);
              }
     });
     
     $('#msg').val("");

 });



 /*   //dile type validation
      $("#img").change(function(){
             var file = this.files[0];
             var imagefile = file.type;
             var match=["image/jpeg","image/png","image/jpg","image/Gif"];
             if(!((imagefile==match[0]) || (imagefile==match[1]))){
                 alert('(JPEG/JPG/PNG/gif)  من فضلك ادخل نوع ملف مدعوم ');
                 $("#img").val('');
                 return false;
             }

     } 
 }); */
 });
/*  $(document).ready(function(){
    $('#sendbtn').click(function(e){
      e.preventDefault();
      var msg =$('#msg').val();
      $.ajax({
          url: "send.php",
          type:'POST',
          data:{m:msg},
          contentType :false,
              cache :false,
              processData :false,
          success:function(data){
            $('#Success').html(data);
          }


      });
      $('#msg').val("")

    });

    

});  
 */
  </script>
    </body>
</html>    