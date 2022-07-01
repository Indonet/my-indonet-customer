<link href="<?=base_url()?>assets/themes/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" /> 
<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Usage Alibaba Cloud</h5>  
            </div> 
        </div>
    </div> 
    <div class="d-flex flex-column-fluid">  
		<div class="container-fluid">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Usage Alibaba Cloud List
                        <span class="d-block text-muted pt-2 font-size-sm">your billing usage alibaba cloud</span></h3>
                    </div> 
                </div>
                <div class="card-body"> 
                    <div class="form-group row col-sm-12">
                        <div class=" col-lg-4 col-sm-4 row">
                            <label class="col-form-label text-right col-lg-3 col-sm-3">Periode</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 input-group">
                                <?php $date_now = date('d-m-Y H:i:s');?>
                                <input type="text" class="form-control" id="periode_view" placeholder="Month Year" value="<?=date('F Y', strtotime($date_now))?>" />
                                <div class="input-group-append" style="cursor: pointer; max-height: 39px;">
                                    <span class="input-group-text btn-success" onclick="get_data()">
                                        <i class="la la-check mr-2"></i> View
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive"> 
                        <table class="table table-bordered table-checkable" id="list_billing_alicloud">
                            <thead>
                                <tr>  
                                    <th class="text-center">Instance ID</th>
                                    <th class="text-center">Order Type</th>
                                    <th class="text-center">Product Name</th> 
                                    <th class="text-center">Region</th> 
                                    <th class="text-center">Pretax Cost</th> 
                                    <th class="text-center">Billing Cycle</th> 
                                    <th class="text-center">UID</th> 
                                    <th class="text-center">Customer Account</th> 
                                    <th class="text-center">Billing Method</th> 
                                    <th class="text-center">Instance Name</th> 
                                    <th class="text-center">Product Code</th> 
                                    <th class="text-center">Config Details</th> 
                                    <th class="text-center">Original Cost</th> 
                                    <th class="text-center">Billing Discount</th> 
                                    <th class="text-center">Billing Discount Percentage</th> 
                                    <th class="text-center">Coupon Deduct Cost</th> 
                                    <th class="text-center">Tag</th>  

                                </tr>
                            </thead>
                            <tbody>  
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script src="<?=base_url()?>assets/themes/plugins/custom/datatables/datatables.bundle.js"></script>  
<script>
     $(document).ready(function() {  
        var base_url = "<?=base_url();?>";  
        $('#periode_view').datepicker({  
            orientation: "bottom left",  
            format: "MM yyyy",
            startView: "months", 
            minViewMode: "months",
            autoclose: true
        });
        get_data();
    });   
    $.fn.dataTable.ext.errMode = 'none';
    function get_data(){
        var periode = $('#periode_view').val(); 
        $('#list_billing_alicloud').DataTable().destroy(); 
        $('#list_billing_alicloud').DataTable( {     
              
        ajax:{
                "url":  base_url+"get-list-usage-alibaba",
                "type": "POST", 
                "data": {"periode":periode}
            },
            "columns": [    
                {   "data": "instance_id" },   
                {   "data": "order_type" },   
                {   "data": "product_name" },   
                {   "data": "region" },   
                {   "data": "pretax_cost",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){  
                            var amount = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            data = row.currency+' '+amount; 
                        } 
                        return data;
                    }
                },
                {   "data": "billing_cycle" },   
                {   "data": "uid" },   
                {   "data": "customer_account" },   
                {   "data": "billing_method" },   
                {   "data": "instance_name" },   
                {   "data": "product_code" },   
                {   "data": "config_details" },   
                {   "data": "original_cost" },   
                {   "data": "billing_discount" },   
                {   "data": "billing_discount_percentage" },   
                {   "data": "coupon_deduct" },   
                {   "data": "tag" }
            ],   
            dom: 'Bfrtip',
            buttons: [ 
                {
                    text: '<i class="icon far fa-file-excel"></i> Export Excel',
                    extend: 'excelHtml5',
                    exportOptions: { 
                        columns: [ 0, 1, 2,3,4,5,6,7,8,9,10,11,12,13,14,15,16 ]
                    }
                }
            ],
            "columnDefs": [ 
                {
                    "targets": [ 4 ],
                    "className": "text-right"
                }, 
                {
                    "targets": [ 5,6,7,8,9,10,11,12,13,14,15,16 ],
                    visible: false,
                    searchable: false,
                }
            ],
            "pageLength": 10, 
            "order": [[0, 'desc']]
        } ); 
    }
    function get_data_periode(){

    }
</script>