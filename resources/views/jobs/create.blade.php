<x-layout>
    <x-slot name="title">Создать товар</x-slot>

    <div class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl">
        <h2 class="text-4xl text-center font-bold mb-4">
            Создать товар
        </h2>
        <form
            method="POST"
            action="{{route('jobs.store')}}"
            enctype="multipart/form-data"
        >
            @csrf
            <h2
                class="text-2xl font-bold mb-6 text-center text-gray-500"
            >
                Информация о товаре
            </h2>

            <x-inputs.text
                id="title"
                name="title"
                label="Название товара"
                placeholder="Asus"
            />

            <x-inputs.text-area
                id="description"
                name="description"
                label="Описание товара"
                placeholder="Описание..."
            />

            <x-inputs.text
                id="salary"
                type="number"
                name="salary"
                label="Стоимость"
                placeholder="90000"
            />

            <x-inputs.text-area
                id="requirements"
                name="requirements"
                label="Требования"
                placeholder="7+"
            />

            <x-inputs.text-area
                id="benefits"
                name="benefits"
                label="Преимущества"
                placeholder="4k Oled"
            />

            <x-inputs.text
                id="tags"
                name="tags"
                label="Тэги (через запятую)"
                placeholder="Development, Coding, Java, Python"
            />

            <x-inputs.select
                id="job_type"
                name="job_type"
                label="Категория товара"
                value="{{old('job_type')}}"
                :options="[
                    'Full-Time' => 'Full-Time',
                    'Part-Time' => 'Part-Time',
                    'Contract' => 'Contract',
                    'Temporary' => 'Temporary',
                    'Internship' => 'Internship',
                    'Volunteer' => 'Volunteer',
                    'On-Call' => 'On-Call'
                ]"
            />

            <x-inputs.select
                id="remote"
                name="remote"
                label="Наличие"
                :options="[
                    0 => 'Нет',
                    1 => 'Да',
                ]"
            />

            <x-inputs.text
                id="address"
                name="address"
                label="Адрес"
                placeholder="123 Main St"
            />

            <x-inputs.text
                id="city"
                name="city"
                label="Город"
                placeholder="Санкт-Петербург"
            />

            <x-inputs.text
                id="state"
                name="state"
                label="Штат"
                placeholder="NY"
            />

            <x-inputs.text
                id="zipcode"
                name="zipcode"
                label="Индекс"
                placeholder="12201"
            />

            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Информация о компании
            </h2>

            <x-inputs.text
                id="company_name"
                name="company_name"
                label="Название компании"
                placeholder="Эльдорадо"
            />

            <x-inputs.text-area
                id="company_description"
                name="company_description"
                label="Описание компании"
                placeholder="Описание..."
            />

            <x-inputs.text
                id="company_website"
                type="url"
                name="company_website"
                label="Сайт компании"
                placeholder="https://www.eldorado.ru/"
            />

            <x-inputs.text
                id="contact_phone"
                name="contact_phone"
                label="Контактный телефон"
                placeholder="+79818453234"
            />

            <x-inputs.text
                id="contact_email"
                type="email"
                name="contact_email"
                label="Контактная почта"
                placeholder="eldorage@gmail.com"
            />

            <x-inputs.file
                id="company_logo"
                name="company_logo"
                label="Логотип компании"
            />

            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                Создать
            </button>
        </form>
    </div>
</x-layout>