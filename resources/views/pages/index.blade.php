<x-layout>
    <h2 class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">Welcome в ТехноМир</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse ($jobs as $job)
            <x-job-card :job="$job"></x-job-card>
        @empty
            <p>Ни один товар не был добавлен.</p>
        @endforelse
    </div>
    <a href="{{route('jobs.index')}}" class="block text-xl text-center">
        <i class="fa fa-arrow-alt-circle-right">Показать все товары</i>
    </a>
    @auth
        <x-bottom-banner />
    @endauth
</x-layout>