<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
			<div class="d-flex align-items-center flex-wrap mr-2">  
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">&nbsp;</h5>   
			</div> 
		</div>
	</div> 
</div>
<script>  
    var base_url = "<?=base_url()?>";
	Swal.fire ({
		onBeforeOpen: () => {
			swal.fire({
				html: '<h5>Fetching data<br>Please wait...</h5>',
				showConfirmButton: false,
                allowOutsideClick: false
			});
			Swal.showLoading ()
		}
	}); 
    $.ajax({
        type: "POST",
        url: base_url+"generated_data",
        data: { 
            
        },
        cache: false,
        dataType: "json",
        success: function (res) { 
            if(res.result){  
                setTimeout(function(){ check_data() }, 1000);
            }else{
                Swal.fire(res.message,'','error').then((result) => { 
                    window.location.href = base_url+'auth/logout';
                });  
            }
        }
    }); 
    function check_data(){
        $.ajax({
            type: "POST",
            url: base_url+"check_generated_data",
            data: { 
                
            },
            cache: false,
            dataType: "json",
            success: function (res) { 
                if(res.result){  
                    Swal.fire({
                        title: 'Fetching data Success',
                        html: '',
                        icon: 'success',
                        timer: 1000, 
                        buttons: false,
                        showConfirmButton: false
                    }).then((result) => {
                        window.location.href = base_url+'dashboard/';
                    })  
                }else{ 
                    setTimeout(function(){ check_data() }, 3000);
                }
            }
        }); 
    }
</script>   