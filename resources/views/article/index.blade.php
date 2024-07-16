<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center justify-end gap-x-6">
                        <form action="{{ route('article.index') }}" method="get">
                            <select name="c">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if(request('c') == $category->id) selected="selected" @endif>{{ $category->name }}</option>
                                @endforeach
                                <option value="">Reset</option>
                            </select>
                            <x-secondary-button type="submit">@lang('Filter')</x-secondary-button>
                        </form>
                        <a href="{{ route('article.create') }}"><x-primary-button>@lang('Create')</x-primary-button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    @lang('Title')
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    @lang('Categories')
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    @lang('Author')
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    @lang('Actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $article->title }}
                                </th>
                                <td class="px-6 py-4">
                                    @foreach ($article->categories as $category)
                                    <span style="background-color: {{ $category->color ?? '#7659fe'}}" class="text-black text-sm font-medium me-2 px-2.5 py-0.5 rounded">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    {{ $article->author->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('article.show', $article) }}">@lang('View')</a>
                                    @can('update', $article)<a href="{{ route('article.edit', $article) }}">@lang('Edit')</a>@endcan
                                    @can('delete', $article)
                                    <form action="{{ route('article.destroy', $article) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <input type="submit" class="text-red-500 cursor-pointer" value="@lang('Delete')">
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
