@props(['title'])

<p @class([
    'text-sm leading-5 font-medium',
    'text-slate-900 dark:text-gray-300' => config('notify.theme') === 'light',
    'text-white' => config('notify.theme') !== 'light',
])>
    {{ $title }}
</p>
