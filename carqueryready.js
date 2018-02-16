$(document).ready(
    
function()
{
     //Create a variable for the CarQuery object.  You can call it whatever you like.
     var carquery = new CarQuery();

     //Run the carquery init function to get things started:
     carquery.init();
     
     //Optionally, you can pre-select a vehicle by passing year / make / model / trim to the init function:
     //carquery.init('2000', 'dodge', 'Viper', 11636);

     //Optional: Pass sold_in_us:true to the setFilters method to show only US models. 
     carquery.setFilters( {sold_in_us:true} );

     //Optional: initialize the year, make, model, and trim drop downs by providing their element IDs
     carquery.initYearMakeModelTrim('car-years', 'car-makes', 'car-models');

     //Optional: set minimum and/or maximum year options.
     carquery.year_select_min=1941;
     carquery.year_select_max=2018;
 

     //MJ's custom code
     
     $("#car-years").change(function () {
        var text = ($("#car-years :selected").val());
        document.getElementById('input_10_19').value = text;

     });
     
     
     $("#car-makes").change(function () {
        var text = ($("#car-makes :selected").val());
        document.getElementById('input_10_20').value = text;
        
        $("#select2-car-models-container").trigger("updatecomplete");

     });
     

     $("#car-models").change(function () {
        var text = ($("#car-models :selected").val());
        document.getElementById('input_10_21').value = text;

     });

         
     //end MJ's custom code
     
     
     
});
