<!-- resources/views/components/input/select.blade.php -->
<select {{ $attributes->merge(['class' => 'form-select block w-full mt-1']) }}>
    {{ $slot }}
</select>
