<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Branch Management</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
	      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
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
					<a class="nav-link" href="{{ route('businesses.index') }}">Business</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="{{ route('branches.index') }}">Branches</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="container mt-4">
	<div class="row">
		<div class="col-12 pt-2">
			<a class="btn btn-primary float-end" href="{{ route('branches.create') }}" role="button">Create Branch</a>
		</div>
	</div>
</div>
<div class="container mt-4">
	
	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif
	
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
	
	<table id="branches-table" class="table table-striped table-bordered" style="width:100%">
		<thead>
		<tr>
			<th>ID</th>
			<th>Branch Name</th>
			<th>Business</th>
			<th>Logo</th>
			<th>Action</th>
		</tr>
		</thead>
	</table>
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
	<script>
        $(document).ready(function () {
            $('#branches-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('branches.index') }}", // Ensure this is the correct route for Branches index
                    type: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'business.name', name: 'business.name'}, // Accessing the business name from the relationship
                    {
                        data: 'images',
                        name: 'images',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            if (data) {
                                let images = Array.isArray(data) ? data : JSON.parse(data); // Parse JSON if it's a string
                                if (images.length > 0) {
                                    return images.map(image => {
                                        return `<img src="${image}" alt="Branch Image" style="width: 50px; height: auto; margin-right: 5px;">`;
                                    }).join('');
                                }
                            }
                            return '';
                        }

                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
	
	</script>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
