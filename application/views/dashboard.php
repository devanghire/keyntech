<div class="flex-grow-1 bg-light p-4">
	<div class="container">
		<h2><?php echo "Hi " . $userName ?></h2>
		<h3>
			<?php if ($userRole == 1 || $userRole == 2) { ?>
				<a class="btn btn-primary categoryModel">Add Item</a>
			<?php
			} ?>
			<a href="<?php echo base_url('login/logout') ?>" class="btn btn-primary">Logout</a>
		</h3>
		<h3 class="error_or_success_essage"></h3>
		<div style="padding: 20px;border: 1px solid lightgray;">
			<h2><?php echo $title; ?></h2>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Category</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody class="tablebody">
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- The Modal -->
<div class="modal fade" id="categoryModel" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Data</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form class="form-horizontal form-bordered categoryForm">
				<div class="modal-body model_centers">
					<div class="form-group appendClone">
						<div class="row rowforClone">
							<label for="pwd" class="col-sm-2">Category Name:</label>
							<div class="col-sm-3">
								<input type="text" class="form-control category_name" name="category_name[]" placeholder="Enter Category Name">
							</div>

							<label class="col-sm-2">Parent Caregory:</label>
							<div class="col-sm-3">
								<select class="form-control selected_category_list" name="selected_category[]">
									<option value="0">Add New Or Select</option>
									<option>2</option>
								</select>
							</div>
							<div class="col-sm-1">
								<a href="javascript:void(0)" class="btn btn-secondary btn-sm addNew" id="addNew">+</a>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="javascript:void(0)" class="btn btn-success btnAddCategory">Submit</a>
						<button type="button" class="btn btn-default btncloseCategory" data-dismiss="modal">Close</button>
					</div>
			</form>
		</div>
	</div>
</div>

<script>
	const userRole = '<?php echo $userRole ?>';

	$(".btnAddCategory").on("click", function(event) {
		const formData = {};
		$(".error").remove();
		var flag = 1;

		$(".categoryForm").serializeArray().forEach(function(field) {

			if (formData[field.name]) {
				if (!Array.isArray(formData[field.name])) {
					formData[field.name] = [formData[field.name]];
				}
				formData[field.name].push(field.value);
			} else {
				if (field.value.length == 0) {
					$(".rowforClone:last").after('<span class="error"> Please enter the category</span>');
					flag = 0;
				} else {
					formData[field.name] = field.value;
				}
			}
		});

		if (flag == 1) {
			$.ajax({
				complete: function() {
					getAllCategory();
				},
				type: 'POST',
				url: '<?php echo base_url('api/Category_api/add'); ?>',
				data: formData,
				dataType: 'json',
				async: false,
				success: function(data) {
					if (data.ResponseCode == 200) {
						clearInputs();
						$("#categoryModel").modal('hide');
						$(".error_or_success_essage").addClass('text-success').html('<span class="msgData">' + data.Message + '</span>');
						$(".msgData").fadeOut(5000);
					} else {
						$(".rowforClone:last").after('<span class="error">' + data.Message + '</span>');
						return false;
					}
				},
				error: function(xhr, status, error) {
					alert(error);
				}

			});
		}


	});

	$(document).on('click', '.deleteData', function() {
		let categoryId = $(this).attr('data-value');
		let categoryText = $(this).attr('data-catname');
		let isConfirmed = confirm("Are you sure to delete : - " + categoryText);
		if (isConfirmed) {
			$.ajax({
				type: 'delete',
				url: '<?php echo base_url('api/Category_api/remove/'); ?>' + categoryId,
				data: "",
				dataType: 'json',
				async: false,

				success: function(data) {
					if (data.ResponseCode == 200) {
						$(".error_or_success_essage").addClass('text-success').text(data.Message).fadeOut(5000);
					} else {
						$(".error_or_success_essage").addClass('text-danger').text(data.Message).fadeOut(5000);
					}
					getAllCategory();
				},
				error: function(xhr, status, error) {}
			});
		}
	});



	function checkCategoryName(categoryText) {
		$(".error").remove();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url('api/Category_api/categoryExist'); ?>',
			data: ({
				category_name: categoryText
			}),
			dataType: 'json',
			async: false,

			success: function(data) {
				if (data.ResponseCode == 200) {
					$(".rowforClone:last").after('<span class="error"> (' + categoryText + ') ' + data.Message + '</span>');
					$(".btnAddCategory").addClass("disabledbtn");
					return false;
				} else {

					$(".btnAddCategory").removeClass("disabledbtn");
				}
			},
			error: function(xhr, status, error) {}
		});
	}
	$(".categoryModel").click(function() {
		$.ajax({

			type: 'GET',
			url: '<?php echo base_url('api/Category_api/getCategoryNameList'); ?>',
			data: "",
			dataType: 'json',
			async: false,
			success: function(data) {
				$("#categoryModel").modal('show');
				let htmlList = '<option value="0">Add New Or Select</option>';
				$.each(data.Records.data, function(index, parent) {
					htmlList += '<option value="' + parent.id + '">' + parent.name + '</option>';
				});

				$('.selected_category_list').html(htmlList);
			},
			error: function(xhr, status, error) {
				//do here on error
			}
		});
	});

	$(document).on('click', '.editData', function() {
		let categoryId = $(this).attr('data-value');
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url('api/Category_api/getSingleData'); ?>',
			data: ({
				categoryId: categoryId
			}),
			dataType: 'json',
			async: false,

			success: function(data) {
				if (data.ResponseCode == 200) {
					$("#categoryModel").modal('show');
					$(".appendClone").html(data.Records);

				} else {
					$(".error_or_success_essage").addClass('text-danger').text(data.Message).fadeOut(5000);
				}
				getAllCategory();
			},
			error: function(xhr, status, error) {}
		});
	});


	function getAllCategory() {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url('api/Category_api'); ?>',
			data: "",
			dataType: 'json',
			async: false,
			success: function(data) {
				var html = '';
				if (data.ResponseCode == 200) {
					$.each(data.Records, function(index, parent) {
						html += '<tr>';
						html += '<td><ul id="myUL">';
						html += '<li><span class="caret">' + parent.name + '</span>';
						if (parent.children.length > 0) {
							html += '<ul class="nested">';
							$.each(parent.children, function(indexChild, child) {
								html += '<li>' + child.name + '</li>';
							});
							html += '</ul>';
						}
						html += '</li>';
						html += '</ul></td>';
						html += '<td>';
						html += '<div class="btn-group">';
						if (userRole == 1 || userRole == 2) {
							html += '<a href="javascript:void(0)" class="btn btn-info btn-sm editData" data-value="' + parent.id + '">Edit</a>';
							html += '<a href="javascript:void(0)" class="btn btn-danger btn-sm deleteData" data-catname="' + parent.name + '" data-value="' + parent.id + '">Delete</a>';
						}
						html += '</div>';
						html += '</td>';
						html += '</tr>';
					});
				} else {
					html += '<tr><td colspan="2">NO DATA FOUND</td></tr>';
				}
				$(".tablebody").html(html);
			},
			error: function(xhr, status, error) {}
		});
	}
</script>