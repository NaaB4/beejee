(function($) {
	$("button[name=sendform]").on("click", function(e) {
		e.preventDefault();
		data = {};
		form = $("#pAjax");
		pAjax = form.attr("data-pajax");
		form.find('input, textarea, select').each(function() {
			data[this.name] = $(this).val();
		});

		$.ajax({
			url: "/ajax/"+pAjax,
			type: "post",
			data: data,
			success: function(result) {
				res = JSON.parse(result);
				if(!res["status"]) {
					if(res["isUser"]) location.href = '/';
					if(res["redirect"]) location.href = res["redirect"];
					ajaxError(res["errors"]);
				}
				else {
					if(!res["notRedirect"])
						location.href = '/';
					else 
						$(".alert-success").html(res["message"]).fadeIn();
				}
			}
		});
	});

	$(".task__change-status").on("click", function(e) {
		e.preventDefault();
		_t = $(this);
		_status = _t.closest("div").find(".task_status");
		id = _t.attr("data-id");
		current_status = _t.attr("data-current_status");
		$.ajax({
			url: "/ajax/change-task-status/" + id,
			type: "post",
			data: {"status": current_status},
			success: function(result) {
				res = JSON.parse(result);
				_t.attr("data-current_status", res["newStatus"]);
				_status.html(res["statusIcon"]);
				_t.html(res["statusMessage"]);
			}
		});
	});
})(jQuery);


function ajaxError(errors) {
	$(".invalid-feedback").html("");
	$.each(errors, function(key, val) {
		data = $(".invalid-feedback[for="+key+"]").html(val);
	});
}