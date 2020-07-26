@extends('app')

@section('title', 'プロフィール編集')

@section('content')
    @include('nav')
    <div class="row">
        <div class="container col-lg-6 col-md-8 col-sm-10 col-xs-11 mx-auto">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">プロフィール編集</span></h2>
                    <p class="mt-4">Profile Edit</p>
                </div>

                @include('error_card_list')

                <div class="mt-5">

                        <div class="card-body align-items-center mt-2 mb-3">
                            <form action="{{ route('users.update', ['name' => $user->name]) }}" method="POST">
                                @method('PATCH')
                                @csrf
                                {{-- 編集フォーム --}}
                                <div class="ml-4">
                                    <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                                        <img src="{{ asset('storage/'.$user->image) }}" alt="Contact Person" class="img-fuild rounded-circle" width="60" height="60">
                                    </a>
                                </div>
                                <h2 class="h5 card-title ml-3 mb-0">
                                    <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                                        {{ $user->name }}
                                    </a>
                                </h2>
                                <button type="submit" class="btn btn-block cyan darken-3 text-white col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-3 mb-5 waves-effect">
                                    更新する
                                </button>
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection
