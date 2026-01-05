<div>
    @if($showHeader)
    <h2 class="text-lg font-semibold mb-4">{{ __('comment.header') }}</h2>
    @endif

    <div class="space-y-3">
        @forelse ($comments as $comment)
            <div class="border rounded p-3">
                <div>
                    <strong>
                        {{ $comment->user->name }}

                        @php
                            $isMe = $comment->user_id === auth()->id();
                            $isTicketOwner = $comment->user_id === $ticket->user_id;
                        @endphp

                        @if ($isMe || $isTicketOwner)
                            <span class="ml-1 text-xs text-gray-500 italic">
                                (
                                @if ($isMe)
                                    {{ __('comment.you') }}
                                @endif

                                @if ($isMe && $isTicketOwner)
                                    /
                                @endif

                                @if ($isTicketOwner)
                                    {{ __('comment.ticket_owner') }}
                                @endif
                                )
                            </span>
                        @endif
                    </strong>
                </div>
                <p class="mt-2 text-gray-800">
                    {{ $comment->body }}
                </p>
                <div class="mt-2 text-sm text-gray-600">
                    {{ $comment->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">
                {{ __('comment.no_comments') }}
            </p>
        @endforelse
    </div>

    @if($allowComment)
    <form wire:submit.prevent="addComment" class="mt-4">
        <x-textarea
            wire:model.defer="comment"
            class="w-full rounded border p-2"
            rows="3"
            placeholder="{{ __('comment.add_comment') }}"
        ></x-textarea>

        <button
            type="submit"
            class="mt-2 px-4 py-2 bg-blue-600 text-white rounded"
        >
            {{ __('comment.comment') }}
        </button>
    </form>
    @endif
</div>
