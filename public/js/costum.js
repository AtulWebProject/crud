$(document).ready(function() {
    $(".viewdata").click(function() {
            // var formData = $(".idform").val();
            // alert(formData);
            var row = $(this).closest("tr").find('.viewid').text();
             //alert(row);
             $.ajax({
                 url:'{{route('get_iptcdata')}}',
                 method:"post",
                 data:{"_token": "{{ csrf_token() }}",
                  "id":row,
                 },
                 beforeSend: function() {
                  // $("#profile_form")[0].reset();
                $("#iptcdata").html("<p class='text-success'> Loading....... </p>");
                  
                // $("#BtnProfile").hide();
              },  
                  success: function(response){
                    
                      $('#iptcdata').html(response);

               }
             });
        });  
});