<header
    class="bg-orange-900 text-white p-4"
    x-data="{open: false}"
>
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold"><a href="{{url('/')}}">ТехноМир</a></h1>
        <nav class="hidden md:flex items-center space-x-4">
            @if (Auth::user() && Auth::user()->email === 'admin@gmail.com')
                <x-nav-link url="/adminPanel" :active="request()->is('adminPanel')">Админ Панель</x-nav-link>
            @endif
            <x-nav-link url="/jobs" :active="request()->is('jobs')">Все товары</x-nav-link>
            @auth
                <x-nav-link url="/shoppingCart" :active="request()->is('shoppingCart')">Корзина</x-nav-link>
                <x-logout-button />
                <div class="flex items-center space-x-3">
                    <a href="{{route('dashboard')}}">
                        @if (Auth::user()->avatar)
                            <img src="{{asset('storage/' . Auth::user()->avatar)}}" alt="{{Auth::user()->name}}" class="w-10 h-10 rounded-full" />
                        @else
                            <img src="{{asset('storage/avatars/default.jpg')}}" alt="{{Auth::user()->name}}" class="w-10 h-10 rounded-full" />
                        @endif
                    </a>
                </div>
                <x-nav-link url="/jobs/create" :active="request()->is('jobs/create')" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300">
                    <i class="fa fa-edit"></i> Создать
                </x-nav-link>
            @else
                <x-nav-link url="/login" :active="request()->is('login')">Вход</x-nav-link>
                <x-nav-link url="/register" :active="request()->is('register')">Регистрация</x-nav-link>
            @endauth
        </nav>
        <button @click="open = !open" id="hamburger" class="text-white md:hidden flex items-center">
            <i class="fa fa-bars text-2xl"></i>
        </button>
    </div>
    <nav
        x-show="open" @click.away="open = false"
        id="mobile-menu"
        class="md:hidden bg-orange-900 text-white mt-5 pb-4 space-y-2"
    >
        <x-nav-link url="/jobs" :active="request()->is('jobs')" :mobile="true">Все товары</x-nav-link>
        @auth
            <x-nav-link url="/shoppingCart" :active="request()->is('shoppingCart')" :mobile="true">Корзина</x-nav-link>
            <x-nav-link url="/dashboard" :active="request()->is('dashboard')" :mobile="true">Профиль</x-nav-link>
            <x-logout-button />
            <x-nav-link url="/jobs/create" :active="request()->is('jobs/create')" :block="true">Создать</x-nav-link>
        @else
            <x-nav-link url="/login" :active="request()->is('login')" :mobile="true">Вход</x-nav-link>
            <x-nav-link url="/register" :active="request()->is('register')" :mobile="true">Регистрация</x-nav-link>
        @endauth
    </nav>
</header>