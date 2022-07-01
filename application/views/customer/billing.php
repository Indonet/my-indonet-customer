<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Billing Statement</h5>  
            </div>  
        </div>
    </div> 
    <div class="d-flex flex-column-fluid">    
		<div class="container-fluid">   
            <div class="card card-custom overflow-hidden">
                <div class="card-header"> 
                    <div class="card-title">
                        <h3 class="card-label">Invoice
                        <span class="d-block text-muted pt-2 font-size-sm">Billing statement Indonet</span></h3>
                    </div>   
                    <div class="card-toolbar">  
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary font-weight-bolder">
                                <i class="flaticon-calendar-3"></i> <span class="txt_month"><?=$month_year_name_now?></span>
                            </button>
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <ul class="nav nav-hover flex-column">
                                    <?php
                                        foreach ($inv_month_total as $key => $value) { 
                                            $y = substr($key, 0,-2);
                                            $m = substr($key, -2);  
                                            $inv_m =  date_create($y.'-'.$m); 
                                            $inv_m = date_format($inv_m,"F Y"); 
                                            echo    '<li class="nav-item">
                                                        <a href="#" class="nav-link" onclick="get_inv_page(\''.$m.'\',\''.$y.'\',\''.$inv_m.'\')">
                                                            <i class="flaticon-calendar-3"></i> 
                                                            <span class="ml-2">'.$inv_m.'</span> 
                                                        </a>
                                                    </li>';
                                            
                                        }

                                    ?> 
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 inv_page_div">  

                </div>
            </div> 
        </div>
    </div>
</div>
<script>
    __init(); 
    function __init(){
        var TodayDate = new Date();
        var d = TodayDate.getDay();
        var m = TodayDate.getMonth();
        var y = TodayDate.getFullYear(); 
        const monthNumber = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        const monthNames = ["January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                            ];
        var m_name = monthNames[m]+' '+y; 
        var m_no = monthNumber[m]; 

   
        get_inv_page(m_no,y, m_name);
    }
    function get_inv_page(month = '', year ='', m_name = ''){ 
        Swal.fire ({
            onBeforeOpen: () => { 
                Swal.showLoading ()
            }
        }); 
        $.ajax({
            type: "POST",
            url: base_url+"get-inv-view",
            data: { 
                'month':month, 'year':year
            },
            cache: false,
            dataType: "html",
            success: function (res) {  
                $('.txt_month').html(m_name);
                $('.inv_page_div').html(res); 
                Swal.close();
            }
        }); 

        
    }
</script>