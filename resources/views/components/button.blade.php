<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-success px-4 py-2 text-sm text-white']) }}>
    {{ $slot }}
</button>
