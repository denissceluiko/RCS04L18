<div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <form class="p-6" method="post" wire:submit="save">
            @csrf
            <div class="space-y-12">
              <div class="border-b border-gray-900/10 pb-12" x-data="{ newCommentOpen: false }">
                <h2 class="text-base font-semibold leading-7 text-gray-900" @click="newCommentOpen = !newCommentOpen">@lang('New comment')</h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6" x-show="newCommentOpen">
                  <div class="col-span-full">
                    <label for="author" class="block text-sm font-medium leading-6 text-gray-900">@lang('Author')</label>
                    <div class="mt-2">
                        <input type="text" name="author" id="author" wire:model="author" value="{{ old('author') ?? auth()->user()?->name }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset @error('author') ring-red-500 @else ring-gray-300 @enderror placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @error('author')
                            <div class="text-sm text-red-700">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>

                  <div class="col-span-full">
                    <label for="body" class="block text-sm font-medium leading-6 text-gray-900">@lang('Body')</label>
                    <div class="mt-2">
                      <textarea id="body" name="body" wire:model="body" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset @error('body') ring-red-500 @else ring-gray-300 @enderror placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ old('body') }}</textarea>
                      @error('body')
                        <div class="text-sm text-red-700">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">@lang('Create')</button>
                    </div>
                </div>
              </div>
            </div>
        </form>
    </div>
</div>
