<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form class="p-6" method="post" action="{{ route('article.update', $article) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="space-y-12">
                      <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">@lang('Edit article')</h2>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                          <div class="col-span-full">
                            <label for="title" class="block text-sm font-medium leading-6 text-gray-900">@lang('Title')</label>
                            <div class="mt-2">
                                <input type="text" name="title" id="title" value="{{ $article->title }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset  @error('title') ring-red-500 @else ring-gray-300 @enderror placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            @error('title')
                                <div class="text-sm text-red-700">{{ $message }}</div>
                            @enderror
                          </div>

                          <div class="col-span-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">@lang('Upload photo')</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="article_photo">
                          </div>

                          <div class="col-span-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">@lang('Upload document')</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="article_document">
                          </div>

                          <div class="col-span-full">
                            <label for="body" class="block text-sm font-medium leading-6 text-gray-900">@lang('Body')</label>
                            <div class="mt-2">
                              <textarea id="body" name="body" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset  @error('body') ring-red-500 @else ring-gray-300 @enderror  placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ $article->body }}</textarea>
                              @error('body')
                                    <div class="text-sm text-red-700">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" class="text-sm font-semibold leading-6 text-gray-900"><a href="{{ route('article.index') }}">@lang('Cancel')</a></button>
                        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">@lang('Save')</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div>
                        <form action="{{ route('article.attach', $article) }}" method="post">
                            @csrf
                            <div class="col-span-full">
                                <x-input-label for="name" :value="__('Name')" />
                                <select name="category_id">
                                    @forelse ($article->availableCategories() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                        <option value="" disabled>No categories available</option>
                                    @endforelse
                                </select>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                <x-primary-button class="ms-3">
                                    {{ __('Attach') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-2">
                        @forelse ($article->categories as $category)
                            <div style="background-color: {{ $category->color ?? '#7659fe'}}" class="text-primary text-sm font-medium me-2 px-2.5 py-0.5 rounded inline">
                                <span>{{ $category->name }}</span>
                                <span>
                                    <form action="{{ route('article.detach', $article) }}" method="post" class="inline">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                                        <input type="submit" value="x" class="cursor-pointer">
                                    </form>
                                </span>
                            </div>
                        @empty
                            <span>@lang('Article has no categories assigned')</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
