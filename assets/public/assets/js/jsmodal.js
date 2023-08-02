//////////===== Dynamic Modal Pop-up ===/////////
$(".pop").click(function () {
	$(".modal").on('hidden.bs.modal', function () {
		$(this).data('bs.modal', null);
	});

	var pageTitle = $(this).attr('pageTitle');
	var pageName = $(this).attr('pageName');
	var pageSize = $(this).attr('pageSize');

	$(".modal-dialog").addClass(pageSize);
	$(".modal-center .modal-title").html(pageTitle);
	$(".modal-center .modal-body").html('<div class="row"><div class="text-center col-lg-12"><i class="anticon anticon-loading"></i><br/> Content loading, please wait...</div></div>');
	$(".modal-center .modal-body").load(pageName);
	$(".modal-center").modal("show");
});

$(".pop-right").click(function () {
	$(".modal").on('hidden.bs.modal', function () {
		$(this).data('bs.modal', null);
	});

	var pageTitle = $(this).attr('pageTitle');
	var pageName = $(this).attr('pageName');
	var pageSize = $(this).attr('pageSize');

	$(".modal-dialog").addClass(pageSize);
	$(".modal-right .modal-title").html(pageTitle);
	$(".modal-right .modal-body").html('<div class="row"><div class="text-center col-lg-12"><i class="anticon anticon-loading"></i><br/> Content loading, please wait...</div></div>');
	$(".modal-right .modal-body").load(pageName);
	$(".modal-right").modal("show");
});

$(".pop-left").click(function () {
	$(".modal").on('hidden.bs.modal', function () {
		$(this).data('bs.modal', null);
	});

	var pageTitle = $(this).attr('pageTitle');
	var pageName = $(this).attr('pageName');
	var pageSize = $(this).attr('pageSize');

	$(".modal-dialog").addClass(pageSize);
	$(".modal-left .modal-title").html(pageTitle);
	$(".modal-left .modal-body").html('<div class="row"><div class="text-center col-lg-12"><i class="anticon anticon-loading"></i><br/> Content loading, please wait...</div></div>');
	$(".modal-left .modal-body").load(pageName);
	$(".modal-left").modal("show");
});