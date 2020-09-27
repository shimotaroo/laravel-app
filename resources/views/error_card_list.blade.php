@if ($errors->any())
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 mx-auto card-text text-left alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
