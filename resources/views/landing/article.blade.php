@extends('layouts.landing')

@section('content')
<div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
    <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><g fill="#FF2D20"><path d="M24 8.25a.5.5 0 0 0-.5-.5H.5a.5.5 0 0 0-.5.5v12a2.5 2.5 0 0 0 2.5 2.5h19a2.5 2.5 0 0 0 2.5-2.5v-12Zm-7.765 5.868a1.221 1.221 0 0 1 0 2.264l-6.626 2.776A1.153 1.153 0 0 1 8 18.123v-5.746a1.151 1.151 0 0 1 1.609-1.035l6.626 2.776ZM19.564 1.677a.25.25 0 0 0-.177-.427H15.6a.106.106 0 0 0-.072.03l-4.54 4.543a.25.25 0 0 0 .177.427h3.783c.027 0 .054-.01.073-.03l4.543-4.543ZM22.071 1.318a.047.047 0 0 0-.045.013l-4.492 4.492a.249.249 0 0 0 .038.385.25.25 0 0 0 .14.042h5.784a.5.5 0 0 0 .5-.5v-2a2.5 2.5 0 0 0-1.925-2.432ZM13.014 1.677a.25.25 0 0 0-.178-.427H9.101a.106.106 0 0 0-.073.03l-4.54 4.543a.25.25 0 0 0 .177.427H8.4a.106.106 0 0 0 .073-.03l4.54-4.543ZM6.513 1.677a.25.25 0 0 0-.177-.427H2.5A2.5 2.5 0 0 0 0 3.75v2a.5.5 0 0 0 .5.5h1.4a.106.106 0 0 0 .073-.03l4.54-4.543Z"/></g></svg>
</div>

<div class="pt-3 sm:pt-5">
    <img class="h-auto max-w-lg rounded-lg" src="{{ $article->image_url }}" alt="">
    <h2 class="text-xl font-semibold text-black dark:text-white">{{ $article->title }}</h2>

    <p class="mt-4 text-sm/relaxed">{{ $article->body }}</p>
</div>

<div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-28">
    <h4>@lang('Comments')</h4>
    @forelse ($article->comments as $comment)
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-3 mb-2">
        <div class="text-lg font-semibold leading-7 text-gray-900">{{ $comment->author }}<span class="font-normal ml-5 text-xs">{{$comment->created_at->format('d.m.Y. H:i:s') }}</span></div>
        <div class="text-base text-gray-900">{{ $comment->body }}</div>
    </div>
    @empty
        <div class="text-base font-semibold leading-7 text-gray-900 my-5">@lang('Article has no comments')</div>
    @endforelse
</div>

<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <form class="p-6" method="post" action="{{ route('comment.store', $article) }}">
            @csrf
            <div class="space-y-12">
              <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">@lang('New comment')</h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                  <div class="col-span-full">
                    <label for="author" class="block text-sm font-medium leading-6 text-gray-900">@lang('Author')</label>
                    <div class="mt-2">
                        <input type="text" name="author" id="author" value="{{ old('author') ?? auth()->user()?->name }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset @error('author') ring-red-500 @else ring-gray-300 @enderror placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @error('author')
                            <div class="text-sm text-red-700">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>

                  <div class="col-span-full">
                    <label for="body" class="block text-sm font-medium leading-6 text-gray-900">@lang('Body')</label>
                    <div class="mt-2">
                      <textarea id="body" name="body" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset @error('body') ring-red-500 @else ring-gray-300 @enderror placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ old('body') }}</textarea>
                      @error('body')
                        <div class="text-sm text-red-700">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">@lang('Create')</button>
            </div>
        </form>
    </div>
</div>


@endsection
