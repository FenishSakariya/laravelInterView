<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Create Branch</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
	      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<style>
        .bg-primary-custom {
            background-color: #30a539;
            color: white;
        }

        .btn-primary-custom {
            background-color: #30a539;
            border-color: #30a539;
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #248000;
            border-color: #248000;
            color: white;
        }

        .bg-light-custom {
            background-color: #f7f7f7;
        }

        .invalid-feedback {
            color: #dc3545;
        }

        .section-header {
            color: #30a539;
            font-weight: bold;
        }

        .form-control:focus {
            border-color: #30a539;
            box-shadow: 0 0 0 0.25rem rgba(66, 179, 0, 0.25);
        }
	</style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-primary-custom text-white">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">Business Management</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
		        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link text-white active" aria-current="page" href="#">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-white" href="{{ route('businesses.index') }}">Business</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-white" href="{{ route('branches.index') }}">Branches</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="container mt-5">
	<div class="row">
		<div class="col-12">
			<h2 class="text-center section-header">Create Branch</h2>
		</div>
	</div>
	
	<div class="row mt-3">
		<div class="col-12">
			@if(session('error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					{{ session('error') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif
			@if ($errors->any())
				<div class="alert alert-danger">
					@foreach ($errors->all() as $error)
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							{{ $error }}
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					@endforeach
				</div>
			@endif
			
			<div class="card shadow-sm">
				<div class="card-body">
					<form id="business-form" action="{{ route('branches.store') }}" method="POST"
					      enctype="multipart/form-data">
						@csrf
						
						<div class="mb-3">
							<label for="business_id" class="form-label">Select Business</label>
							<select class="form-select @error('business_id') is-invalid @enderror" id="business_id"
							        name="business_id">
								<option value="">Select a business</option>
								@foreach($businesses as $id => $business)
									<option value="{{ $id }}">{{ $business }}</option>
								@endforeach
							</select>
							@error('business_id')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="mb-3">
							<label for="name" class="form-label">Branch Name</label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
							       name="name" value="{{ old('name') }}">
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="images" class="form-label">Branch Images</label>
							<input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images"
							       name="images[]" accept="image/*" multiple>
							@error('images.*')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="row mt-4">
							<h3 class="text-center section-header">Branch Timings</h3>
							@foreach($days as $day)
								<div class="col-12 mb-3">
									<div class="row">
										<div class="col-md-2 py-3">
											<div class="form-check">
												<input class="form-check-input {{$day}}-checkbox" data-type="{{$day}}"
												       type="checkbox" value="" id="{{$day}}-checkbox-id">
												<label class="form-check-label"
												       for="{{$day}}-checkbox-id">{{ ucfirst($day) }}</label>
											</div>
										</div>
										<div class="col-md-10">
											<div class="row {{$day}}-first">
												<div class="col-md-12 py-3">
													<span class="text-muted">Unavailable</span>
												</div>
											</div>
											
											<div class="row {{$day}}-second d-none">
												<div class="col-md-10">
													<table class="table table-bordered {{$day}}-table">
														<thead>
														<tr>
															<th>Start Time</th>
															<th>End Time</th>
															<th class="text-center">Remove</th>
														</tr>
														</thead>
														<tbody id="{{$day}}-time-body">
														<tr class="first-row">
															<td><input type="time" class="form-control start_date"
															           name="{{$day}}[start_date][]"></td>
															<td><input type="time" class="form-control end_date"
															           name="{{$day}}[end_date][]"></td>
															<td class="text-center">
																Not Remove <br>
																(At list one needed)
															</td>
														</tr>
														</tbody>
													</table>
												</div>
												<div class="col-md-2">
													<button type="button"
													        class="float-end btn btn-success btn-sm add-time"
													        data-day="{{$day}}">Add Time
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary m-1" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary-custom">Save Branch</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        $('.form-check-input').on('change', function () {
            const day = $(this).data('type');
            const isChecked = $(this).prop('checked');

            if (isChecked) {
                $(`.${day}-first`).hide();
                $(`.${day}-second`).removeClass('d-none').show();
            } else {
                $(`.${day}-first`).show();
                $(`.${day}-second`).addClass('d-none').hide();
            }
        });

        $('.add-time').on('click', function () {
            const day = $(this).data('day');
            const newRow = `
                <tr>
                    <td><input type="time" class="form-control start_date" name="${day}[start_date][]"></td>
                    <td><input type="time" class="form-control end_date" name="${day}[end_date][]"></td>
                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-time">Remove</button></td>
                </tr>
            `;
            $(`#${day}-time-body`).append(newRow);
        });

        $(document).on('click', '.remove-time', function () {
            $(this).closest('tr').remove();
        });

        $('#business-form').on('submit', function (e) {
            e.preventDefault();

            $('.invalid-feedback').remove();
            $('.form-control').removeClass('is-invalid');

            let isValid = true;

            const businessId = $('#business_id').val();
            if (!businessId) {
                isValid = false;
                $('#business_id').addClass('is-invalid');
                $('#business_id').after('<div class="invalid-feedback">Please select a business.</div>');
            }

            const branchName = $('#name').val();
            if (!branchName) {
                isValid = false;
                $('#name').addClass('is-invalid');
                $('#name').after('<div class="invalid-feedback">Branch name is required.</div>');
            }

            const images = $('#images')[0].files;
            if (images.length === 0) {
                isValid = false;
                $('#images').addClass('is-invalid');
                $('#images').after('<div class="invalid-feedback">At least one image is required.</div>');
            }

            $('.form-check-input:checked').each(function () {
                const day = $(this).data('type');
                const rows = $(`#${day}-time-body tr`);

                rows.each(function () {
                    const startTime = $(this).find('.start_date').val();
                    const endTime = $(this).find('.end_date').val();

                    if (startTime && endTime && startTime === endTime) {
                        isValid = false;
                        $(this).find('.start_date').addClass('is-invalid');
                        $(this).find('.end_date').addClass('is-invalid');
                        $(this).after('<div class="invalid-feedback">Start time and End time cannot be the same.</div>');
                    }

                    if (startTime && endTime && endTime <= startTime) {
                        isValid = false;
                        $(this).find('.start_date').addClass('is-invalid');
                        $(this).find('.end_date').addClass('is-invalid');
                        $(this).after('<div class="invalid-feedback">End time must be greater than start time.</div>');
                    }
                });
            });

            if (isValid) {
                $(this).off('submit').submit();
            }
        });
    });

</script>
</body>
</html>

