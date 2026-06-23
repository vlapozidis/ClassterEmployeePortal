@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-[#E4E4E7]']) }}>
    {{ $value ?? $slot }}
</label>
