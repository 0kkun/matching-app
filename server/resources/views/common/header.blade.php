<div class="p-3 bg-color-blue-std" id="header-view">
    <div class="d-flex justify-content-between">
        <div class="h3">
            <i class="fas fa-paw pr-2 pl-2 text-white"></i>
            <a class="text-white font-coda-caption" style="text-decoration: none;" href="{{ route('home.index') }}">Matching Service</a>
        </div>
        <div>
            {{-- ログインしているならログアウトボタンを表示 --}}
            @if (Auth::check())
                <div class="btn btn-primary mr-2">
                    <a class="text-white" style="text-decoration: none;" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            {{-- ログインしていないならログイン・新規登録ボタンを表示 --}}
            @else
                <div class="btn btn-primary mr-2">
                    <a class="text-white" style="text-decoration: none;" href="{{ route('login') }}">Login</a>
                </div>
                <div class="btn btn-primary mr-2">
                    <a class="text-white" style="text-decoration: none;" href="{{ route('register') }}">Resgister</a>
                </div>
            @endif
        </div>
    </div>
</div>