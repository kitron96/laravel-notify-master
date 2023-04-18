@props(['content'])

<p @class([
    'mt-1 text-sm leading-5',
    'text-slate-500 dark:text-gray-400' => config('notify.theme') === 'light',
    'text-white' => config('notify.theme') !== 'light',
])>
    {{ $content }}
</p>
