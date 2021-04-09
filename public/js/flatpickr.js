$(document ).ready(function(){    
    //custome flatpickr
    flatpickr(".date input", {   
        dateFormat: "d-m-Y",
        locale: {
            // firstDayOfWeek: 1,
            weekdays: {
              shorthand: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
              longhand: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],         
            }, 
            months: {
              shorthand: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
              longhand: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            },
          },    
    });
    flatpickr(".date-noHour input", {
        dateFormat: "d-m-Y",
        time_24hr: true,
        locale: {
            // firstDayOfWeek: 1,
            weekdays: {
              shorthand: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
              longhand: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
            }, 
            months: {
              shorthand: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
              longhand: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            },
          },    
    });
    flatpickr(".date-range input", {
        mode: "range",
        // minDate: "today",
        dateFormat: "d-m-Y",
        /*disable: [
            function(date) {
                // disable every multiple of 8
                return !(date.getDate() % 8);
            }
        ],*/
        locale: {
            // firstDayOfWeek: 1,
            weekdays: {
              shorthand: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
              longhand: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],         
            }, 
            months: {
              shorthand: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
              longhand: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            },
          },    
    });


 
});