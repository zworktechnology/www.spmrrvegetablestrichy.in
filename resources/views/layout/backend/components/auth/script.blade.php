<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script src="{{ asset('assets/backend/js/feather.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/apexchart/chart-data.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/select2/js/select2.min.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/sweetalert/sweetalerts.min.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/toastr/toastr.js') }}"></script>

<script src="{{ asset('assets/backend/js/script.js') }}"></script>

<script src="{{ asset('assets/backend/js/custom/purchase_create.js') }}"></script>

<script>
// PURCHASE

   var j = 1;
   var i = 1;
    $(document).ready(function() {
        $("#addproductfields").click(function() {
         ++i;
                $("#product_fields").append(
                    '<tr>' +
                    '<td class=""><input type="hidden"id="purchase_detail_id"name="purchase_detail_id[]" />' +
                    '<select class="select form-control product_id"name="product_id[]" id="product_id' + i + '"required>' +
                    '<option value="" selected hidden class="text-muted">Select Product</option></select>' +
                    '</td>' +
                    '<td><input type="text" class="form-control" id="bag" name="bag[]" placeholder="Bag" value="" required /></td>' +
                    '<td><input type="text" class="form-control kgs" id="kgs" name="kgs[]" placeholder="kgs" value="" required /></td>' +
                    '<td><input type="text" class="form-control price_per_kg" id="price_per_kg" name="price_per_kg[]" placeholder="Price Per Kg" value="" required /></td>' +
                    '<td class="text-end"><input type="text" class="form-control total_price" id="total_price" readonly style="background-color: #e9ecef;" name="total_price[]" placeholder="" value="" required /></td>' +
                    '<td><button style="width: 100px;" class="text-white font-medium rounded-lg text-sm  text-center btn btn-danger remove-tr" type="button" >Remove</button></td>' +
                    '</tr>'
                );

                $.ajax({
                    url: '/getProducts/',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        //console.log(response['data']);
                        var len = response['data'].length;

                        var selectedValues = new Array();

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                
                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    selectedValues.push(option);
                            }
                        }
                        ++j;
                        $('#product_id' + j).append(selectedValues);
                        //add_count.push(Object.keys(selectedValues).length);
                    }
                });
        });

        $('#branch_id').on('change', function() {
            var branch_id = this.value;
            var supplier_id = $("#supplier_id").val();
            $('.old_balance').html('');
            $.ajax({
            url: '/getoldbalance/',
            type: 'get',
            data: {
                        _token: "{{ csrf_token() }}",
                        supplier_id: supplier_id,
                        branch_id: branch_id
                    },
            dataType: 'json',
                success: function(response) {
                    console.log(response['data']);
                    var value = 0;
                    if(response['data'] > 0){
                        $(".old_balance").val(response['data']);
                    }else {
                        $(".old_balance").val(value);
                    }
                    
                }
            });
        });


        $('#supplier_id').on('change', function() {
            var supplier_id = this.value;
            var branch_id = $("#branch_id").val();
            $('.old_balance').html('');
            $.ajax({
            url: '/getoldbalance/',
            type: 'get',
            data: {
                        _token: "{{ csrf_token() }}",
                        supplier_id: supplier_id,
                        branch_id: branch_id
                    },
            dataType: 'json',
                success: function(response) {
                    console.log(response['data']);
                    var value = 0;
                    if(response['data'] > 0){
                        $(".old_balance").val(response['data']);
                    }else {
                        $(".old_balance").val(value);
                    }
                    
                }
            });
        });

    });


    $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();

            var totalAmount = 0;
            $("input[name='total_price[]']").each(
                                    function() {
                                        //alert($(this).val());
                                        totalAmount = Number(totalAmount) +
                                            Number($(this).val());
                                        $('.total_amount').val(
                                            totalAmount);
                                    });
                var extracost = $(".extracost").val();
                var total_amount = $(".total_amount").val();
                var gross_amount = Number(total_amount) + Number(extracost);
                $('.gross_amount').val(gross_amount.toFixed(2));
                var old_balance = $(".old_balance").val();
                var grand_total = Number(old_balance) + Number(gross_amount);
                $('.grand_total').val(grand_total.toFixed(2));

                var payable_amount = $(".payable_amount").val();
                var grand_total = $(".grand_total").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2));

                $(document).on("keyup", 'input.payable_amount', function() { 
                var payable_amount = $(this).val();
                var grand_total = $(".grand_total").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2));
            });
    });


      $(document).on("blur", "input[name*=kgs]", function() {
         var kgs = $(this).val();
         var price_per_kg = $(this).parents('tr').find('.price_per_kg').val();
         var total = kgs * price_per_kg;
         $(this).parents('tr').find('.total_price').val(total);

         var totalAmount = 0;
            $("input[name='total_price[]']").each(
                                    function() {
                                        //alert($(this).val());
                                        totalAmount = Number(totalAmount) +
                                            Number($(this).val());
                                        $('.total_amount').val(
                                            totalAmount);
                                    });
                var extracost = $(".extracost").val();
                var total_amount = $(".total_amount").val();
                var gross_amount = Number(total_amount) + Number(extracost);
                $('.gross_amount').val(gross_amount.toFixed(2));
                var old_balance = $(".old_balance").val();
                var grand_total = Number(old_balance) + Number(gross_amount);
                $('.grand_total').val(grand_total.toFixed(2));

                var payable_amount = $(".payable_amount").val();
                var grand_total = $(".grand_total").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2));
                                    

            $(document).on("keyup", 'input.extracost', function() {   
                var extracost = $(this).val();
                var total_amount = $(".total_amount").val();
                var gross_amount = Number(total_amount) + Number(extracost);
                $('.gross_amount').val(gross_amount.toFixed(2));
                var old_balance = $(".old_balance").val();
                var grand_total = Number(old_balance) + Number(gross_amount);
                $('.grand_total').val(grand_total.toFixed(2));
            });   
            
            $(document).on("keyup", 'input.payable_amount', function() { 
                var payable_amount = $(this).val();
                var grand_total = $(".grand_total").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2));
            });
      });

      $(document).on("blur", "input[name*=price_per_kg]", function() {
         var price_per_kg = $(this).val();
         var kgs = $(this).parents('tr').find('.kgs').val();
         var total = kgs * price_per_kg;
         $(this).parents('tr').find('.total_price').val(total);

         var totalAmount = 0;
            $("input[name='total_price[]']").each(
                                    function() {
                                        //alert($(this).val());
                                        totalAmount = Number(totalAmount) +
                                            Number($(this).val());
                                        $('.total_amount').val(
                                            totalAmount);
                                    });

                var extracost = $(".extracost").val();
                var total_amount = $(".total_amount").val();
                var gross_amount = Number(total_amount) + Number(extracost);
                $('.gross_amount').val(gross_amount.toFixed(2));
                var old_balance = $(".old_balance").val();
                var grand_total = Number(old_balance) + Number(gross_amount);
                $('.grand_total').val(grand_total.toFixed(2));

                var payable_amount = $(".payable_amount").val();
                var grand_total = $(".grand_total").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2)); 
                
                
            $(document).on("keyup", 'input.extracost', function() {   
                var extracost = $(this).val();
                var total_amount = $(".total_amount").val();
                var gross_amount = Number(total_amount) + Number(extracost);
                $('.gross_amount').val(gross_amount.toFixed(2));
                var old_balance = $(".old_balance").val();
                var grand_total = Number(old_balance) + Number(gross_amount);
                $('.grand_total').val(grand_total.toFixed(2));
            });   
            
            $(document).on("keyup", 'input.payable_amount', function() { 
                var payable_amount = $(this).val();
                var grand_total = $(".grand_total").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2));
            });                    
      });


   
   

// SALES

var j = 1;
var i = 1;


$(document).ready(function() {

    $("#addsalesproductfields").click(function() {
        ++i;
                $("#sales_productfields").append(
                    '<tr>' +
                    '<td class=""><input type="hidden"id="sales_detail_id"name="sales_detail_id[]" />' +
                    '<select class="select form-control sales_product_id"name="sales_product_id[]" id="sales_product_id' + i + '"required>' +
                    '<option value="" selected hidden class="text-muted">Select Product</option></select>' +
                    '</td>' +
                    '<td><input type="text" class="form-control" id="sales_bag" name="sales_bag[]" placeholder="Bag" value="" required /></td>' +
                    '<td><input type="text" class="form-control sales_kgs" id="sales_kgs" name="sales_kgs[]" placeholder="kgs" value="" required /></td>' +
                    '<td><input type="text" class="form-control sales_priceperkg" id="sales_priceperkg" name="sales_priceperkg[]" placeholder="Price Per Kg" value="" required /></td>' +
                    '<td class="text-end"><input type="text" class="form-control sales_total_price" id="sales_total_price" readonly style="background-color: #e9ecef;" name="sales_total_price[]" placeholder="" value="" required /></td>' +
                    '<td><button style="width: 100px;" class="text-white font-medium rounded-lg text-sm  text-center btn btn-danger remove-salestr" type="button" >Remove</button></td>' +
                    '</tr>'
                );


                $.ajax({
                    url: '/getProducts/',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        //console.log(response['data']);
                        var len = response['data'].length;

                        var selectedValues = new Array();

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                
                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    selectedValues.push(option);
                            }
                        }
                        ++j;
                        $('#sales_product_id' + j).append(selectedValues);
                        //add_count.push(Object.keys(selectedValues).length);
                    }
                });
    });



    $('#sales_branch_id').on('change', function() {
            var sales_branch_id = this.value;
            var sales_customerid = $("#sales_customerid").val();
            $('.sales_old_balance').html('');
            $.ajax({
            url: '/getoldbalanceforSales/',
            type: 'get',
            data: {
                        _token: "{{ csrf_token() }}",
                        sales_customerid: sales_customerid,
                        sales_branch_id: sales_branch_id
                    },
            dataType: 'json',
                success: function(response) {
                    console.log(response['data']);
                    var value = 0;
                    if(response['data'] > 0){
                        $(".sales_old_balance").val(response['data']);
                    }else {
                        $(".sales_old_balance").val(value);
                    }
                    
                }
            });
        });


        $('#sales_customerid').on('change', function() {
            var sales_customerid = this.value;
            var sales_branch_id = $("#sales_branch_id").val();
            $('.sales_old_balance').html('');
            $.ajax({
            url: '/getoldbalanceforSales/',
            type: 'get',
            data: {
                        _token: "{{ csrf_token() }}",
                        sales_customerid: sales_customerid,
                        sales_branch_id: sales_branch_id
                    },
            dataType: 'json',
                success: function(response) {
                    console.log(response['data']);
                    var value = 0;
                    if(response['data'] > 0){
                        $(".sales_old_balance").val(response['data']);
                    }else {
                        $(".sales_old_balance").val(value);
                    }
                    
                }
            });
        });
});



$(document).on('click', '.remove-salestr', function() {
            $(this).parents('tr').remove();

            var totalAmount = 0;
            $("input[name='sales_total_price[]']").each(
                                    function() {
                                        //alert($(this).val());
                                        totalAmount = Number(totalAmount) +
                                            Number($(this).val());
                                        $('.sales_total_amount').val(
                                            totalAmount);
                                    });
                var sales_extracost = $(".sales_extracost").val();
                var sales_total_amount = $(".sales_total_amount").val();
                var sales_gross_amount = Number(sales_total_amount) + Number(sales_extracost);
                $('.sales_gross_amount').val(sales_gross_amount.toFixed(2));
                var sales_old_balance = $(".sales_old_balance").val();
                var sales_grand_total = Number(sales_old_balance) + Number(sales_gross_amount);
                $('.sales_grand_total').val(sales_grand_total.toFixed(2));

                var salespayable_amount = $(".salespayable_amount").val();
                var sales_grand_total = $(".sales_grand_total").val();
                var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));

                $(document).on("keyup", 'input.salespayable_amount', function() { 
                var salespayable_amount = $(this).val();
                var sales_grand_total = $(".sales_grand_total").val();
                var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));
            });
    });



    $(document).on("blur", "input[name*=sales_kgs]", function() {
         var sales_kgs = $(this).val();
         var sales_priceperkg = $(this).parents('tr').find('.sales_priceperkg').val();
         var sales_total = sales_kgs * sales_priceperkg;
         $(this).parents('tr').find('.sales_total_price').val(sales_total);

         var totalAmount = 0;
            $("input[name='sales_total_price[]']").each(
                                    function() {
                                        //alert($(this).val());
                                        totalAmount = Number(totalAmount) +
                                            Number($(this).val());
                                        $('.sales_total_amount').val(
                                            totalAmount);
                                    });
                var sales_extracost = $(".sales_extracost").val();
                var sales_total_amount = $(".sales_total_amount").val();
                var sales_gross_amount = Number(sales_total_amount) + Number(sales_extracost);
                $('.sales_gross_amount').val(sales_gross_amount.toFixed(2));
                var sales_old_balance = $(".sales_old_balance").val();
                var sales_grand_total = Number(sales_old_balance) + Number(sales_gross_amount);
                $('.sales_grand_total').val(sales_grand_total.toFixed(2));

                var salespayable_amount = $(".salespayable_amount").val();
                var sales_grand_total = $(".sales_grand_total").val();
                var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));
                                    

            $(document).on("keyup", 'input.sales_extracost', function() {   
                var sales_extracost = $(this).val();
                var sales_total_amount = $(".sales_total_amount").val();
                var sales_gross_amount = Number(sales_total_amount) + Number(sales_extracost);
                $('.sales_gross_amount').val(sales_gross_amount.toFixed(2));
                var sales_old_balance = $(".sales_old_balance").val();
                var sales_grand_total = Number(sales_old_balance) + Number(sales_gross_amount);
                $('.sales_grand_total').val(sales_grand_total.toFixed(2));
            });   
            
            $(document).on("keyup", 'input.salespayable_amount', function() { 
                var salespayable_amount = $(this).val();
                var sales_grand_total = $(".sales_grand_total").val();
                var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));
            });
      });



      $(document).on("blur", "input[name*=sales_priceperkg]", function() {
         var sales_priceperkg = $(this).val();
         var sales_kgs = $(this).parents('tr').find('.sales_kgs').val();
         var sales_total = sales_kgs * sales_priceperkg;
         $(this).parents('tr').find('.sales_total_price').val(sales_total);

         var totalAmount = 0;
         $("input[name='sales_total_price[]']").each(
                                    function() {
                                        //alert($(this).val());
                                        totalAmount = Number(totalAmount) +
                                            Number($(this).val());
                                        $('.sales_total_amount').val(
                                            totalAmount);
                                    });
                var sales_extracost = $(".sales_extracost").val();
                var sales_total_amount = $(".sales_total_amount").val();
                var sales_gross_amount = Number(sales_total_amount) + Number(sales_extracost);
                $('.sales_gross_amount').val(sales_gross_amount.toFixed(2));
                var sales_old_balance = $(".sales_old_balance").val();
                var sales_grand_total = Number(sales_old_balance) + Number(sales_gross_amount);
                $('.sales_grand_total').val(sales_grand_total.toFixed(2));

                var salespayable_amount = $(".salespayable_amount").val();
                var sales_grand_total = $(".sales_grand_total").val();
                var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));
                                    

            $(document).on("keyup", 'input.sales_extracost', function() {   
                var sales_extracost = $(this).val();
                var sales_total_amount = $(".sales_total_amount").val();
                var sales_gross_amount = Number(sales_total_amount) + Number(sales_extracost);
                $('.sales_gross_amount').val(sales_gross_amount.toFixed(2));
                var sales_old_balance = $(".sales_old_balance").val();
                var sales_grand_total = Number(sales_old_balance) + Number(sales_gross_amount);
                $('.sales_grand_total').val(sales_grand_total.toFixed(2));
            });   
            
            $(document).on("keyup", 'input.salespayable_amount', function() { 
                var salespayable_amount = $(this).val();
                var sales_grand_total = $(".sales_grand_total").val();
                var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));
            });   
      });


</script>
