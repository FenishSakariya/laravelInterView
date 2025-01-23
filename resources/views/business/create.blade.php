<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bootstrap demo</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
	      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">Business management</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
		        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="#">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ route('businesses.index') }}">Business</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ route('branches.index') }}">Branches</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="col-12 pt-5">
		<div class="card">
			<div class="card-body">
				<form id="business-form" action="{{ route('businesses.store') }}" method="POST"
				      enctype="multipart/form-data">
					@csrf
					<div class="col-md-12">
						<div class="mb-3">
							<label for="name" class="form-label">Name</label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
							       name="name" value="{{ old('name') }}">
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
							       name="email" value="{{ old('email') }}">
							@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="phone" class="form-label">Phone</label>
							<input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
							       name="phone" value="{{ old('phone') }}">
							@error('phone')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="logo" class="form-label">Logo</label>
							<input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
							       name="logo" accept="image/*">
							@error('logo')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save Business</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@ 5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('#business-form').on('submit', function (e) {
            e.preventDefault();

            $('.invalid-feedback').remove();
            $('.form-control').removeClass('is-invalid');

            let isValid = true;

            if ($('#name').val().trim() === '') {
                $('#name').addClass('is-invalid');
                $('#name').after('<div class="invalid-feedback">Name is required.</div>');
                isValid = false;
            }

            const emailPattern = /^[\w\.-]+@[\w\.-]+\.\w{2,6}$/;
            if (!emailPattern.test($('#email').val())) {
                $('#email').addClass('is-invalid');
                $('#email').after('<div class="invalid-feedback">Please enter a valid email address.</div>');
                isValid = false;
            }

            if ($('#phone').val().trim() === '') {
                $('#phone').addClass('is-invalid');
                $('#phone').after('<div class="invalid-feedback">Phone number is required.</div>');
                isValid = false;
            }

            if (isValid) {
                this.submit();
            }
        });

        $('#name, #email, #phone').on('input', function () {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
    });
</script>
</body>
</html>