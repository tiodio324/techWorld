<x-layout>
    <section class="flex flex-col md:flex-row gap-4">
        <div class="bg-white p-8 rounded-lg shadow-md w-full">
            <h3 class="text-3xl text-center font-bold mb-4">Профиль</h3>
            @if ($user->avatar)
                <div class="mt-2 flex justify-center">
                    <img src="{{asset('storage/' . $user->avatar)}}" alt="logo" class="w-32 h-32 object-cover rounded-full">
                </div>
            @endif
            <form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-inputs.text name="name" id="name" label="Name" value="{{$user->name}}" />
                <x-inputs.text name="email" id="email" label="Email" value="{{$user->email}}" />
                <x-inputs.file name="avatar" id="avatar" label="Upload Avatar" />
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 border rounded focus:outline-none">Save</button>
            </form>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md w-full">
            <h3 class="text-3xl text-center font-bold mb-4">Мои товары</h3>
            @forelse ($jobs as $job)
                <div class="flex justify-between items-center border-b-2 border-gray-200 py2">
                    <div>
                        <h3 class="text-xl font-semibold">{{$job->title}}</h3>
                        <p class="text-gray-700">{{$job->job_type}}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{route('jobs.edit', $job->id)}}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Редактировать</a>
                        <form
                            method="POST"
                            action="{{route('jobs.destroy', $job->id)}}?from=dashboard"
                            onsubmit="return confirm('Are you sure that you want to delete this product?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded text-sm">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-700">Вы не создали ни одного товара</p>
            @endforelse
        </div>
    </section>
    <x-bottom-banner />
</x-layout>