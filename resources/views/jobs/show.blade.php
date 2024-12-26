<x-layout>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <section class="md:col-span-3">
            <div class="rounded-lg shadow-md bg-white p-3">
                <div class="flex justify-between items-center">
                    <a
                        class="block p-4 text-blue-700"
                        href="{{route('jobs.index')}}"
                    >
                        <i class="fa fa-arrow-alt-circle-left"></i>
                        Вернуться назад
                    </a>
                    <div class="flex space-x-3 ml-4">
                        @can('update', $job)
                            <a href="{{route('jobs.edit', $job->id)}}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
                                Редактировать
                            </a>
                            <form method="POST" action="{{route('jobs.destroy', $job->id)}}" onsubmit="return confirm('Are you sure that you want to delete this job?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                                    Удалить
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
                <div class="p-4">
                    <h2 class="text-xl font-semibold">
                        {{$job->title}}
                    </h2>
                    <p class="text-gray-700 text-lg mt-2">
                        {{$job->description}}
                    </p>
                    <ul class="my-4 bg-gray-100 p-4">
                        <li class="mb-2">
                            <strong>Категория товара:</strong> {{$job->job_type}}
                        </li>
                        <li class="mb-2">
                            <strong>Наличие:</strong> {{$job->remote ? 'Yes' : 'No'}}
                        </li>
                        <li class="mb-2">
                            <strong>Стоимость:</strong> ${{number_format($job->salary)}}
                        </li>
                        <li class="mb-2">
                            <strong>Местоположение:</strong> {{$job->city}}, {{$job->state}}
                        </li>
                        @if ($job->tags)
                            <li class="mb-2">
                                <strong>Тэги:</strong> {{ucwords(str_replace(',', ', ', $job->tags))}}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="container mx-auto p-4">
                @if ($job->requirement || $job->benefits)
                    <h2 class="text-xl font-semibold mb-4">Детали</h2>
                    <div class="rounded-lg shadow-md bg-white p-4">
                        <h3
                            class="text-lg font-semibold mb-2 text-blue-500"
                        >
                            Требования
                        </h3>
                        <p>
                            {{$job->requirements}}
                        </p>
                        <h3
                            class="text-lg font-semibold mt-4 mb-2 text-blue-500"
                        >
                            Преимущества
                        </h3>
                        <p>
                            {{$job->benefits}}
                        </p>
                    </div>
                @endif
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <div id="map"></div>
            </div>
        </section>

        <aside class="bg-white rounded-lg shadow-md p-3">
            <h3 class="text-xl text-center mb-4 font-bold">
                Информация о компании
            </h3>
            @if ($job->company_logo)
                <img
                    src="/storage/{{$job->company_logo}}"
                    alt="Ad"
                    class="w-full rounded-lg mb-4 m-auto"
                />
            @endif
            <h4 class="text-lg font-bold">{{$job->company_name}}</h4>
            @if ($job->company_description)
                <p class="text-gray-700 text-lg my-3">
                    {{$job->company_description}}
                </p>
            @endif
            @if ($job->company_website)
                <a
                    href="{{$job->company_website}}"
                    target="_blank"
                    class="text-blue-500"
                    >Посетить сайт компании</a
                >
            @endif

            @guest
                <p class="mt-10 bg-gray-200 text-gray-700 font-bold w-full py-2 px-4 rounded-full text-center">
                    <i class="fas fa-info-circle mr-3"></i> Вы должны быть зарегистрированы, чтобы добавлять товары в корзину
                </p>
            @else
                <form
                    method="POST"
                    action="{{auth()->user()->shoppingCartJobs()->where('job_id', $job->id)->exists()
                    ? route('shoppingCart.destroy', $job->id)
                    : route('shoppingCart.store', $job->id)}}"
                    class="mt-10"
                >
                    @csrf
                    @if (auth()->user()->shoppingCartJobs()->where('job_id', $job->id)->exists())
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold w-full py-2 px-4 rounded-full flex items-center justify-center">
                            <i class="fas fa-bookmark mr-3"></i> Убрать из корзины
                        </button>
                    @else
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold w-full py-2 px-4 rounded-full flex items-center justify-center">
                            <i class="fas fa-bookmark mr-3"></i> Добавить в корзину
                        </button>
                    @endif
                </form>
            @endguest
        </aside>
    </div>
</x-layout>