<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Report</h5>  
            </div> 
        </div>
    </div> 
    <div class="d-flex flex-column-fluid">  
		<div class="container-fluid">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Report List
                        <span class="d-block text-muted pt-2 font-size-sm">your report list Indonet</span></h3>
                    </div> 
                </div>
                <div class="card-body"> 
                    <div class="table-responsive">
                        <table class="table table-bordered table-checkable" id="kt_datatable">
                            <thead>
                                <tr> 
                                    <th class="text-center">No</th>
                                    <th class="text-center">Report Name</th>
                                    <th class="text-center">Report Date</th>
                                    <th class="text-center">View Report</th> 
                                </tr>
                            </thead>
                            <tbody> 
                                <?php 
                                    $no = 1; 
                                    // print_r($report_data);
                                    foreach ($report_data as $key => $value) {    
                                        echo '<tr>';
                                            echo '<td>'.$no.'</td>'; 
                                            echo '<td>'.$value['REPORT_NAME'].'</td>'; 
                                            echo '<td>'.$value['REPORT_DATE'].'</td>';  
                                            echo '<td style="text-align: center">
                                                    <a onClick="downloadreportpdf(\''.str_replace(" ","_",$value['REPORT_CODE']).'\')" class="btn btn-light-primary font-weight-bolder btn-sm" href="#">
                                                    <i class="fas fa-file-pdf"></i>View PDF
                                                    </a>
                                                    </td>';
                                        echo '</tr>';
                                        $no++;
                                    }
                                ?>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    function downloadreportpdf(filename){  
        Swal.fire ({
            onBeforeOpen: () => {
                swal.fire({
                    html: '<h5>Get data<br>Please wait...</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                Swal.showLoading ()
            }
        }); 
        setTimeout(function(){   
            var filePath = base_url+'dashboard/view_pdf_report?pdfname='+filename;
            window.open(filePath, '_blank'); 
            Swal.close(); 
        }, 2000);
        
    }
</script>