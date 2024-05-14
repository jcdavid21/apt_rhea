function handleCancelAction(name, time){
    $(document).ready(()=>{
        $.ajax({
            url: 'cancel.php',
            method: 'post',
            data:{
                name,
                time
            },
            success: function(response){
                if(response === 'success'){
                    Swal.fire({
                        title: "Appointment Cancelled!",
                        text: "Appoinment Cancelled Successfully",
                        icon: false,
                        focusConfirm: false,
                        timer: 2000
                      }).then((result)=>{
                        if(result){
                            window.location.reload();
                        }
                      })
                }else{
                    alert("Updating error!");
                }
            }
        })
    })
}