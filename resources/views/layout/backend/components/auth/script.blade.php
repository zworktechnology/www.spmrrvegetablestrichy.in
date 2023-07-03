<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script src="{{ asset('assets/backend/js/jquery-3.6.0.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/feather.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/apexchart/chart-data.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/sweetalert/sweetalerts.min.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/toastr/toastr.js') }}"></script>

<script src="{{ asset('assets/backend/js/script.js') }}"></script>

<script src="{{ asset('assets/backend/js/custom/purchase_create.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

<script>

$(".purchaseclose").click(function() {
    window.location.reload();
});


// PURCHASE

   var j = 1;
   var i = 1;
   var m = 1;
   var n = 2;
   var o = 3;
   var p = 4;
    $(document).ready(function() {
        $("#addproductfields").click(function() {
         ++i;
                $("#product_fields").append(
                    '<tr>' +
                    '<td class=""><input type="hidden"id="purchase_detail_id"name="purchase_detail_id[]" />' +
                    '<select class="form-control js-example-basic-single product_id select"name="product_id[]" id="product_id' + i + '"required>' +
                    '<option value="" selected hidden class="text-muted">Select Product</option></select>' +
                    '</td>' +
                    '<td><select class=" form-control bagorkg" name="bagorkg[]" id="bagorkg1"required>' +
                    '<option value="" selected hidden class="text-muted">Select</option>' +
                    '<option value="bag">Bag</option><option value="kg">Kg</option>' +
                    '</select></td>' +
                    '<td><input type="text" class="form-control count" id="count" name="count[]" placeholder="count" value="" required /></td>' +
                    '<td><button style="width: 35px;" class="text-white font-medium rounded-lg text-sm  text-center btn btn-danger remove-tr" type="button" >-</button></td>' +
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

        $("#addextranotefields").click(function() {
            $("#extracost_tr").append(
                    '<tr>' +
                    '<td style="font-size:15px;color: black;" class="text-end">Extra Cost<span style="color: red;">*</span></td>' +
                    '<td colspan="3"><input type="text" class="form-control" id="extracost_note" placeholder="Note" value="" name="extracost_note[]" required /></td>' +
                    '<td><input type="text" class="form-control extracost" id="extracost" placeholder="Extra Cost" name="extracost[]" value="" /></td>' +
                    '<td><button style="width: 35px;"class="py-1 text-white remove-extratr font-medium rounded-lg text-sm  text-center btn btn-danger" type="button" id="" value="Add">-</button></td>' +
                    '</tr>'
                );
        });

        $(document).on('click', '.remove-extratr', function() {
            $(this).parents('tr').remove();
        });


       

        $('.commission_ornet').on('change', function() {
            var commission_ornet = this.value;
            if(commission_ornet == 'commission'){
                $("#commission_percent").show();
            }else if(commission_ornet == 'netprice'){
                $("#commission_percent").hide();
                $(".commission_amount").val(0);
                $("#commission_percent").val(0);
            }
        });
        $(document).on("keyup", 'input.commission_percent', function() { 
                var commission_percent = $(this).val();
                var total_amount = $(".total_amount").val();
                var commision_amount = (commission_percent / 100) * total_amount;
                $('.commission_amount').val(commision_amount.toFixed(2));
                $('.tot_comm_extracost').val(commision_amount);

                var totalExtraAmount = 0;
            $("input[name='extracost[]']").each(
                                    function() {
                                        //alert($(this).val());
                                        totalExtraAmount = Number(totalExtraAmount) +
                                            Number($(this).val());
                                        $('.total_extracost').val(
                                            totalExtraAmount);
                                    });
            var tot_comm_extracost = Number(totalExtraAmount) + Number(commision_amount);
            $(".tot_comm_extracost").val(tot_comm_extracost);
        });



        $('.ppayment_branch_id').on('change', function() {
            var branch_id = this.value;
            var supplier_id = $(".ppayment_supplier_id").val();
            //alert(branch_id);
            $('.oldblance').val('');
                $.ajax({
                    url: '/getoldbalanceforPayment/',
                    type: 'get',
                    data: {
                            _token: "{{ csrf_token() }}",
                            supplier_id: supplier_id,
                            branch_id: branch_id
                        },
                    dataType: 'json',
                    success: function(response) {
                        //
                        console.log(response);
                        var len = response.length;
                        for (var i = 0; i < len; i++) {
                            $(".oldblance").val(response[i].payment_pending);
                        }
                    }
                });
        });
        $('.ppayment_supplier_id').on('change', function() {
            var supplier_id = this.value;
            var branch_id = $(".ppayment_branch_id").val();
            //alert(branch_id);
            $('.oldblance').val('');
                $.ajax({
                    url: '/getoldbalanceforPayment/',
                    type: 'get',
                    data: {
                            _token: "{{ csrf_token() }}",
                            supplier_id: supplier_id,
                            branch_id: branch_id
                        },
                    dataType: 'json',
                    success: function(response) {
                        //
                        console.log(response);
                        var len = response.length;
                        for (var i = 0; i < len; i++) {
                            $(".oldblance").val(response[i].payment_pending);
                        }
                    }
                });
        });

        $(document).on("keyup", 'input.payment_payableamount', function() { 
                var payment_payableamount = $(this).val();
                var oldblance = $(".oldblance").val();
                var payment_pending_amount = Number(oldblance) - Number(payment_payableamount);
                $('.payment_pending').val(payment_pending_amount.toFixed(2));
            });

       



        $('.purchaseview').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                var $this = $(this),
                purchase_id = $this.attr('data-id');
                //alert(purchase_id);

                $.ajax({
                    url: '/getPurchaseview/',
                    type: 'get',
                    data: {
                        _token: "{{ csrf_token() }}",
                        purchase_id: purchase_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        var len = response.length;
                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                var Totalextraamount = Number(response[i].tot_comm_extracost) - Number(response[i].commission_amount);
                                $('.purchase_bill_no').html(response[i].purchase_bill_no);
                                $('.purchase_total_amount').html(response[i].purchase_total_amount);
                                $('.purchase_commision').html(response[i].commission_amount);
                                $('.purchase_extra_cost').html(Totalextraamount);
                                $('.purchase_old_balance').html(response[i].purchase_old_balance);
                                $('.purchase_grand_total').html(response[i].purchase_grand_total);
                                $('.purchase_paid_amount').html(response[i].purchase_paid_amount);
                                $('.purchase_balance_amount').html(response[i].purchase_balance_amount);

                                $('.suppliername').html(response[i].suppliername);
                                $('.supplier_contact_number').html(response[i].supplier_contact_number);
                                $('.supplier_shop_name').html(response[i].supplier_shop_name);
                                $('.supplier_shop_address').html(response[i].supplier_shop_address);

                                $('.branchname').html(response[i].branchname);
                                $('.branch_contact_number').html(response[i].branch_contact_number);
                                $('.branch_shop_name').html(response[i].branch_shop_name);
                                $('.branch_address').html(response[i].branch_address);

                                $('.date').html(response[i].date);
                                $('.time').html(response[i].time);
                                $('.bank_namedata').html(response[i].bank_namedata);
                            }
                        }
                    }
                });


            });
        });



        $('.salesview').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                var $this = $(this),
                sales_id = $this.attr('data-id');
                //alert(sales_id);

                $.ajax({
                    url: '/getSalesview/',
                    type: 'get',
                    data: {
                        _token: "{{ csrf_token() }}",
                        sales_id: sales_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        var len = response.length;
                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                $('.sales_bill_no').html(response[i].sales_bill_no);
                                $('.sales_total_amount').html(response[i].sales_total_amount);
                                $('.sales_extra_cost').html(response[i].sales_extra_cost);
                                $('.sales_old_balance').html(response[i].sales_old_balance);
                                $('.sales_grand_total').html(response[i].sales_grand_total);
                                $('.sales_paid_amount').html(response[i].sales_paid_amount);
                                $('.sales_balance_amount').html(response[i].sales_balance_amount);

                                $('.sales_customername').html(response[i].sales_customername);
                                $('.sales_customercontact_number').html(response[i].sales_customercontact_number);
                                $('.sales_customershop_name').html(response[i].sales_customershop_name);
                                $('.sales_customershop_address').html(response[i].sales_customershop_address);

                                $('.sales_branchname').html(response[i].sales_branchname);
                                $('.salesbranch_contact_number').html(response[i].salesbranch_contact_number);
                                $('.salesbranch_shop_name').html(response[i].salesbranch_shop_name);
                                $('.salesbranch_address').html(response[i].salesbranch_address);

                                $('.sales_date').html(response[i].sales_date);
                                $('.sales_time').html(response[i].sales_time);
                                $('.sales_bank_namedata').html(response[i].sales_bank_namedata);
                            }
                        }
                    }
                });


            });
        });


            //$('.checkbalance').each(function() {
               //         $(this).on('click', function(e) {
                  //         e.preventDefault();
                  //         var $this = $(this),
                  //         supplierid = $this.attr('data-id');
                            //alert(supplierid);

                            

                    //        $.ajax({
                      //          url: '/getsupplierbalance/',
                    //            type: 'get',
                    //            data: {
                    //                        _token: "{{ csrf_token() }}",
                     //                       supplierid: supplierid
                      //                  },
                      //          dataType: 'json',
                      //              success: function(response) {
                      //                  console.log(response);
                      //                  var len = response.length;
                       //                 var supplirtotbal = 0;
                        //                if (len > 0) {
                       //                     for (var i = 0; i < len; i++) {
                        //                        supplirtotbal += response[i].balance_amount << 0;
                        //                        var balance_amount = response[0].balance_amount;
                        //                        console.log(balance_amount);
                                                
                         //                       $('.supplier_balance' + m).html(balance_amount);
                         //                       $('.suplier_totbalnce').html(supplirtotbal);
                         //                   }
                         //                  for (var i = 0; i < len; i++) {
                          //                      var balance_amount1 = response[1].balance_amount;
                          //                      console.log(balance_amount1);
                                                
                          //                      $('.supplier_balance' + n).html(balance_amount1);
                           //                 }
                           //             }
                            //        }
                            //    });


                        //});
                     //});

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


        $(document).on("blur", "input[name*=count]", function() {
         var count = $(this).val();
         var price_per_kg = $(this).parents('tr').find('.price_per_kg').val();
         var total = count * price_per_kg;
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

                var payable_amount = $(".payable_amount").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2));
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
         var count = $(this).parents('tr').find('.count').val();
         var total = count * price_per_kg;
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

                        
            var totalExtraAmount = 0;
            $("input[name='extracost[]']").each(
                                    function() {
                                        totalExtraAmount = Number(totalExtraAmount) +
                                            Number($(this).val());
                                        $('.total_extracost').val(
                                            totalExtraAmount);
                                    });
            var commission_amount = $(".commission_amount").val();
            var tot_comm_extracost = Number(totalExtraAmount) + Number(commission_amount);
            $(".tot_comm_extracost").val(tot_comm_extracost);

                
                var total_amount = $(".total_amount").val();
                var gross_amount = Number(total_amount) - Number(tot_comm_extracost);
                $('.gross_amount').val(gross_amount.toFixed(2));
                var old_balance = $(".old_balance").val();
                var grand_total = Number(old_balance) + Number(gross_amount);
                $('.grand_total').val(grand_total.toFixed(2));

                var payable_amount = $(".payable_amount").val();
                var grand_total = $(".grand_total").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2)); 
                
                
            $(document).on("blur", "input[name*=extracost]", function() {  
                var extracost = $(this).val();
                var totalExtraAmount = 0;
                $("input[name='extracost[]']").each(
                                    function() {
                                        //alert($(this).val());
                                        totalExtraAmount = Number(totalExtraAmount) +
                                            Number($(this).val());
                                        $('.total_extracost').val(
                                            totalExtraAmount);
                                    });
            var commission_amount = $(".commission_amount").val();
            var tot_comm_extracost = Number(totalExtraAmount) + Number(commission_amount);
            $(".tot_comm_extracost").val(tot_comm_extracost);
                var total_amount = $(".total_amount").val();
                var gross_amount = Number(total_amount) - Number(tot_comm_extracost);
                $('.gross_amount').val(gross_amount.toFixed(2));
                var old_balance = $(".old_balance").val();
                var grand_total = Number(old_balance) + Number(gross_amount);
                $('.grand_total').val(grand_total.toFixed(2));

                var payable_amount = $(".payable_amount").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2));
            });   
            
            $(document).on("keyup", 'input.payable_amount', function() { 
                var payable_amount = $(this).val();
                var grand_total = $(".grand_total").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2));
            });     

            
            var invoice_supplier = $(".invoice_supplier").val();
            var invoice_branchid = $(".invoice_branchid").val();

            console.log(invoice_branchid);
            console.log(invoice_supplier);
            $('.old_balance').val('');
            $.ajax({
            url: '/getoldbalance/',
            type: 'get',
            data: {_token: "{{ csrf_token() }}",
                        invoice_supplier: invoice_supplier,
                        invoice_branchid: invoice_branchid,
                    },
            dataType: 'json',
                success: function(response) {
                    console.log(response);
                            $(".old_balance").val(response['data']);
                            var gross_amount = $(".gross_amount").val();
                            var grand_total = Number(response['data']) + Number(gross_amount);
                            $('.grand_total').val(grand_total.toFixed(2));

                            var payable_amount = $(".payable_amount").val();
                            var pending_amount = Number(grand_total) - Number(payable_amount);
                            $('.pending_amount').val(pending_amount.toFixed(2));
                }
            });
        });


        $(document).on("blur", "input[name*=extracost]", function() {
        var extracost = $(this).val();
        var totalExtraAmount = 0;
            $("input[name='extracost[]']").each(
                                    function() {
                                        //alert($(this).val());
                                        totalExtraAmount = Number(totalExtraAmount) +
                                            Number($(this).val());
                                        $('.total_extracost').val(
                                            totalExtraAmount);
                                    });
        var commission_amount = $(".commission_amount").val();
        var tot_comm_extracost = Number(totalExtraAmount) + Number(commission_amount);
        $(".tot_comm_extracost").val(tot_comm_extracost);

                var total_amount = $(".total_amount").val();
                var gross_amount = Number(total_amount) - Number(tot_comm_extracost);
                $('.gross_amount').val(gross_amount.toFixed(2));
                var old_balance = $(".old_balance").val();
                var grand_total = Number(old_balance) + Number(gross_amount);
                $('.grand_total').val(grand_total.toFixed(2));

                var payable_amount = $(".payable_amount").val();
                var pending_amount = Number(grand_total) - Number(payable_amount);
                $('.pending_amount').val(pending_amount.toFixed(2));
        });


   
   

// SALES

    $('.sales_branch_id').on('change', function() {
            var sales_branch_id = this.value;
            //alert(sales_branch_id);
                $.ajax({
                    url: '/getbranchwiseProducts/',
                    type: 'get',
                    data: {
                        _token: "{{ csrf_token() }}",
                        sales_branch_id: sales_branch_id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        var len = response.length;

                        var selectedValues = new Array();

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                
                                    var id = response[i].productlistid;
                                    var name = response[i].productlist_name;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    selectedValues.push(option);
                            }
                        }
                        $('#sales_product_id1').append(selectedValues);
                    }
                });
        });



        $('.spayment_branch_id').on('change', function() {
            var spayment_branch_id = this.value;
            var spayment_customer_id = $(".spayment_customer_id").val();
            //alert(branch_id);
            $('.sales_oldblance').val('');
                $.ajax({
                    url: '/oldbalanceforsalespayment/',
                    type: 'get',
                    data: {
                            _token: "{{ csrf_token() }}",
                            spayment_customer_id: spayment_customer_id,
                            spayment_branch_id: spayment_branch_id
                        },
                    dataType: 'json',
                    success: function(response) {
                        //
                        console.log(response);
                        var len = response.length;
                        for (var i = 0; i < len; i++) {
                            $(".sales_oldblance").val(response[i].payment_pending);
                        }
                    }
                });
        });
        $('.spayment_customer_id').on('change', function() {
            var spayment_customer_id = this.value;
            var spayment_branch_id = $(".spayment_branch_id").val();
            //alert(branch_id);
            $('.sales_oldblance').val('');
                $.ajax({
                    url: '/oldbalanceforsalespayment/',
                    type: 'get',
                    data: {
                            _token: "{{ csrf_token() }}",
                            spayment_customer_id: spayment_customer_id,
                            spayment_branch_id: spayment_branch_id
                        },
                    dataType: 'json',
                    success: function(response) {
                        //
                        console.log(response);
                        var len = response.length;
                        for (var i = 0; i < len; i++) {
                            $(".sales_oldblance").val(response[i].payment_pending);
                        }
                    }
                });
        });

        $(document).on("keyup", 'input.spayment_payableamount', function() { 
                var spayment_payableamount = $(this).val();
                var sales_oldblance = $(".sales_oldblance").val();
                var spayment_pending_amount = Number(sales_oldblance) - Number(spayment_payableamount);
                $('.spayment_pending').val(spayment_pending_amount.toFixed(2));
            });

       

var j = 1;
var i = 1;
var k = 1;

$(document).ready(function() {

    $("#addsalesproductfields").click(function() {
        ++i;
                $("#sales_productfields").append(
                    '<tr>' +
                    '<td class=""><input type="hidden"id="sales_detail_id"name="sales_detail_id[]" />' +
                    '<select class="form-control js-example-basic-single select sales_product_id"name="sales_product_id[]" id="sales_product_id' + i + '"required>' +
                    '<option value="" selected hidden class="text-muted">Select Product</option></select>' +
                    '</td>' +
                    '<td><select class=" form-control sales_bagorkg" name="sales_bagorkg[]" id="sales_bagorkg' + i + '"required>' +
                    '<option value="" selected hidden class="text-muted">Select</option>' +
                    '<option value="bag">Bag</option><option value="kg">Kg</option>' +
                    '</select></td>' +
                    '<td><input type="text" class="form-control sales_count" id="sales_count' + i + '" name="sales_count[]" placeholder="count" value="" required /></td>' +
                    '<td><input type="text" class="form-control sales_priceperkg" id="sales_priceperkg" name="sales_priceperkg[]" placeholder="Price Per Count" value="" required /></td>' +
                    '<td class="text-end"><input type="text" class="form-control sales_total_price" id="sales_total_price" readonly style="background-color: #e9ecef;" name="sales_total_price[]" placeholder="" value="" required /></td>' +
                    '<td><button style="width: 35px;" class="text-white font-medium rounded-lg text-sm  text-center btn btn-danger remove-salestr" type="button" >-</button></td>' +
                    '</tr>'
                );

                var sales_branch_id = $(".sales_branch_id").val();
                $.ajax({
                    url: '/getbranchwiseProducts/',
                    type: 'get',
                    data: {
                        _token: "{{ csrf_token() }}",
                        sales_branch_id: sales_branch_id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        var len = response.length;

                        var selectedValues = new Array();

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                
                                    var id = response[i].productlistid;
                                    var name = response[i].productlist_name;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    selectedValues.push(option);
                            }
                        }++j;
                        $('#sales_product_id' + j).append(selectedValues);
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



    $(document).on("blur", "input[name*=sales_count]", function() {
         var sales_count = $(this).val();
         var sales_priceperkg = $(this).parents('tr').find('.sales_priceperkg').val();
         var sales_total = sales_count * sales_priceperkg;
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

                var salespayable_amount = $(".salespayable_amount").val();
                var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));
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
         var sales_count = $(this).parents('tr').find('.sales_count').val();
         var sales_total = sales_count * sales_priceperkg;
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

                var salespayable_amount = $(".salespayable_amount").val();
                var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));
            });   
            
            $(document).on("keyup", 'input.salespayable_amount', function() { 
                var salespayable_amount = $(this).val();
                var sales_grand_total = $(".sales_grand_total").val();
                var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));
            });   




            var sales_branch_id = $(".sales_branch_id").val();
            var sales_customerid = $(".sales_customerid").val();
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
                        console.log(response);
                        var len = response.length;
                        for (var i = 0; i < len; i++) {
                            $(".sales_old_balance").val(response[i].payment_pending);

                            var sales_gross_amount = $(".sales_gross_amount").val();
                            var sales_grand_total = Number(response[i].payment_pending) + Number(sales_gross_amount);
                            $('.sales_grand_total').val(sales_grand_total.toFixed(2));

                            var salespayable_amount = $(".salespayable_amount").val();
                            var sales_pending_amount = Number(sales_grand_total) - Number(salespayable_amount);
                            $('.sales_pending_amount').val(sales_pending_amount.toFixed(2));
                        }
                        
                    }
                });



      });


      


        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }



        $(document).on("keyup", 'input.salespayable_amount', function() {
            var payable_amount = $(this).val();
            var grand_total = $(".sales_grand_total").val();

            if (Number(payable_amount) > Number(grand_total)) {
                alert('You are entering Maximum Amount of Total');
                $(".salespayable_amount").val('');
            }
        });


        $(document).on("keyup", 'input.payable_amount', function() {
            var payable_amount = $(this).val();
            var grand_total = $(".grand_total").val();

            if (Number(payable_amount) > Number(grand_total)) {
                alert('You are entering Maximum Amount of Total');
                $(".payable_amount").val('');
            }
        });


        $(document).on("keyup", 'input.payment_payableamount', function() {
            var payment_payableamount = $(this).val();
            var oldblance = $(".oldblance").val();

            if (Number(payment_payableamount) > Number(oldblance)) {
                alert('You are entering Maximum Amount of Total');
                $(".payment_payableamount").val('');
            }
        });


        $(document).on("keyup", 'input.spayment_payableamount', function() {
            var spayment_payableamount = $(this).val();
            var sales_oldblance = $(".sales_oldblance").val();

            if (Number(spayment_payableamount) > Number(sales_oldblance)) {
                alert('You are entering Maximum Amount of Total');
                $(".spayment_payableamount").val('');
            }
        });


    function purchasesubmitForm(btn) {
        // disable the button
        btn.disabled = true;
        // submit the form
        btn.form.submit();
    }

    function purchasesaveprint(btn) {
        // disable the button
        btn.disabled = true;
        // submit the form
        btn.form.submit();
    }


    function salessubmitForm(btn) {
        // disable the button
        btn.disabled = true;
        // submit the form
        btn.form.submit();
    }


    function salessaveprintForm(btn) {
        // disable the button
        btn.disabled = true;
        // submit the form
        btn.form.submit();
    }



   

   


</script>
