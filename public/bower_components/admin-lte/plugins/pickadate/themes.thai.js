$(document).ready(function(){
    $('.datepicker').pickadate({
		monthsFull: [ 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม' ],
		monthsShort: [ 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.' ],
		weekdaysFull: [ 'อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์' ],
		weekdaysShort: [ 'อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.' ],
		today: 'วันนี้',
		clear: 'ลบ',
		format: 'd mmmm yyyy',
		formatSubmit: 'yyyy-mm-dd',
		dateFormat: "yyyy-mm-dd",
		//min:true,
		
		selectMonths: true,
		selectYears: 100,
		onOpen: function(){
			$('.picker__header select:first-child option').each(function(){
					var yearBE = parseInt($(this).val())+543;
					$(this).html(yearBE);
			});
		},
		onSet: function(data){
			$('.picker__header select:first-child option').each(function(){
				var yearBE = parseInt($(this).val())+543;
				$(this).html(yearBE);
			});
		},
		onClose: function(data){
			$('.picker__input').each(function(){
				var today = new Date();
				var d = $(this).val().split(" ");
				if(d[2]<=today.getFullYear()) {
					var newd = d[0] + " " + d[1] + " " + (parseInt(d[2])+543);
					$(this).val( newd );
				}
			});
		}
	});
  });