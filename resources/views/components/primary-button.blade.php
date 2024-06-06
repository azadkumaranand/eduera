<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-dark mt-2']) }}>
    {{ $slot }}
</button>
