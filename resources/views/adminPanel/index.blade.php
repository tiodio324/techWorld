<x-layout>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-6 text-left">Пользователь</th>
                    <th class="py-3 px-6 text-left">E-mail</th>
                    <th class="py-3 px-6 text-left">Товар</th>
                    <th class="py-3 px-6 text-left">Наличие</th>
                    <th class="py-3 px-6 text-left">Статус</th>
                    <th class="py-3 px-6 text-left">Удалить пользователя</th>
                    <th class="py-3 px-6 text-left">Удалить товар</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($users as $user)
                    @foreach ($user->shoppingCartJobs as $job)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $user->name }}</td>
                        <td class="py-3 px-6">{{ $user->email }}</td>
                        <td class="py-3 px-6">{{ $job->title }}</td>
                        <td class="py-3 px-6 {{ $job->remote == true ? 'text-green-500' : 'text-red-500'}}">{{ $job->remote == true ? 'В наличии' : 'Нет в наличии'}}</td>
                        <td class="py-3 px-6">
                            <form method="POST" action="{{route('adminPanel.updateStatus', $job->id)}}">
                                @csrf
                                @method('PATCH')
                                <select name="productStatus" onchange="this.form.submit()" class="bg-gray-200 border border-gray-300 rounded py-1 px-2">
                                    <option value="None" {{ $job->status == 'None' ? 'selected' : ''}}>
                                        None
                                    </option>
                                    <option value="In Cart" {{ $job->status == 'In Cart' ? 'selected' : ''}}>
                                        In Cart
                                    </option>
                                    <option value="To Do" {{ $job->status == 'To Do' ? 'selected' : ''}}>
                                        To Do
                                    </option>
                                    <option value="In Process" {{ $job->status == 'In Process' ? 'selected' : ''}}>
                                        In Process
                                    </option>
                                    <option value="Done" {{ $job->status == 'Done' ? 'selected' : ''}}>
                                        Done
                                    </option>
                                </select>
                            </form>
                        </td>
                        <td class="py-3 px-6">
                            <form method="POST" action="{{route('adminPanel.destroy', $user->id)}}" onsubmit="return confirm('Are you sure that you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-6">
                            <form method="POST" action="{{route('jobs.destroy', $job->id)}}?from=adminPanel" onsubmit="return confirm('Are you sure that you want to delete this job?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500 text-xl">Список пуст</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>