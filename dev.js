jQuery("#spinnerr").hide();
jQuery("#changecurrency").change(function(){
            jQuery("#spinnerr").show();
             jQuery("#curr_change").hide();
             var currencies = jQuery("#changecurrency").val();
             var curr = currencies.split('|');
             var currency_symbol = curr[0];
             var country_code = curr[1];

             jQuery("#receive_amount").attr("placeholder", "Enter Receive Amount("+currency_symbol+")");

             localStorage.setItem("current_currency", currency_symbol);
             localStorage.setItem("country_code", country_code);

             jQuery.ajax({
               type: "GET",
               url: "http://upesi.co.ke/upesi_api/upesi/getExchangeRate.php?currency="+currency_symbol,
               success: function(xmlResponse) {
                 //console.log(xmlResponse);
                 var rate = JSON.parse(xmlResponse);
                 var rate = eval(rate.Rate).toFixed(2);
                  jQuery("#spinnerr").hide();
                 jQuery("#newrate").html("1 USD = "+rate+ "  "+currency_symbol);
               },
               error: function(){
                  jQuery("#spinnerr").hide();
                 alert("Error processing request, Please give us a moment to fix this");
               }
             });
           });

           jQuery("#send_amount").keypress(function(e){
           if(e.which == 13) {
             if (jQuery.isNumeric(jQuery("#send_amount").val()) && localStorage.getItem("current_currency") !== null) {
                jQuery("#pg").html("one moment..");
                var principle_amount = eval(jQuery("#send_amount").val());
                var dest_curr = localStorage.getItem("current_currency");
                var dest_curr_code = localStorage.getItem("country_code");
                var newcharge =  "<GetMTCharge xmlns:i='http://www.w3.org/2001/XMLSchema-instance' xmlns='http://schemas.datacontract.org/2004/07/MTM.DTO'>"
                  +"<ClientPassword>String</ClientPassword>"
                  +"<ClientUsername>String</ClientUsername>"
                  +"<CompanyId>0</CompanyId>"
                  +"<CustomerId>0</CustomerId>"
                  +"<DestinationCountryCode>"+dest_curr_code+"</DestinationCountryCode>"
                  +"<DestinationCurrencyCode>"+dest_curr+"</DestinationCurrencyCode>"
                  +"<PayoutMethod>BankTransfer</PayoutMethod>"
                  +"<PrincipalAmount>"+jQuery("#send_amount").val()+"</PrincipalAmount>"
                  +"<ServiceId>0</ServiceId>"
                +"</GetMTCharge>";

                //"+localStorage.getItem("current_currency")+"

                 var options={};
                 options.url="http://upesi.co.ke/upesi_api/upesi/getCharge.php";
                 options.method="post";
                 options.data=newcharge;
                 options.contentType="text/xml";

                 jQuery.ajax(options).done(function(data){
                   //console.log(data);
                   var charge = jQuery(data).find('Message').text();
                     jQuery.ajax({
                       type: "GET",
                       url: "http://upesi.co.ke/upesi_api/upesi/getExchangeRate.php?currency="+localStorage.getItem("current_currency"),
                       success: function(xmlResponse) {
                         //console.log(xmlResponse);
                         var rate = JSON.parse(xmlResponse).Rate;
                         var tosend = (eval(charge)-principle_amount);
                         var toreceive = Math.abs((tosend*rate)).toFixed(2);
                         //console.log(tosend +" , "+toreceive);
                         jQuery("#receive_amount").val(toreceive);
                       },
                       error: function(){
                           jQuery("#process").html("error, try again later");
                       },
                       complete: function(){
                         jQuery("#pg").html("");
                       }
                     });
                 }).error(function(){
                     jQuery("#process").html("error, try again later");
                     jQuery("#pg").html("");
                 });
               }
             }
           });

           jQuery("#receive_amount").keypress(function(e){
             if(e.which == 13) {
               if (jQuery.isNumeric(jQuery("#receive_amount").val()) && localStorage.getItem("current_currency") !== null) {
                   jQuery("#pg").html("one moment..");
                   var principle_amount = eval(jQuery("#receive_amount").val());
                   var dest_curr = localStorage.getItem("current_currency");
                   var dest_curr_code = localStorage.getItem("country_code");

                   jQuery.ajax({
                       type: "GET",
                       url: "http://upesi.co.ke/upesi_api/upesi/getExchangeRate.php?currency="+localStorage.getItem("current_currency"),
                       success: function(xmlResponse) {
                           //console.log(xmlResponse);
                           var rate = JSON.parse(xmlResponse).Rate;
                           var tosend = (principle_amount/rate);

                           //get charge
                           var newcharge =  "<GetMTCharge xmlns:i='http://www.w3.org/2001/XMLSchema-instance' xmlns='http://schemas.datacontract.org/2004/07/MTM.DTO'>"
                           +"<ClientPassword>String</ClientPassword>"
                           +"<ClientUsername>String</ClientUsername>"
                           +"<CompanyId>0</CompanyId>"
                           +"<CustomerId>0</CustomerId>"
                           +"<DestinationCountryCode>"+dest_curr_code+"</DestinationCountryCode>"
                           +"<DestinationCurrencyCode>"+dest_curr+"</DestinationCurrencyCode>"
                           +"<PayoutMethod>BankTransfer</PayoutMethod>"
                           +"<PrincipalAmount>"+tosend+"</PrincipalAmount>"
                           +"<ServiceId>0</ServiceId>"
                           +"</GetMTCharge>";

                           //"+localStorage.getItem("current_currency")+"

                           var options={};
                           options.url="http://upesi.co.ke/upesi_api/upesi/getCharge.php";
                           options.method="post";
                           options.data=newcharge;
                           options.contentType="text/xml";

                           jQuery.ajax(options).done(function(data){
                               //console.log(data);
                               var charge = eval(jQuery(data).find('Message').text());
                               jQuery("#send_amount").val((tosend+charge).toFixed(2));
                               jQuery("#pg").html("");
                           }).error(function(){
                               jQuery("#process").html("error, try again later");
                              jQuery("#pg").html("");
                           });
                       },
                       error: function(){
                          jQuery("#process").html("error, try again later");
                         jQuery("#pg").html("");
                       }
                   });
               }
             }
           });
