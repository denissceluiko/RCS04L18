<div>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-28" wire:poll.5s>
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

    <livewire:create-comment :article="$article" />
</div>
