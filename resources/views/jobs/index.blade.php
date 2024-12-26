<x-layout>
    <x-slot name='title'>Все товары</x-slot>
    
    {{-- Filter Form --}}
    <form method="GET" action="{{ route('jobs.index') }}" class="mb-4">
        <input type="text" name="productTitle" placeholder="Название товара" value="{{ request('productTitle') }}" class="border p-2">
        <input type="text" name="companyTitle" placeholder="Название компании" value="{{ request('companyTitle') }}" class="border p-2">
        <input type="number" name="minSalary" placeholder="Минимальная стоимость" value="{{ request('minSalary') }}" class="border p-2">
        <input type="number" name="maxSalary" placeholder="Максимальная стоимость" value="{{ request('maxSalary') }}" class="border p-2">
        <button type="submit" class="bg-blue-500 text-white p-2">Найти</button>
        <a href="{{ route('jobs.index') }}" class="bg-red-500 text-white p-2 inline-block">Сбросить</a>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse ($jobs as $job)
            <x-job-card :job="$job"></x-job-card>
        @empty
            <p>Ни один товар не был добавлен.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    {{$jobs->links()}}
</x-layout>