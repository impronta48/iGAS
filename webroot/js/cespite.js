$('document').ready(function(){

	$("#CespiteAddForm,#CespiteEditForm,#CespitecalendarioEventaddForm,#CespitecalendarioEventeditForm,#CespitecalendarioCalendarForm").validate({
		rules:{
			required:{
				required: true
			}
		},
		errorClass: "help-inline text-danger",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.form-group').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error');
			$(element).parents('.form-group').addClass('has-success');
		}
    });
    
});