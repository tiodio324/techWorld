<x-layout>
    <div class="bg-white rounded-lg shadow-md w-full md:max-w-xl mx-auto mt-12 p-8 py12">
        <h2 class="text-4xl text-center font-bold mb-4">
            Вход
        </h2>
        <form action="{{route('login.auth')}}" method="POST">
            @csrf
            <x-inputs.text id="email" name="email" type="email" placeholder="E-mail" />
            <x-inputs.text id="password" name="password" type="password" placeholder="Password" />

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded focus:outline-none">Войти</button>
            <p class="mt-4 text-gray-400">
                Нет аккаунта?
                <a class="text-blue-900 hover:underline" href="{{route('register')}}">Зарегистрироваться здесь</a>
            </p>
        </form>
    </div>
</x-layout>