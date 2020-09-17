$(document).ready(function () {
 $("#dt1").datepicker({
            dateFormat: "dd.mm.yy",
            minDate: 0,
            onSelect: function (date) {
                var date2 = $('#dt1').datepicker('getDate');
                date2.setDate(date2.getDate() + 1);
               // $('#dt2').datepicker('setDate', date2);
                //sets minDate to dt1 date + 1
                $('#dt2').datepicker('option', 'minDate', date2);
            }
        });
        $('#dt2').datepicker({

            dateFormat: "dd.mm.yy",
            onSelect: function (date) {
                var date3 = $('#dt2').datepicker('getDate');
                date3.setDate(date3.getDate() + 1);
                console.log(date3);
               // $('#dt2').datepicker('setDate', date2);
                //sets minDate to dt1 date + 1
                $('#dt3').datepicker('option', 'minDate', date3);
            },
            onClose: function () {
                var dt1 = $('#dt1').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#dt2').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#dt2').datepicker('option', 'minDate');
                   // $('#dt2').datepicker('setDate', minDate);
                }
            }
        });
         $('#dt3').datepicker({
            dateFormat: "dd.mm.yy",
            onSelect: function (date) {
                var date4 = $('#dt3').datepicker('getDate');
                date4.setDate(date4.getDate() + 1);
                
               // $('#dt2').datepicker('setDate', date2);
                //sets minDate to dt1 date + 1
                $('#dt4').datepicker('option', 'minDate', date4);
            },
            onClose: function () {
                var dt1 = $('#dt1').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#dt2').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#dt2').datepicker('option', 'minDate');
                   // $('#dt2').datepicker('setDate', minDate);
                }
            }
        });
          $('#dt4').datepicker({
            dateFormat: "dd.mm.yy",
             onSelect: function (date) {
                var date5 = $('#dt4').datepicker('getDate');
                date5.setDate(date5.getDate() + 1);
                
               // $('#dt2').datepicker('setDate', date2);
                //sets minDate to dt1 date + 1
                $('#dt5').datepicker('option', 'minDate', date5);
            },
            onClose: function () {
                var dt1 = $('#dt1').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#dt2').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#dt2').datepicker('option', 'minDate');
                   // $('#dt2').datepicker('setDate', minDate);
                }
            }
        });
           $('#dt5').datepicker({
            dateFormat: "dd.mm.yy",
             onSelect: function (date) {
                var date6 = $('#dt5').datepicker('getDate');
                date6.setDate(date6.getDate() + 1);
               
               // $('#dt2').datepicker('setDate', date2);
                //sets minDate to dt1 date + 1
                $('#dt6').datepicker('option', 'minDate', date6);
            },
            onClose: function () {
                var dt1 = $('#dt1').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#dt2').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#dt2').datepicker('option', 'minDate');
                   // $('#dt2').datepicker('setDate', minDate);
                }
            }
        });
            $('#dt6').datepicker({
            dateFormat: "dd.mm.yy",

            onClose: function () {
                var dt1 = $('#dt1').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#dt2').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#dt2').datepicker('option', 'minDate');
                   // $('#dt2').datepicker('setDate', minDate);
                }
            }
        });

});